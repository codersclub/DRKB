---
Title: ASCII-файл с использованием полей
Date: 01.01.2007
Author: OAmiry/Borland
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)
---


ASCII-файл с использованием полей
=================================

В том случае, когда вы собираетесь использовать содержимое текстового
файла таким образом, как будто он имеет поля, вам необходим файл схемы,
содержащий описание формата текстового файла и который необходим для
осуществления вызовов при работе с полями (Fields / FieldByName / Post /
и др.). Ниже приводится код, который вы можете использовать при создании
своей программы:

    { Подразумеваем, что Table1 - файл, который мы хотим скопировать в ASCII-файл. Используем TBatchMove, поскольку быстро работает. Также это автоматически создаст файл схемы }
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      oDest: TTable;
      oBMove: TBatchMove;
    begin
     
      try
        oDest := nil;
        oBMove := nil;
        Table1.Close;
     
        oDest := TTable.Create(nil);
        with oDest do
          begin
            DatabaseName := 'c:\delphi\files';
            TableName := 'Test.Txt';
            TableType := ttASCII;
          end; {Обратите внимание на то, что нет необходимости вызывать CreateTable}
     
        oBMove := TBatchMove.Create(nil);
        with oBMove do
          begin
            Source := Table1;
            Destination := oDest;
            Mode := batCopy;
            Execute;
          end;
      finally
        if Assigned(oDest) then oDest.Free;
        if Assigned(oBMove) then oBMove.Free;
      end;
    end;
     
    { Теперь, допустим, файл схемы существует; сам текстовый файл может как быть, так его может и не быть. С помощью файла схемы мы уже можем работать с полями }
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
     
      oTxt: TTable;
      i: Integer;
      f: System.Text;
    begin
     
      try
        oTxt := nil;
     
        if not FileExists('c:\delphi\files\Test.Txt') then
          begin
            AssignFile(f, 'c:\delphi\files\Test.Txt');
            Rewrite(f);
            CloseFile(f);
          end;
     
        oTxt := TTable.Create(nil);
        with oTxt do
          begin
            DatabaseName := 'c:\delphi\files';
            TableName := 'Test.Txt';
            TableType := ttASCII;
            Open;
          end;
     
        with Table1 do
          begin
            DisableControls;
            if not Active then Open;
            First;
            while not EOF do
              begin
                oTxt.Insert;
    { В данном случае файл схемы описывает формат текстового файла; в этом
    примере фактически один к одному воспроизводятся поля таблицы
    в логическое определение полей в .sch-файле }
                for i := 0 to FieldCount - 1 do
                  oTxt.Fields[i].AsString := Fields[i].AsString;
                oTxt.Post;
                Next;
              end;
          end;
      finally
        Table1.EnableControls;
        if Assigned(oTxt) then oTxt.Free;
      end;
     
    end;


Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
