---
Title: Как вывести Hint для ячейки TDBGrid?
Date: 01.01.2007
---


Как вывести Hint для ячейки TDBGrid?
====================================

::: {.date}
01.01.2007
:::

Создайте на форме DataSource1, Table1, DataSource2, Table2, DBGrid1.
Table1 и Table2 свяжите со своей базой данных. DataSource1 и DataSource2
свяжите соответственно с Table1 и Table2. DBGrid1 свяжите с DataSource1
Table2 и DataSource2 нужны для доступа к какой-нибудь ячейке. Другой
способ без их использования: при отрисовке значений ячеек
(соответствующее событие), необходимо запомнить значения всех ячеек,
находящихся на экране и производить выбор среди них.

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, Grids, DBGrids, Db, DBTables;
     
    type
      TForm1 = class(TForm)
        DataSource1: TDataSource;
        Table1: TTable;
        DBGrid1: TDBGrid;
        Table2: TTable;
        DataSource2: TDataSource;
        procedure FormCreate(Sender: TObject);
      private
        { Private declarations }
        procedure AppMess(var Msg: TMsg; var Handled: Boolean);
      public
        { Public declarations }
    end;
     
    var
      Form1: TForm1;
     
    implementation
    {$R *.DFM}
     
    procedure TForm1.AppMess(var Msg: TMsg; var Handled: Boolean);
    var
      X, Y: integer;
      gpt: TGridCoord;
      s: string;
      w, len: integer;
    begin
      if Msg.message=WM_MOUSEMOVE then
      begin
        if Msg.hwnd=DBGrid1.Handle then
        begin
          x:=LoWord(Msg.lParam);
          y:=HiWord(Msg.lParam);
          gpt:=DBGrid1.MouseCoord(x,y);
          {получить строку и солбец, в которых находится курсор}
          if (gpt.x>0) and (gpt.y>0) then
          begin
            DataSource2.DataSet.First;
            DataSource2.DataSet.MoveBy(gpt.y-1);
            s:=Table2.Fields[gpt.x-1].asString;
            w:=DBGrid1.Columns[gpt.x-1].Width;
            {получить ширину столбца}
            len:=DBGrid1.Canvas.TextWidth(s);
            {получить длину строки в пикселах}
            if len > w then
              DBGrid1.Hint:=s;
            else
              DBGrid1.Hint:='';
          end;
        end;
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin 
      DBGrid1.ShowHint := True;
      Application.OnMessage := AppMess;
    end;
     
    end.

Взято с <https://delphiworld.narod.ru>
