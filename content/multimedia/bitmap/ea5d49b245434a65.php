<h1>Сравнение картинок</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
 var
   b1, b2: TBitmap;
   c1, c2: PByte;
   x, y, i,
   different: Integer; // Counter for different pixels 
begin
   b1 := Image1.Picture.Bitmap;
   b2 := Image2.Picture.Bitmap;
   Assert(b1.PixelFormat = b2.PixelFormat); // they have to be equal 
  different := 0;
   for y := 0 to b1.Height - 1 do
   begin
     c1 := b1.Scanline[y];
     c2 := b2.Scanline[y];
     for x := 0 to b1.Width - 1 do
       for i := 0 to BytesPerPixel - 1 do // 1, to 4, dep. on pixelformat 
      begin
         Inc(different, Integer(c1^ &lt;&gt; c2^));
         Inc(c1);
         Inc(c2);
       end;
   end;
 end;
</pre>


<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
