---
Title: XLS -> TStringGrid
Author: Kostas
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


XLS -> TStringGrid
==================

    function Xls_To_StringGrid(AGrid: TStringGrid; AXLSFile: string): Boolean;
    const
      xlCellTypeLastCell = $0000000B;
    var
      XLApp, Sheet: OLEVariant;
      RangeMatrix: Variant;
      x, y, k, r: Integer;
    begin
      Screen.Cursor:=crAppStart;
      Result := False;
      XLApp := CreateOleObject('Excel.Application');
      try
        XLApp.Visible := False;
        XLApp.Workbooks.Open(AXLSFile);
        Sheet := XLApp.Workbooks[ExtractFileName(AXLSFile)].WorkSheets[1];
        Sheet.Cells.SpecialCells(xlCellTypeLastCell, EmptyParam).Activate;
        x := XLApp.ActiveCell.Row;
        y := XLApp.ActiveCell.Column;
        AGrid.RowCount := x;
        AGrid.ColCount := y;  
        RangeMatrix := XLApp.Range['A1', XLApp.Cells.Item[X, Y]].Value;
        k := 1;
        repeat
          for r := 1 to y do
           AGrid.Cells[(r - 1), (k - 1)] := RangeMatrix[K, R];
          Inc(k, 1);
          AGrid.RowCount := k + 1;  
        until k > x;  
        RangeMatrix := Unassigned;
      finally
        if not VarIsEmpty(XLApp) then
        begin  
          XLApp.Quit;  
          XLAPP := Unassigned;  
          Sheet := Unassigned;  
          Result := True;  
        end;  
      end;
      Screen.Cursor:=crDefault;
    end;

