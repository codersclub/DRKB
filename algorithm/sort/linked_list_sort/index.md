---
Title: Сортировка связанного списка
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Сортировка связанного списка
============================

    program noname;
     
    type
      PData = ^TData;
      TData = record
        next: PData;
        Name: string[40];
        { ...другие поля данных }
      end;
     
    var
      root: PData; { это указатель на первую запись в связанном списке }
     
    procedure InsertRecord(var root: PData; pItem: PData);
    { вставляем запись, на которую указывает pItem в список начиная
    с root и с требуемым порядком сортировки }
    var
      pWalk, pLast: PData;
    begin
      if root = nil then
      begin
        { новый список все еще пуст, просто делаем запись,
        чтобы добавить root к новому списку }
        root := pItem;
        root^.next := nil
      end { If }
      else
      begin
        { проходимся по списку и сравниваем каждую запись с одной
        включаемой. Нам необходимо помнить последнюю запись,
        которую мы проверили, причина этого станет ясна немного позже. }
        pWalk := root;
        pLast := nil;
     
        { условие в следующем цикле While определяет порядок сортировки!
        Это идеальное место для передачи вызова функции сравнения,
        которой вы передаете дополнительный параметр InsertRecord для
        осуществления общей сортировки, например:
     
        While CompareItems( pWalk, pItem ) < 0 Do Begin
        where
        Procedure InsertRecord( Var list: PData; CompareItems: TCompareItems );
        and
        Type TCompareItems = Function( p1,p2:PData ): Integer;
        and a sample compare function:
        Function CompareName( p1,p2:PData ): Integer;
        Begin
        If p1^.Name < p2^.Name Then
        CompareName := -1
        Else
        If p1^.Name > p2^.Name Then
        CompareName := 1
        Else
        CompareName := 0;
        End;
        }
        while pWalk^.Name < pItem^.Name do
          if pWalk^.next = nil then
          begin
            { мы обнаружили конец списка, поэтому добавляем
            новую запись и выходим из процедуры }
            pWalk^.next := pItem;
            pItem^.next := nil;
            Exit;
          end { If }
          else
          begin
            { следующая запись, пожалуйста, но помните,
            что одну мы только что проверили! }
            pLast := pWalk;
     
            { если мы заканчиваем в этом месте, то значит мы нашли
            в списке запись, которая >= одной включенной. Поэтому
            вставьте ее перед записью, на которую в настоящий момент
            указывает pWalk, которая расположена после pLast. }
            if pLast = nil then
            begin
              { Упс, мы вывалились из цикла While на самой первой итерации!
              Новая запись должна располагаться в верхней части списка,
              поэтому она становится новым корнем (root)! }
              pItem^.next := root;
              root := pItem;
            end { If }
            else
            begin
              { вставляем pItem между pLast и pWalk }
              pItem^.next := pWalk;
              pLast^.next := pItem;
            end; { Else }
            { мы сделали это! }
          end; { Else }
      end; { InsertRecord }
     
    procedure SortbyName(var list: PData);
    var
     
      newtree, temp, stump: PData;
    begin { SortByName }
     
      { немедленно выходим, если сортировать нечего }
      if list = nil then
        Exit;
      { в
      newtree := Nil;}
     
      {********
      Сортируем, просто беря записи из оригинального списка и вставляя их
      в новый, по пути "перехватывая" для определения правильной позиции в
      новом дереве. Stump используется для компенсации различий списков.
      temp используется для указания на запись, перемещаемую из одного
      списка в другой.
      ********}
      stump := list;
      while stump <> nil do
      begin
        { временная ссылка на перемещаемую запись }
        temp := stump;
        { "отключаем" ее от списка }
        stump := stump^.next;
        { вставляем ее в новый список }
        InsertRecord(newtree, temp);
      end; { While }
     
      { теперь помещаем начало нового, сортированного
      дерева в начало старого списка }
      list := newtree;
    end; { SortByName }
    begin
     
      New(root);
      root^.Name := 'BETA';
      New(root^.next);
      root^.next^.Name := 'ALPHA';
      New(root^.next^.next);
      root^.next^.next^.Name := 'Torture';
     
      WriteLn(root^.name);
      WriteLn(root^.next^.name);
      WriteLn(root^.next^.next^.name);
    end.

