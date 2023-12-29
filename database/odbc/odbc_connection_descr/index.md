---
Title: Получение дескриптора ODBC соединения
Date: 01.01.2007
---


Получение дескриптора ODBC соединения
=====================================

::: {.date}
01.01.2007
:::

Я как-то обращал ваше внимание на трудность получения дескриптора ODBC
соединения посредством DBE. После тесного общения со службой поддержки
Borland, я наконец нашел решение как это сделать. Вот этот код:

    unit Getprop;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, Grids, DBGrids, StdCtrls, DB, DBTables,
      DBIProcs, DBITypes, DBIErrs;
     
    type
      TForm1 = class(TForm)
        Table1: TTable;
        DataSource1: TDataSource;
        Button1: TButton;
        Button2: TButton;
        DBGrid1: TDBGrid;
        Edit1: TEdit;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
    { Private declarations }
      public
    { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Table1.active := True;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      hTmpDB: hDBIDb;
      iLen: word;
     
    begin
      Check(DbiGetProp(hDBIObj(Table1.DBhandle), dbNATIVEHNDL, @hTmpDB, sizeof(hDBIDb), iLen));
      Edit1.text := inttostr(longint(htmpdb));
    end;
     
    end

\- Chris Fioravanti

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
