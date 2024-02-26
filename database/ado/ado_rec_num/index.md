---
Title: Как узнать перечень таблиц базы и количество записей в них?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как узнать перечень таблиц базы и количество записей в них?
===========================================================

    procedure TForm1.Button1Click(Sender: TObject);
    var
      SL: TStrings;
      index: Integer;
    begin
      SL := TStringList.Create;
      try
        ADOConnection1.GetTableNames(SL, False);
        for index := 0 to (SL.Count - 1) do begin
          Table1.Insert;
          Table1.FieldByName('Name').AsString := SL[index];
          ADOTable1.TableName := SL[index];
          ADOTable1.Open;
          Table1.FieldByName('Records').AsInteger :=
            ADOTable1.RecordCount;
          Table1.Post;
        end;
      finally
        SL.Free;
        ADOTable1.Close;
      end;
    end;


---
**Комментарий Vit:**

открытие больших таблиц, особенно на удалённых серверах
баз данных может быть исключительно длительным процессом. ADO
оптимизированно для работы через запросы, поэтому количество записей
можно значительно быстрее узнать составляя query и выполняя её:

    procedure TForm1.Button1Click(Sender: TObject);

    var
      SL: TStrings;
      index: Integer;
    begin
      SL := TStringList.Create;
      try
        ADOConnection1.GetTableNames(SL, False);
        for index := 0 to (SL.Count - 1) do begin
          Table1.Insert;
          Table1.FieldByName('Name').AsString := SL[index];
          ADOQuery1.sql.text := 'Select Count(*) From '+SL[index];
          ADOQuery1.Open;
          Table1.FieldByName('Records').AsInteger :=ADOQuery1.fields[0].AsInteger;
          Table1.Post;
          ADOQuery1.Close;
        end;
      finally
        SL.Free;
      end;
    end;
