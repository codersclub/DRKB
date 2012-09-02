<h1>Как записать в BLOB- поле большой текст (более 255 символов)?</h1>
<div class="date">01.01.2007</div>


<pre>
var
  S: TBlobStream;
  B: pointer;
  c: integer;
 
...
 
  Table1.Edit;
  S := TBlobStream.Create(Table1BlobField as TBlobField, bmWrite); {кажется, так}
  C := S.write(B, C);
  Table1.Post;
  S.Destroy;
 
 
или так 
 
var
  S: TMemoryStream;
  B: pointer;
  C: integer;
 
...
 
S := TMemoryStream.Create;
 
...
 
  Table1.Edit;
  S.Clear;
  S.SetSize(C);
  C := S.write(B,C);
  (Table1BlobField as TBlobField).LoadFromStream(S);
  S.Clear;
  Table1.Post;
 
...
 
S.Destroy;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
