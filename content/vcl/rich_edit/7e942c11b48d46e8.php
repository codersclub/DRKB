<h1>Как скопировать содержимое одного TRichEdit в другой?</h1>
<div class="date">01.01.2007</div>


<p>TMemoryStream это самый простой инструмент взаимодействия между всеми VCL компонентами:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  MemoryStream:TMemoryStream;
begin
  MemoryStream:=TMemoryStream.Create;
  try
    RichEdit1.Lines.SaveToStream(MemoryStream);
    MemoryStream.Seek(0,soFromBeginning);
    RichEdit2.Lines.LoadFromStream(MemoryStream);
  finally
    MemoryStream.Free;
  end;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

