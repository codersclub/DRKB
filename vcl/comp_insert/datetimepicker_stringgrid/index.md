---
Title: TDateTimePicker в TStringGrid
Author: Smike
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


TDateTimePicker в TStringGrid
=============================

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, Grids, ComCtrls;
     
    type
      TForm1 = class(TForm)
        StringGrid1: TStringGrid;
        DateTimePicker1: TDateTimePicker;
        procedure StringGrid1SelectCell(Sender: TObject; ACol, ARow: Integer;
          var CanSelect: Boolean);
        procedure FormCreate(Sender: TObject);
        procedure StringGrid1Exit(Sender: TObject);
        procedure DateTimePicker1Exit(Sender: TObject);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.StringGrid1SelectCell(Sender: TObject; ACol,
      ARow: Integer; var CanSelect: Boolean);
    var
      D: TDateTime;
    begin
      DateTimePicker1.Visible := True;
      DateTimePicker1.BoundsRect := StringGrid1.CellRect(ACol, ARow);
      D := DateTimePicker1.DateTime;
      TryStrToDateTime(StringGrid1.Cells[ACol, ARow], D);
      DateTimePicker1.DateTime := D;
      DateTimePicker1.SetFocus;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      DateTimePicker1.Parent := StringGrid1;
      DateTimePicker1.Visible := False;
      DateTimePicker1.OnExit := DateTimePicker1Exit;
     
      StringGrid1.OnSelectCell := StringGrid1SelectCell;
    end;
     
    procedure TForm1.StringGrid1Exit(Sender: TObject);
    begin
      DateTimePicker1.Visible := False;
    end;
     
    procedure TForm1.DateTimePicker1Exit(Sender: TObject);
    begin
      with StringGrid1 do
        Cells[Col, Row] := DateTimeToStr(DateTimePicker1.DateTime);
    end;
     
    end.

