<h1>Как заполнить поля формы в MS Word?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  ComObj; 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  WordApp: OLEvariant; 
begin 
  Screen.Cursor := crHourglass; 
  try 
    // Create Word Instance 
    WordApp := CreateOleObject('Word.Application'); 
  except 
    ShowMessage('Cannot start MS Word.'); 
    Screen.Cursor := crDefault; 
    Exit; 
  end; 
 
  try 
    // Open a Word Document 
    WordApp.Documents.Add(Template := 'C:\TestDoc.doc'); 
 
    // Show Word 
    WordApp.Visible := True; 
 
    // Check if FormField exists and asign your text 
    if WordApp.ActiveDocument.Bookmarks.Exists('YourFormFieldName') then 
      WordApp.ActiveDocument.FormFields.Item('YourFormFieldName').Result := 'Your Text'; 
  finally 
    WordApp := Unassigned; 
    Screen.Cursor := crDefault; 
  end; 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
