---
Title: Процедура заполнения компонента TTreeView данными из TDataSet-совместимой выборки
Author: Delirium, Master_BRAIN@beep.ru
Date: 18.10.2002
---


Процедура заполнения компонента TTreeView данными из TDataSet-совместимой выборки
=================================================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Процедура заполнения компонента TTreeView данными из TDataSet-совместимой выборки
     
    Процедура заполнения компонента TTreeView данными из TDataSet-совместимой
    выборки типа: idNode int, idParentNode int, cNodeName varchar, ...
     
    Важно: корневой узел дерева должен быть первой записью выборки.
     
    Зависимости: Windows, SysUtils, DB, ComCtrls
    Автор:       Delirium, Master_BRAIN@beep.ru, ICQ:118395746, Москва
    Copyright:   Master BRAIN (Delirium)
    Дата:        18 октября 2002 г.
    ***************************************************** }
     
    procedure FillTree(Tree: TTreeView; Query: TDataSet; idNode, idParent,
      cNodeName: string);
    var
      i: integer;
    begin
      // Корневой узел, должен быть первым в выборке Query
      Query.First;
      Tree.Items.Clear;
      Tree.Items.AddObject(nil, Query.FieldByName(cNodeName).AsString,
        Pointer(Query.FieldByName(idNode).asInteger));
      Query.Next;
      while not Query.Eof do
      begin
        i := 0;
        while i < Tree.Items.Count do
          if Tree.Items.Item[i].Data = Pointer(Query.FieldByName(idParent).asInteger)
            then
          begin
            Tree.Items.AddChildObject(Tree.Items.Item[i],
              Query.FieldByName(cNodeName).AsString,
              Pointer(Query.FieldByName(idNode).asInteger));
            break;
          end
          else
            Inc(i);
        Query.Next;
      end;
    end;

Пример использования:

    FillTree(TreeView1, ADOQuery1, 'idDoc', 'idParentDoc', 'cDocument');
