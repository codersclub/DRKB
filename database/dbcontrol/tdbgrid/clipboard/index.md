---
Title: Копирование информации из TDBGrid-а в Clipboard
Date: 01.01.2007
---


Копирование информации из TDBGrid-а в Clipboard
===============================================

::: {.date}
01.01.2007
:::

Простая процедура копирования информации из DBGrid-а в Clipboard может
существенно облегчить жизнь при реализации требований экспорта выборок
данных во внешние приемники. Удобнее вызов "прицепить" к контекстному
меню грида.

    unit UnGridToClb;
     
    interface
     
    uses
      Windows, SysUtils, Classes, Dialogs,
      Grids, DBGrids, Db, DBTables, ClipBrd;
     
    procedure CopyGRDToClb(dbg: TDBGrid);
     
    // Копирует DBGrid в буфер обмена,
    // после чего данные отлично переносятся
    // как в простой текстовый редактор, так и в Excell
     
    implementation
     
    procedure CopyGRDToClb(dbg: TDBGrid);
    var
      bm: TBookMark;
      pch, pch1: PChar;
      s, s2: string;
      i, j: integer;
    begin
      s := '';
      for j := 0 to dbg.Columns.Count - 1 do
        s := s + dbg.Columns.Items[j].Title.Caption + #9;
      s := s + #13 + #10;
      if not dbg.DataSource.DataSet.active then
      begin
        ShowMessage('Нет выборки!!!');
        Exit;
      end;
      try
        dbg.Visible := False; //Делаем грид невидимым, чтобы не тратилось время
        //на его перерисовку при прокрутке DataSet - просто и
        //эффективно
        bm := dbg.DataSource.DataSet.GetBookmark; // для того чтобы не
        // потерять текущую запись
        dbg.DataSource.DataSet.First;
        while not dbg.DataSource.DataSet.EOF do
        begin
          s2 := '';
          for j := 0 to dbg.Columns.Count - 1 do
          begin
            s2 := s2 + dbg.Columns.Items[j].Field.AsString + #9;
          end;
          s := s + s2 + #13 + #10;
          dbg.DataSource.DataSet.Next;
        end;
        //Переключаем клавиатуру "в русский режим",
        //иначе - проблемы с кодировкой
        GetMem(pch, 100);
        GetMem(pch1, 100);
        GetKeyboardLayoutName(pch);
        StrCopy(pch1, pch);
        while pch <> '00000419' do
        begin
          ActivateKeyboardLayout(HKL_NEXT, 0);
          GetKeyboardLayoutName(pch);
          if strComp(pch, pch1) = 0 then
            //Круг замкнулся - нет такого языка '00000419'
            StrCopy(pch, '00000419');
        end;
     
        clipboard.AsText := s; //Данные - в буфер!!!
     
        //Возвращаем режим клавиатуры
        while strComp(pch, pch1) <> 0 do
        begin
          ActivateKeyboardLayout(HKL_NEXT, 0);
          GetKeyboardLayoutName(pch);
        end;
     
        FreeMem(pch);
        FreeMem(pch1);
     
        dbg.DataSource.DataSet.GotoBookmark(bm);
        //ShowMessage('Данные успешно скопированы в буфер обмена.');
      finally
        dbg.Visible := True;
      end;
    end;
     
    end.

Взято с <https://delphiworld.narod.ru>
