---
Title: Создание базы данных в run-time с ZEOS?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Создание базы данных в run-time с ZEOS?
=======================================

**Примечание от Vit**

Zeos - популярный бесплатный пакет доступа к базам данных, подробности
см. на sourceforge.net

    {
     This unit creates a database on a Interbase-Server at run-time.
     The IBConsole is no longer needed.
     You can execute an SQL script to create tables.
     Try it out!
    }
     
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ZTransact, ZIbSqlTr, DB, ZQuery, ZIbSqlQuery,
      ZConnect, ZIbSqlCon;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Memo1: TMemo;
        Button2: TButton;
        ZIbSqlQuery1: TZIbSqlQuery;
        ZIbSqlTransact1: TZIbSqlTransact;
        ZIbSqlDatabase1: TZIbSqlDatabase;
        Button3: TButton;
        procedure Button1Click(Sender: TObject);   // Caption/ 
        procedure Button2Click(Sender: TObject);   // Caption/ 
        procedure Button3Click(Sender: TObject);   // Caption/ 
      private
      public
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    // Creating the database
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ZIbSqlDatabase1.Database := '<<Pfad zu Datenbank>>';// Path to Database
      ZIbSqlDatabase1.Host := 'testserver';
      ZIbSqlDatabase1.Password := 'masterkey';
      ZIbSqlDatabase1.Login := 'SYSDBA';
      ZIbSqlDatabase1.CreateDatabase('');
    end;
     
    // Execute the SQL-Script in the memo
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      ZIbSqlDatabase1.Database := '<<Pfad zu Datenbank>>'; // Path to Database
      ZIbSqlDatabase1.Host := 'testserver';
      ZIbSqlDatabase1.Password := 'masterkey';
      ZIbSqlDatabase1.Login := 'SYSDBA';
      ZIbSqlQuery1.SQL.Clear;
      ZIbSqlQuery1.SQL.AddStrings(memo1.Lines);
      ZIbSqlQuery1.ExecSQL;
    end;
     
    // Deleted the database
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      ZIbSqlDatabase1.Database := '<<Pfad zu Datenbank>>'; // Path to Database
      ZIbSqlDatabase1.Host := 'testserver';
      ZIbSqlDatabase1.Password := 'masterkey';
      ZIbSqlDatabase1.Login := 'SYSDBA';
      ZIbSqlDatabase1.DropDatabase;
    end;
     
    end.

