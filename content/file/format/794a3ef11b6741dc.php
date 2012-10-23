<h1>DOC &gt; HTML</h1>
<div class="date">01.01.2007</div>


<pre>
var
  fname: string;
  WordAppl, WordDoc: OleVariant;
begin
  with TOpenDialog.Create(nil) do
  try
    Filter := 'word documents (*.doc)|*.doc';
    if not Execute then Exit;
    fname := FileName;
  finally
    Free;
  end;
  WordAppl := CreateOleObject('Word.Application');
  try
    WordDoc := WordAppl.Documents.Open(fname);
    fname := ExtractFilePath(fname) + 'test.htm';
    WordDoc.SaveAs(FileName := fname, FileFormat := wdFormatHTML);
  finally
    WordAppl.Quit;
  end;
end;
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: jack128</div>
