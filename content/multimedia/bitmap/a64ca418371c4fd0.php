<h1>Вставить Bitmap</h1>
<div class="date">01.01.2007</div>


<pre>
function InvertBmp1(SourceBmp: TBitmap): TBitMap;
 var
   i, j: Longint;
   tmp: TBitMap;
   red, green, blue: Byte;
   PixelColor: Longint;
 begin
   tmp := TBitmap.Create;
   tmp.Width  := SourceBmp.Width;
   tmp.Height := SourceBmp.Height;
   for i := 0 to SourceBmp.Width - 1 do
   begin
     for j := 0 to SourceBmp.Height - 1 do
     begin
       PixelColor := ColorToRGB(SourceBmp.Canvas.Pixels[i, j]);
       red := PixelColor;
       green := PixelColor shr 8;
       blue := PixelColor shr 16;
       red  := 255 - red;
       green := 255 - green;
       blue := 255 - blue;
       tmp.Canvas.pixels[i, j] := (red shl 8 + green) shl 8 + blue;
     end;
   end;
   Result := tmp;
 end;
 
 function InvertBmp2(ABitmap : TBitmap) : TBitmap;
 var
   l_bmp : TBitmap;
 begin
   l_bmp := TBitmap.Create;
   l_bmp.Width := ABitmap.Width;
   l_bmp.Height := ABitmap.Height;
   l_bmp.PixelFormat := ABitmap.PixelFormat;
   BitBlt( l_bmp.Canvas.Handle, 0, 0, l_bmp.Width, l_bmp.Height,
     ABitmap.Canvas.Handle, 0, 0, SRCINVERT );
   result := l_bmp;
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
