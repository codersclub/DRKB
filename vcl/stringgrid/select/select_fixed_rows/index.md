---
Title: TStringGrid, выделить фиксированные строки
Author: Smike
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


TStringGrid, выделить фиксированные строки
==========================================

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, Grids;
     
    type
      TForm1 = class(TForm)
        StringGrid1: TStringGrid;
        procedure FormCreate(Sender: TObject);
        procedure StringGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
          Rect: TRect; State: TGridDrawState);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      C, R: Integer;
    begin
      for C := 0 to StringGrid1.ColCount - 1 do
      begin
        for R := 0 to StringGrid1.RowCount - 1 do
        begin
          if (C < StringGrid1.FixedCols) or
             (R < StringGrid1.FixedRows) then
            StringGrid1.Cells[C, R] := Format('Fixed Cell (%dx%xd)', [C, R])
          else
            StringGrid1.Cells[C, R] := Format('Cell (%dx%d)', [C, R]);
        end;
      end;
    end;
     
    procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol, ARow: Integer;
      Rect: TRect; State: TGridDrawState);
    var
      I: Integer;
    begin
      with StringGrid1 do
        if gdFixed in State then
        begin
          Canvas.FillRect(Rect);
          InflateRect(Rect, -2, 0);
          if (ACol = Col) or (ARow = Row) then
            Canvas.Font.Style := [fsBold]
          else
            Canvas.Font.Style := [];
          DrawText(Canvas.Handle,
            PChar(Cells[ACol, ARow]), -1, Rect,
            DT_SINGLELINE or DT_VCENTER);
        end else begin
          Rect := CellRect(ACol, 0);
          for I := 1 to FixedRows - 1 do
            with CellRect(ACol, I) do
              Inc(Rect.Bottom, Bottom - Top);
          InvalidateRect(Handle, @Rect, True);
     
          Rect := CellRect(0, ARow);
          for I := 1 to FixedCols - 1 do
            with CellRect(I, ARow) do
              Inc(Rect.Right, Right - Left);
          InvalidateRect(Handle, @Rect, True);
        end;
    end;
     
    end.

