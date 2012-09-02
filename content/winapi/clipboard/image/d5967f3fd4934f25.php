<h1>Скопировать изображение формы</h1>
<div class="date">01.01.2007</div>


<pre>
uses clipbrd;
 
procedure TShowVRML.Kopieren1Click(Sender: TObject);
var
  bitmap: tbitmap;
begin
  bitmap := tbitmap.create;
  bitmap.width := clientwidth;
  bitmap.height := clientheight;
  try
    with bitmap.Canvas do
      CopyRect(clientrect, canvas, clientrect);
    clipboard.assign(bitmap);
  finally
    bitmap.free;
  end;
end;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
