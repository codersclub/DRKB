---
Title: Как создать таблицу через SQL?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как создать таблицу через SQL?
==============================

Следующая функция полностью совместима с Paradox:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Q: TQuery;
    begin
      Q := TQuery.Create(Application)
        try
        Q.DatabaseName := 'SF';
     
        with Q.SQL do
          begin
            Add('Create Table Funcionarios');
            Add('( ID      AutoInc,       ');
            Add('  Name    Char(30),      ');
            Add('  Salary  Money,         ');
            Add('  Depno    SmallInt,     ');
            Add('  Primary Key ( ID ) )   ');
          end;
     
        Q.ExecSQL;
      finally
        Q.Free;
      end;
    end;

