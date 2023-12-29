---
Title: Вставка и удаление строк в TStringGrid
Author: Dennis Passmore
Date: 01.01.2007
---


Вставка и удаление строк в TStringGrid
======================================

::: {.date}
01.01.2007
:::

Автор: Dennis Passmore

Поскольку свойство Cols[x] компонента TStringGrid реально является
компонентом TStrings, все методы TStrings применимы также и к Cols[x].

Недавно в интернете я нашел реализацию расширенных функций TStringGrid:

    {
    Создано:               Dennis Passmore
                           1929 Mango Tree Drive
                           Edgewater, Fl. 32141
                           CIS: 71640,2464
                           Март 1, 1996
    Данный код свободен в использовании при одном условии:
    в исходном коде должна присутствовать указанная выше кредитка
    со ссылкой на автора.
     
    Примечание по использованию кода:
    Всякий раз при удалении Row (строки) или Column (колонки)
    проверяйте наличие и удаляйте любые объекты, которые могли
    быть назначены любой ячейке в строке или колонке, которые вы
    собираетесь удалять, поскольку данный код не может знать ни
    размера, ни типа ассигнованных ими объектов.
     
    }
     
    unit GridFunc;
     
    interface
     
    uses
      Sysutils, WinProcs, Grids;
     
    procedure InsertRow(Sender: TStringGrid; ToIndex: Longint);
    procedure DeleteRow(Sender: TStringGrid; FromIndex: Longint);
    procedure InsertColumn(Sender: TStringGrid; ToIndex: Longint);
    procedure DeleteColumn(Sender: TStringGrid; FromIndex: Longint);
     
    implementation
     
    type
      TCSGrid = class(TStringGrid)
      private
      public
        procedure MoveRow(FromIndex, ToIndex: Longint);
        procedure MoveColumn(FromIndex, ToIndex: Longint);
      end;
     
    procedure TCSGrid.MoveRow(FromIndex, ToIndex: Longint);
    begin
      RowMoved(FromIndex, ToIndex); { Защищенный метод TStringGrid }
    end;
     
    procedure TCSGrid.MoveColumn(FromIndex, ToIndex: Longint);
    begin
      ColumnMoved(FromIndex, ToIndex); { Защищенный метод TStringGrid }
    end;
     
    procedure InsertRow(Sender: TStringGrid; ToIndex: Longint);
    var
      xx, yy: Integer;
    begin
      if ToIndex >= 0 then
        with TCSGrid(Sender) do
          if (ToIndex <= RowCount) then
          begin
            RowCount := RowCount + 1;
            xx := RowCount - 1;
            for yy := 0 to ColCount - 1 do
            begin
              Cells[yy, xx] := ' ';
              ObJects[yy, xx] := nil;
            end;
            if ToIndex < RowCount - 1 then
              MoveRow(RowCount - 1, ToIndex);
          end
          else
            MessageBeep(0)
        else
          MessageBeep(0);
    end;
     
    procedure DeleteRow(Sender: TStringGrid; FromIndex: Longint);
    begin
      if FromIndex > l;
      = 0 then
        with TCSGrid(Sender) do
          if (RowCount > 0) and (FromIndex < RowCount) then
          begin
            if (FromIndex < RowCount - 1) then
              MoveRow(FromIndex, RowCount - 1);
            Rows[RowCount - 1].Clear;
            RowCount := RowCount - 1;
          end
          else
            MessageBeep(0)
        else
          MessageBeep(0);
    end;
     
    procedure InsertColumn(Sender: TStringGrid; ToIndex: Longint);
    var
      xx, yy: Integer;
    begin
      if ToIndex >= 0 then
        with TCSGrid(Sender) do
          if (ToIndex <= ColCount) then
          begin
            ColCount := ColCount + 1;
            xx := ColCount - 1;
            Cols[xx].BeginUpdate;
            for yy := 0 to RowCount - 1 do
            begin
              Cells[xx, yy] := ' ';
              ObJects[xx, yy] := nil;
            end;
            Cols[xx].EndUpdate;
            if ToIndex < ColCount - 1 then
              MoveColumn(ColCount - 1, ToIndex);
          end
          else
            MessageBeep(0)
        else
          MessageBeep(0);
    end;
     
    procedure DeleteColumn(Sender: TStringGrid; FromIndex: Longint);
    begin
      if FromIndex >= 0 then
        with TCSGrid(Sender) do
          if (ColCount > 0) and (FromIndex < ColCount) then
          begin
            if (FromIndex < ColCount - 1) then
              MoveColumn(FromIndex, ColCount - 1);
            Cols[ColCount - 1].Clear;
            ColCount := ColCount - 1;
          end
          else
            MessageBeep(0)
        else
          MessageBeep(0);
    end;
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

------------------------------------------------------------------------

    // For this tip you need a StringGrid1 and a Button1. 
    // Fur diesen Tip braucht man ein StringGrid1 und einen Button1. 
     
     
    {...}
     type
       TForm1 = class(TForm)
         StringGrid1: TStringGrid;
         Button1: TButton;
         procedure Button1Click(Sender: TObject);
       private
         {...}
       public
         {...}
       end;
     
     type
       TStringGridHack = class(TStringGrid)
       protected
         procedure DeleteRow(ARow: Longint); reintroduce;
         procedure InsertRow(ARow: Longint);
       end;
     
     var
       Form1: TForm1;
     
     implementation
     
     {$R *.DFM}
     
     procedure TStringGridHack.DeleteRow(ARow: Longint);
     var
       GemRow: Integer;
     begin
       GemRow := Row;
       if RowCount > FixedRows + 1 then
         inherited DeleteRow(ARow)
       else
         Rows[ARow].Clear;
       if GemRow < RowCount then Row := GemRow;
     end;
     
     procedure TStringGridHack.InsertRow(ARow: Longint);
     var
       GemRow: Integer;
     begin
       GemRow := Row;
       while ARow < FixedRows do Inc(ARow);
       RowCount := RowCount + 1;
       MoveRow(RowCount - 1, ARow);
       Row := GemRow;
       Rows[Row].Clear;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       // Insert Row, Zeile hinzufugen 
      TStringGridHack(StringGrid1).InsertRow(1);
       // Remove Row, Zeile entfernen 
      TStringGridHack(StringGrid1).DeleteRow(2);
     end;
     
     end.

Взято с сайта: <https://www.swissdelphicenter.ch>
