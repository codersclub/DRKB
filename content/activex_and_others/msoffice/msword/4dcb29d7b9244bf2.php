<h1>Как экспортировать StringGrid в MS Word таблицу?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
uses 
  ComObj; 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  WordApp, NewDoc, WordTable: OLEVariant; 
  iRows, iCols, iGridRows, jGridCols: Integer; 
begin 
  try 
    // Create a Word Instance 
    // Word Instanz erzeugen 
    WordApp := CreateOleObject('Word.Application'); 
  except 
    // Error... 
    // Fehler.... 
    Exit; 
  end; 
 
  // Show Word 
  // Word anzeigen 
  WordApp.Visible := True; 
 
  // Add a new Doc 
  // Neues Dok einfugen 
  NewDoc := WordApp.Documents.Add; 
 
  // Get number of columns, rows 
  // Spalten, Reihen ermitteln 
  iCols := StringGrid1.ColCount; 
  iRows := StringGrid1.RowCount; 
 
  // Add a Table 
  // Tabelle einfugen 
  WordTable := NewDoc.Tables.Add(WordApp.Selection.Range, iCols, iRows); 
 
  // Fill up the word table with the Stringgrid contents 
  // Tabelle ausfullen mit Stringgrid Daten 
  for iGridRows := 1 to iRows do 
    for jGridCols := 1 to iCols do 
      WordTable.Cell(iGridRows, jGridCols).Range.Text := 
        StringGrid1.Cells[jGridCols - 1, iGridRows - 1]; 
 
  // Here you might want to Save the Doc, quit Word... 
  // Hier evtl Word Doc speichern, beenden... 
 
  // ... 
 
  // Cleanup... 
  WordApp := Unassigned; 
  NewDoc := Unassigned; 
  WordTable := Unassigned; 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
