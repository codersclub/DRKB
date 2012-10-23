<h1>TStringGrid и файловый поток</h1>
<div class="date">01.01.2007</div>

Какое наилучшее решение для сохранения экземпляра TStringGrid (150x10)?</p>
<p>Если вы хотите сохранить это на диске:</p>
<pre>var:
  myStream: TFileStream;
begin
  myStream1 := TFileStream.Create('grid1.sav', fmCreate);
  myStream1.WriteComponent(StringGrid1);
  myStream1.Destroy;
end;
 
//Для обратного чтения:
 
 
myStream    := TFileStream.Create('grid1.sav', fmOpenRead);
StringGrid1 := myStream1.ReadComponent(StringGrid1) as TStringGrid;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

