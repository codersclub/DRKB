---
Title: Проверить, выделена ли ячейка TStringGrid
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Проверить, выделена ли ячейка TStringGrid
=========================================

    function IsCellSelected(StringGrid: TStringGrid; X, Y: Longint): Boolean;
    begin
      Result := False;
      try
        if (X >= StringGrid.Selection.Left) and (X <= StringGrid.Selection.Right) and
          (Y >= StringGrid.Selection.Top) and (Y <= StringGrid.Selection.Bottom) then
          Result := True;
      except
      end;
    end;
    
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if IsCellSelected(stringgrid1, 2, 2) then
        ShowMessage('Cell (2,2) is selected.');
    end;

