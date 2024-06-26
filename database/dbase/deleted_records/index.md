---
Title: Работа с удаленными записями
Date: 01.01.2007
---


Работа с удаленными записями
============================

Вариант 1.

    procedure TForm1.Table1AfterOpen(DataSet: TDataset);
    begin
      SetDelete(Table1, TRUE);
    end;
     
    procedure SetDelete(oTable: TTable; Value: Boolean);
    var
      rslt: DBIResult;
      szErrMsg: DBIMSG;
    begin
      try
        oTable.DisableControls;
        try
          rslt := DbiSetProp(hDBIObj(oTable.Handle), curSOFTDELETEON,
            LongInt(Value));
          if rslt <> DBIERR_NONE then
          begin
            DbiGetErrorString(rslt, szErrMsg);
            raise Exception.Create(StrPas(szErrMsg));
          end;
        except
          on E: EDBEngineError do
            ShowMessage(E.Message);
          on E: Exception do
            ShowMessage(E.Message);
        end;
      finally
        oTable.Refresh;
        oTable.EnableControls;
      end;
    end;

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

Вариант 2.

В таблицах dBASE записи не удаляются до тех пор, пока таблица не будет
упакована. Пока же это не произойдет, удаленные записи остаются в
таблице, только имеют при этом флажок "к удалению". Для того, чтобы
показать эти существующие, но не отображаемые записи, существует функция
ShowDeleted(), которая использует функцию BDE API DbiSetProp(),
показывающая записи, помеченные к удалению. При использовании этой
функции нет необходимости закрывать и вновь открывать таблицу.
ShowDeleted() в качестве параметров передается TTable и логическое
значение. Логический параметр указывает на необходимость показа
удаленных записей.

Демонстрационный проект:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ExtCtrls, DBCtrls, Grids, DBGrids, DB, DBTables;
     
    type
      TForm1 = class(TForm)
        Table1: TTable;
        DataSource1: TDataSource;
        DBGrid1: TDBGrid;
        DBNavigator1: TDBNavigator;
        CheckBox1: TCheckBox;
        procedure CheckBox1Click(Sender: TObject);
      public
        procedure ShowDeleted(Table: TTable; ShowDeleted: Boolean);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    uses DBITYPES, DBIERRS, DBIPROCS;
     
    {$R *.DFM}
     
    procedure TForm1.ShowDeleted(Table: TTable; ShowDeleted: Boolean);
    var
      rslt: DBIResult;
      szErrMsg: DBIMSG;
    begin
      Table.DisableControls;
      try
        Check(DbiSetProp(hDBIObj(Table.Handle), curSOFTDELETEON,
          LongInt(ShowDeleted)));
      finally
        Table.EnableControls;
      end;
      Table.Refresh;
    end;
     
    procedure TForm1.CheckBox1Click(Sender: TObject);
    begin
      ShowDeleted(Table1, CheckBox1.Checked);
    end;
     
    end.

Source: <https://delphiworld.narod.ru>

------------------------------------------------------------------------

Вариант 3.

Показ меток удаленных записей в dBASE-файлах

Для начала вы должны включить SoftDeletes, после чего вы сможете
просматривать записи, помеченные к удалению. В противном случае, вы их
не увидите. По умолчанию, для файлов DBF, SoftDeletes установлен в
False. Вот логика работы:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      B: BOOL;
      W: Word;
    begin
      Check(DbiSetProp(hDBIObj(Table1.Handle), curSOFTDELETEON,
        longint(True)));
      { Проверяем, что это работает }
      Check(DbiGetProp(hDBIObj(Table1.Handle), curSOFTDELETEON, @B,
        sizeof(B), W));
      if B = False then
        Label2.Caption := 'Не помечена'
      else
        Label2.Caption := 'Помечена';
    end;

Когда указатель на запись указывает на запись, которую вы хотите
удалить, используйте следующую логику:

Table1.UpdateCursorPos;

Check(DbiUndeleteRecord(Table1.Handle));

Метод UpdateCursorPos устанавливает основной курсор BDE на позицию
курсора текущей записи, который существуют только для того, чтобы все
работало правильно. Вам нужно только вызвать этот метод прямым вызовом
одной из BDE API функций (такой как, например, DbiUndeleteRecord).

Ну и, наконец, чтобы все работало, поместите модули DBIPROCS и DBITYPES
с список USES.

Source: <https://delphiworld.narod.ru>

------------------------------------------------------------------------

Вариант 4.

Source: "Dtopics Database 1.10 from 3K computer Consultancy":

Пакование таблиц

     
    with Table1 do
      StrPCopy(TName, TableName);
    Result := DBIPackTable(DbHandle, Handle, TName, szDBASE, TRUE);

Задание видимости удаленных записей - вкл/выкл (например, dBase SET
DELETED ON/OFF)

    DbiSetProp( hDBIObj(Table1.Handle), curSOFTDELETEON, LongInt(bValue));
