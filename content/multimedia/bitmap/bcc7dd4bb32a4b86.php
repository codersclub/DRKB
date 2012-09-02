<h1>Назначение палитры bitmap</h1>
<div class="date">01.01.2007</div>


<p>Если вы рисуете на TImage.... </p>

<p>Во-первых, вам нужно использовать Image1.Picture.bitmap, а не Image.Canvas. Причина кроется в том, что Image1.Picture.Bitmap имеет палитру, в Timage нет. Затем палитру необходимо назначить. Вот пример:</p>

<pre>
// Устанавливаем Width и Height перед использованием
// Image1.Picture c Bitmap Canvasvar
 
Bitmap: TBitmap;
begin
  Bitmap:=TBitmap.Create;
  Bitmap.LoadfromFile({'Whatever.bmp'});
 
  With Image2.Picture.bitmap do
  Begin
    Width:=Bitmap.Width;
    height:=Bitmap.Height;
    Palette:=Bitmap.Palette;
    Canvas.draw(0,0,bitmap);
    Refresh;
  end;
end;
</pre>

<p>Если вы рисуете на канве формы...</p>
<pre>
Canvas.Draw(0,0,Bitmap);
SelectPalette(Form1.Canvas.handle,Bitmap.Palette,True);
RealizePalette(Form1.Canvas.Handle);
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
