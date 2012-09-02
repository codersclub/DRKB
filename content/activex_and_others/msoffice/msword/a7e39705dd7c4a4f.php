<h1>Как экспортировать таблицу в MS Word в TStringGrid?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  ComObj; 
 
procedure TForm1.Button1Click(Sender: TObject); 
const 
  AWordDoc = 'C:\xyz\testTable.doc'; 
var 
  MSWord, Table: OLEVariant; 
  iRows, iCols, iGridRows, jGridCols, iNumTables, iTableChosen: Integer; 
  CellText: string; 
  InputString: string; 
begin 
  try 
    MSWord := CreateOleObject('Word.Application'); 
  except 
    // Error.... 
    Exit; 
  end; 
 
  try 
    MSWord.Visible := False; 
    MSWord.Documents.Open(AWordDoc); 
 
    // Get number of tables in document 
    iNumTables := MSWord.ActiveDocument.Tables.Count; 
 
    InputString := InputBox(IntToStr(iNumTables) + 
      ' Tables in Word Document', 'Please Enter Table Number', '1'); 
    // Todo: Validate string for integer, range... 
    iTableChosen := StrToInt(InputString); 
 
    // access table 
    Table := MSWord.ActiveDocument.Tables.Item(iTableChosen); 
    // get dimensions of table 
    iCols := Table.Rows.Count; 
    iRows := Table.Columns.Count; 
    // adjust stringgrid columns 
    StringGrid1.RowCount := iCols; 
    StringGrid1.ColCount := iRows + 1; 
 
    // loop through cells 
    for iGridRows := 1 to iRows do 
      for jGridCols := 1 to iCols do 
      begin 
        CellText := Table.Cell(jGridCols, iGridRows).Range.FormattedText; 
        if not VarisEmpty(CellText) then 
        begin 
          // Remove Tabs 
          CellText := StringReplace(CellText, 
            #$D, '', [rfReplaceAll]); 
          // Remove linebreaks 
          CellText := StringReplace(CellText, #$7, '', [rfReplaceAll]); 
 
          // fill Stringgrid 
          Stringgrid1.Cells[iGridRows, jGridCols] := CellText; 
        end; 
      end; 
    //.. 
  finally 
    MSWord.Quit; 
  end; 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
