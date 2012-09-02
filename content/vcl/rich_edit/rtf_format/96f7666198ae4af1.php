<h1>Как текст из TRXRichEdit сохранить в RTF формате?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);

 
  var t:TFileStream;
begin
  t:=TFileStream.create('c:\myfilename.txt', fmCreate or fmOpenWrite);
  t.Size:=0;
  RxRichEdit1.Lines.SaveToStream(t);
  t.free;
end;
</pre>

<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

