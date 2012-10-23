<h1>Как поместить прозрачный текст на Canvas bitmap</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  OldBkMode: integer;
begin
  Image1.Picture.Bitmap.Canvas.Font.Color := clBlue;
  OldBkMode := SetBkMode(Image1.Picture.Bitmap.Canvas.Handle, TRANSPARENT);
  Image1.Picture.Bitmap.Canvas.TextOut(10, 10, 'Hello');
  SetBkMode(Image1.Picture.Bitmap.Canvas.Handle, OldBkMode);
end;
</pre>
<div class="author">Автор: Олег Кулабухов </div>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
