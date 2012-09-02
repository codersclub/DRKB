<h1>Как экспортировать данные из StringGrid в Excel?</h1>
<div class="date">01.01.2007</div>


<p>{1. With OLE Automation }</p>
<pre>
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
</pre>


<p>// Example:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  if SaveAsExcelFile(stringGrid1, 'My Stringgrid Data', 'c:\MyExcelFile.xls') then
    ShowMessage('StringGrid saved!');
end;
</pre>

<p>{**************************************************************}</p>
<p>{2. Without OLE }</p>
<pre>
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
</pre>


<p>// Example:</p>
<pre>
procedure TForm1.Button2Click(Sender: TObject);
begin
  if SaveAsExcelFile(StringGrid1, 'c:\MyExcelFile.xls') then
    ShowMessage('StringGrid saved!');
end;
</pre>
<p>{**************************************************************}</p>
<p>{3. Code by Reinhard Schatzl }</p>
<pre>
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
 
  if ACount &gt; 1 then
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
    if Grid.ColCount &lt;= 256 then
      SheetColCount := Grid.ColCount
    else
      SheetColCount := 256;
    //Sheet RowAnzahl feststellen
    if Grid.RowCount &lt;= 65536 then
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
            if ((I + 256 * (N - 1)) &lt;= Grid.ColCount) and
              ((J + 65536 * (M - 1)) &lt;= Grid.RowCount) then
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
</pre>


<p>//Example</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  //StringGrid inhalt in Excel exportieren
  //Grid : stringGrid, SheetName : stringgrid Print, Pfad : c:\Test\ExcelFile.xls, Excelsheet anzeigen
  StringGridToExcelSheet(StringGrid, 'Stringgrid Print', 'c:\Test\ExcelFile.xls', True);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

<hr />
<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Работа с MS Excel
 
Основная функция - передача данных из DataSet в Excel
 
Зависимости: ComObj, QDialogs, SysUtils, Variants, DB
Автор:       Daun, daun@mail.kz
Copyright:   daun
Дата:        5 октября 2002 г.
********************************************** }
 
unit ExcelModule;
 
interface
 
uses ComObj, QDialogs, SysUtils, Variants, DB;
 
//**=====================================================
//** MS Excel
//**=====================================================
 
//** Открытие Excel 
procedure ExcelCreateApplication(FirstSheetName : String; //назв-е 1ого листа
                                 SheetCount : Integer; //кол-во листов
                                 ExcelVisible : Boolean);//отображение книги
 
//** Перевод номера столбца в букву, напр. 1='A',2='B',..,28='AB'
//** Должно работать до 'ZZ'
function ExcelChar(Num : Integer):String;
 
//** Оформление указанного диапазона бордерами
procedure ExcelRangeBorders(RangeBorders : Variant; //диапазон
                            BOutSideSize : Byte; //толщина снаружи
                            BInsideSize : Byte; //толщина внутри 
                            BOutSideVerticalLeft : Boolean; 
                            BOutSideVerticalRight : Boolean;
                            BInSideVertical : Boolean;
                            BOutSideHorizUp : Boolean;
                            BOutSideHorizDown : Boolean;
                            BInSideHoriz : Boolean);
 
//** Форматирование диапазона (шрифт, размер)
procedure ExcelFormatRange(RangeFormat : Variant;
                           Font : String;
                           Size : Byte;
                           AutoFit : Boolean);
//** Вывод DataSet 
procedure ExcelGetDataSet(DataSet : TDataSet;
                          SheetNumber : Integer; // Номер листа
                          FirstRow : Integer; // Первая строка
                          FirstCol : Integer; // Первый столбец
                          ShowCaptions : Boolean; // Вывод заголовков DataSet
                          ShowNumbers : Boolean; // Вывод номеров (N пп)
                          FirstNumber : Integer; // Первый номер
                          ShowBorders : Boolean; // Вывод бордюра
                          StepCol : Byte; // Шаг колонок: 0-подряд,
                                                   // 1-через одну и тд
                          StepRow : Byte); // Шаг строк
 
//** Меняет имя листа 
procedure ExcelSetSheetName(SheetNumber : Byte; //номер листа
                            SheetName : String); //имя
//** Делает Excel видимым 
procedure ExcelShow;
 
//** Сохранение книги
procedure ExcelSaveWorkBook(Name: String);
 
//**=====================================================
//** MS Word 
//**=====================================================
 
//** Открытие Ворда
procedure CreateWordAppl(WordVisible : Boolean);
 
//** Отображение Ворда
procedure MakeWordVisible;
 
//** Набор текста
procedure WordTypeText(s : String);
 
//** Новый параграф
procedure NewParag(Bold : Boolean;
                   Italic : Boolean;
                   ULine : Boolean;
                   Alignment : Integer;
                   FontSize : Integer);
 
var
 Excel,Sheet,Range,Columns : Variant;
 
 MSWord, Selection : Variant;
 
implementation
 
procedure ExcelCreateApplication(FirstSheetName : String;
                                 SheetCount : Integer;
                                 ExcelVisible : Boolean);
begin
  try
    Excel := CreateOleObject('Excel.Application');
    Excel.Application.EnableEvents := False;
    Excel.DisplayAlerts := False;
    Excel.SheetsInNewWorkbook := SheetCount;
    Excel.Visible := ExcelVisible;
    Excel.WorkBooks.Add;
    Sheet := Excel.WorkBooks[1].Sheets[1];
    Sheet.Name := FirstSheetName;
  except
    Exception.Create('Error.');
    Excel := UnAssigned;
  end;
end;
 
function ExcelChar(Num : Integer):String;
var
  S : String;
  I : Integer;
begin
  I := Trunc(Num / 26);
  if Num &gt; 26 then S := Chr(I + 64) + Chr(Num - (I * 26) + 64)
              else S := Chr(Num + 64);
  Result := S;
end;
 
procedure ExcelRangeBorders(RangeBorders : Variant;
                            BOutSideSize : Byte;
                            BInsideSize : Byte;
                            BOutSideVerticalLeft : Boolean;
                            BOutSideVerticalRight : Boolean;
                            BInSideVertical : Boolean;
                            BOutSideHorizUp : Boolean;
                            BOutSideHorizDown : Boolean;
                            BInSideHoriz : Boolean);
begin
  if BOutSideVerticalLeft then
  begin
    RangeBorders.Borders[7].LineStyle := 1;
    RangeBorders.Borders[7].Weight := BOutSideSize;
    RangeBorders.Borders[7].ColorIndex := -4105;
  end;
  if BOutSideHorizUp then
  begin
    RangeBorders.Borders[8].LineStyle := 1;
    RangeBorders.Borders[8].Weight := BOutSideSize;
    RangeBorders.Borders[8].ColorIndex := -4105;
  end;
  if BOutSideHorizDown then
  begin
    RangeBorders.Borders[9].LineStyle := 1;
    RangeBorders.Borders[9].Weight := BOutSideSize;
    RangeBorders.Borders[9].ColorIndex := -4105;
  end;
  if BOutSideVerticalRight then
  begin
    RangeBorders.Borders[10].LineStyle := 1;
    RangeBorders.Borders[10].Weight := BOutSideSize;
    RangeBorders.Borders[10].ColorIndex := -4105;
  end;
  if BInSideVertical then
  begin
    RangeBorders.Borders[11].LineStyle := 1;
    RangeBorders.Borders[11].Weight := BInSideSize;
    RangeBorders.Borders[11].ColorIndex := -4105;
  end;
  if BInsideHoriz then begin
    RangeBorders.Borders[12].LineStyle := 1;
    RangeBorders.Borders[12].Weight := BInSideSize;
    RangeBorders.Borders[12].ColorIndex := -4105;
  end;
end;
 
procedure ExcelFormatRange(RangeFormat : Variant;
                           Font : String;
                           Size : Byte;
                           AutoFit : Boolean);
begin
  RangeFormat.Font.Name := 'Arial';
  RangeFormat.Font.Size := 7;
  if AutoFit then RangeFormat.Columns.AutoFit;
end;
 
procedure ExcelSetSheetName(SheetNumber : Byte;
                            SheetName : String);
begin
  try
    Sheet:=Excel.WorkBooks[1].Sheets[SheetNumber];
    Sheet.Name := SheetName;
  except
    Exception.Create('Error.');
    Exit;
  end;
end;
 
procedure ExcelShow;
begin
  Excel.Visible := True;
  Excel := UnAssigned;
end;
 
procedure ExcelGetDataSet(DataSet : TDataSet;
                          SheetNumber : Integer;
                          FirstRow : Integer;
                          FirstCol : Integer;
                          ShowCaptions : Boolean;
                          ShowNumbers : Boolean;
                          FirstNumber : Integer;
                          ShowBorders : Boolean;
                          StepCol : Byte;
                          StepRow : Byte);
var
  Column : Integer;
  Row : Integer;
  I : Integer;
begin
  if (ShowCaptions) and (FirstRow &lt; 2) then FirstRow := 2;
  if (ShowNumbers) and (FirstCol &lt; 2) then FirstCol := 2;
 
  try
    Sheet := Excel.WorkBooks[1].Sheets[SheetNumber];
  except
    Exception.Create('Error.');
    Exit;
  end;
 
  try
    with DataSet do
      try
        DisableControls;
 
        if ShowCaptions then
        begin
          Row := FirstRow - 1;
          Column := FirstCol;
          for i := 0 to FieldCount - 1 do
            if Fields[i].Visible then
            begin
              Sheet.Cells[Row, Column] := Fields[i].DisplayName;
              Inc(Column);
            end;
          Sheet.Rows[Row].Font.Bold := True;
        end;
 
        Row := FirstRow;
        First;
        while NOT EOF do
        begin
          Column := FirstCol;
          if ShowNumbers then
            Sheet.Cells[Row, FirstCol-1] := FirstNumber;
 
          for i := 0 to FieldCount - 1 do
          begin
            if Fields[i].Visible then
            begin
              if Fields[i].DataType&lt;&gt;ftfloat
                then Sheet.Cells[Row, Column] := Trim(Fields[i].DisplayText)
                else Sheet.Cells[Row, Column] := Fields[i].Value;
              Inc(Column, StepCol);
            end;
          end;
          Inc(Row, StepRow);
          Inc(FirstNumber);
          Next;
        end;
 
        if ShowBorders then
        begin
          if ShowCaptions then Dec(FirstRow);
          if ShowNumbers then FirstCol := FirstCol - 1;
          Range := Sheet.Range[ExcelChar(FirstCol) + IntToStr(FirstRow) +
                               ':' + ExcelChar(Column-1)+IntToStr(Row - 1)];
          if (Row - FirstRow)&lt;2
            then ExcelRangeBorders(Range, 3, 2, True, True,
                                   True, True, True, False)
            else ExcelRangeBorders(Range, 3, 2, True, True,
                                   True, True, True, True);
          ExcelFormatRange(Range, 'Arial', 7, True);
        end;
 
      finally
        EnableControls;
      end;
  finally
  end;
end;
 
procedure ExcelSaveWorkBook(Name: String);
begin
  Excel.ActiveWorkbook.SaveAs(Name);
end;
 
 
 
procedure CreateWordAppl(WordVisible : Boolean);
begin
  try
    MsWord := GetActiveOleObject('Word.Application');
    MSWord.Documents.Add;
  except
    try
      MsWord := CreateOleObject('Word.Application');
      MsWord.Visible := WordVisible;
      MSWord.Documents.Add;
    except
      Exception.Create('Error.');
      MSWord := Unassigned;
    end;
  end;
end;
 
procedure MakeWordVisible;
begin
  MsWord.Visible := True;
  MSWord := Unassigned;
end;
 
procedure WordTypeText(S : String);
begin
  MSWord.Selection.TypeText(S);
end;
 
procedure NewParag(Bold : Boolean;
                   Italic : Boolean;
                   ULine : Boolean;
                   Alignment : Integer;
                   FontSize : Integer);
begin
  MsWord.Selection.TypeParagraph;
  MSWord.Selection.ParagraphFormat.Alignment := Alignment;
  MSWord.Selection.Font.Bold := Bold;
  MSWord.Selection.Font.Italic := Italic;
  MSWord.Selection.Font.UnderLine := ULine;
  MSWord.Selection.Font.Size := FontSize;
end;
 
end. 
</pre>


<p> Пример использования:</p>
<pre>
unit Example;
...
uses ..., ExcelModule;
...
procedure Tform1.Button1.Click(Sender: TObject);
begin
  Query1.SQL.Text := 'select * from Table';
  Query1.Open;
  ExcelCreateApplication('Example', 1, True);
  ExcelGetDataSet(Query1, 1, 1, 1, True, True, 1, True, 1, 1);
  ExcelShow;
end;
...
end. 
</pre>

