<h1>OLE и Interbase &ndash; прочесть и записать</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Rob Minte</div>

<pre>
procedure TForm1.ReadOLE;
var
  BS:    TBlobStream;
begin
  BS := TBlobStream.Create(Table1BLOBFIELD_BLOB, bmRead);
  OLEContainer1.LoadFromStream(BS);
  BS.Free;
end;
 
procedure TForm1.WriteOLE;
var
  BS:    TBlobStream;
begin
  BS := TBlobStream.Create(Table1BLOBFIELD_BLOB, bmWrite);
  OLEContainer1.SaveToStream(BS);
  BS.Free;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
