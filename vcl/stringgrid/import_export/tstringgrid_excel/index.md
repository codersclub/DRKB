---
Title: Экспорт TStringGrid в Excel
Date: 01.01.2007
---


Экспорт TStringGrid в Excel
===========================

Вариант 1:

Source: <https://www.swissdelphicenter.ch>

    { With OLE Automation }
     
    uses
      ComObj;
    
    function RefToCell(ARow, ACol: Integer): string;
    begin
      Result := Chr(Ord('A') + ACol - 1) + IntToStr(ARow);
    end;
    
    function SaveAsExcelFile(AGrid: TStringGrid; ASheetName, AFileName: string): Boolean;
    const
      xlWBATWorksheet = -4167;
    var
      Row, Col: Integer;
      GridPrevFile: string;
      XLApp, Sheet, Data: OLEVariant;
      i, j: Integer;
    begin
      // Prepare Data 
      Data := VarArrayCreate([1, AGrid.RowCount, 1, AGrid.ColCount], varVariant);
      for i := 0 to AGrid.ColCount - 1 do
        for j := 0 to AGrid.RowCount - 1 do
          Data[j + 1, i + 1] := AGrid.Cells[i, j];
      // Create Excel-OLE Object 
      Result := False;
      XLApp := CreateOleObject('Excel.Application');
      try
        // Hide Excel 
        XLApp.Visible := False;
        // Add new Workbook 
        XLApp.Workbooks.Add(xlWBatWorkSheet);
        Sheet := XLApp.Workbooks[1].WorkSheets[1];
        Sheet.Name := ASheetName;
        // Fill up the sheet 
        Sheet.Range[RefToCell(1, 1), RefToCell(AGrid.RowCount,
          AGrid.ColCount)].Value := Data;
        // Save Excel Worksheet 
        try
          XLApp.Workbooks[1].SaveAs(AFileName);
          Result := True;
        except
          // Error ? 
        end;
      finally
        // Quit Excel 
        if not VarIsEmpty(XLApp) then
        begin
          XLApp.DisplayAlerts := False;
          XLApp.Quit;
          XLAPP := Unassigned;
          Sheet := Unassigned;
        end;
      end;
    end;
     
    // Example: 
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if SaveAsExcelFile(stringGrid1, 'My Stringgrid Data', 'c:\MyExcelFile.xls') then
        ShowMessage('StringGrid saved!');
    end;


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    { Without OLE }
     
    procedure XlsWriteCellLabel(XlsStream: TStream; const ACol, ARow: Word;
      const AValue: string);
    var
      L: Word;
    const
      {$J+}
      CXlsLabel: array[0..5] of Word = ($204, 0, 0, 0, 0, 0);
      {$J-}
    begin
      L := Length(AValue);
      CXlsLabel[1] := 8 + L;
      CXlsLabel[2] := ARow;
      CXlsLabel[3] := ACol;
      CXlsLabel[5] := L;
      XlsStream.WriteBuffer(CXlsLabel, SizeOf(CXlsLabel));
      XlsStream.WriteBuffer(Pointer(AValue)^, L);
    end;
    
    
    function SaveAsExcelFile(AGrid: TStringGrid; AFileName: string): Boolean;
    const
      {$J+} CXlsBof: array[0..5] of Word = ($809, 8, 00, $10, 0, 0); {$J-}
      CXlsEof: array[0..1] of Word = ($0A, 00);
    var
      FStream: TFileStream;
      I, J: Integer;
    begin
      Result := False;
      FStream := TFileStream.Create(PChar(AFileName), fmCreate or fmOpenWrite);
      try
        CXlsBof[4] := 0;
        FStream.WriteBuffer(CXlsBof, SizeOf(CXlsBof));
        for i := 0 to AGrid.ColCount - 1 do
          for j := 0 to AGrid.RowCount - 1 do
            XlsWriteCellLabel(FStream, I, J, AGrid.cells[i, j]);
        FStream.WriteBuffer(CXlsEof, SizeOf(CXlsEof));
        Result := True;
      finally
        FStream.Free;
      end;
    end;
    
    // Example: 
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      if SaveAsExcelFile(StringGrid1, 'c:\MyExcelFile.xls') then
        ShowMessage('StringGrid saved!');
    end;


------------------------------------------------------------------------

Вариант 3:

Author: Reinhard Schatzl

Source: <https://www.swissdelphicenter.ch>

    { Code by Reinhard Schatzl }
     
    uses
      ComObj;
     
    // Hilfsfunktion fur StringGridToExcelSheet 
    // Helper function for StringGridToExcelSheet 
    function RefToCell(RowID, ColID: Integer): string;
    var
      ACount, APos: Integer;
    begin
      ACount := ColID div 26;
      APos := ColID mod 26;
      if APos = 0 then
      begin
        ACount := ACount - 1;
        APos := 26;
      end;
    
      if ACount = 0 then
        Result := Chr(Ord('A') + ColID - 1) + IntToStr(RowID);
    
      if ACount = 1 then
        Result := 'A' + Chr(Ord('A') + APos - 1) + IntToStr(RowID);
    
      if ACount > 1 then
        Result := Chr(Ord('A') + ACount - 1) + Chr(Ord('A') + APos - 1) + IntToStr(RowID);
    end;
    
    // StringGrid Inhalt in Excel exportieren 
    // Export StringGrid contents to Excel 
    function StringGridToExcelSheet(Grid: TStringGrid; SheetName, FileName: string;
       ShowExcel: Boolean): Boolean;
    const
      xlWBATWorksheet = -4167;
    var
      SheetCount, SheetColCount, SheetRowCount, BookCount: Integer;
      XLApp, Sheet, Data: OLEVariant;
      I, J, N, M: Integer;
      SaveFileName: string;
    begin
      //notwendige Sheetanzahl feststellen 
      SheetCount := (Grid.ColCount div 256) + 1;
      if Grid.ColCount mod 256 = 0 then
        SheetCount := SheetCount - 1;
      //notwendige Bookanzahl feststellen 
      BookCount := (Grid.RowCount div 65536) + 1;
      if Grid.RowCount mod 65536 = 0 then
        BookCount := BookCount - 1;
    
      //Create Excel-OLE Object 
      Result := False;
      XLApp  := CreateOleObject('Excel.Application');
      try
        //Excelsheet anzeigen 
        if ShowExcel = False then
          XLApp.Visible := False
        else
          XLApp.Visible := True;
        //Workbook hinzufugen 
        for M := 1 to BookCount do
        begin
          XLApp.Workbooks.Add(xlWBATWorksheet);
          //Sheets anlegen 
         for N := 1 to SheetCount - 1 do
          begin
            XLApp.Worksheets.Add;
          end;
        end;
        //Sheet ColAnzahl feststellen 
        if Grid.ColCount <= 256 then
          SheetColCount := Grid.ColCount
        else
          SheetColCount := 256;
        //Sheet RowAnzahl feststellen 
        if Grid.RowCount <= 65536 then
          SheetRowCount := Grid.RowCount
        else
          SheetRowCount := 65536;
    
        //Sheets befullen 
        for M := 1 to BookCount do
        begin
          for N := 1 to SheetCount do
          begin
            //Daten aus Grid holen 
            Data := VarArrayCreate([1, Grid.RowCount, 1, SheetColCount], varVariant);
            for I := 0 to SheetColCount - 1 do
              for J := 0 to SheetRowCount - 1 do
                if ((I + 256 * (N - 1)) <= Grid.ColCount) and
                  ((J + 65536 * (M - 1)) <= Grid.RowCount) then
                  Data[J + 1, I + 1] := Grid.Cells[I + 256 * (N - 1), J + 65536 * (M - 1)];
            //------------------------- 
            XLApp.Worksheets[N].Select;
            XLApp.Workbooks[M].Worksheets[N].Name := SheetName + IntToStr(N);
            //Zellen als String Formatieren 
            XLApp.Workbooks[M].Worksheets[N].Range[RefToCell(1, 1),
              RefToCell(SheetRowCount, SheetColCount)].Select;
            XLApp.Selection.NumberFormat := '@';
            XLApp.Workbooks[M].Worksheets[N].Range['A1'].Select;
            //Daten dem Excelsheet ubergeben 
            Sheet := XLApp.Workbooks[M].WorkSheets[N];
            Sheet.Range[RefToCell(1, 1), RefToCell(SheetRowCount, SheetColCount)].Value :=
              Data;
          end;
        end;
        //Save Excel Worksheet 
        try
          for M := 1 to BookCount do
          begin
            SaveFileName := Copy(FileName, 1,Pos('.', FileName) - 1) + IntToStr(M) +
              Copy(FileName, Pos('.', FileName),
              Length(FileName) - Pos('.', FileName) + 1);
            XLApp.Workbooks[M].SaveAs(SaveFileName);
          end;
          Result := True;
        except
          // Error ? 
        end;
      finally
        //Excel Beenden 
        if (not VarIsEmpty(XLApp)) and (ShowExcel = False) then
        begin
          XLApp.DisplayAlerts := False;
          XLApp.Quit;
          XLAPP := Unassigned;
          Sheet := Unassigned;
        end;
      end;
    end;
    
    //Example 
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      //StringGrid inhalt in Excel exportieren 
      //Grid : stringGrid, SheetName : stringgrid Print, Pfad : c:\Test\ExcelFile.xls, Excelsheet anzeigen 
      StringGridToExcelSheet(StringGrid, 'Stringgrid Print', 'c:\Test\ExcelFile.xls', True);
    end;

