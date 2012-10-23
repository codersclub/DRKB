<h1>Bitmap.PixelFormat := pf24bit;</h1>
<div class="date">01.01.2007</div>


<p>Для pf24bit-изображений необходимо определить:</p>
<pre>
CONST
PixelCountMax = 32768;
 
TYPE
pRGBArray = ^TRGBArray;
TRGBArray = ARRAY[0..PixelCountMax-1] OF TRGBTriple;
</pre>

<p class="note">Примечание: TRGBTriple определен в модуле Windows.PAS.</p>

<p>Для того, чтобы к существующему 24-битному изображению иметь доступ как к изображению, созданному с разрешением 3 байта на пиксел, сделайте следующее:</p>

<pre>
...
VAR
i           :  INTEGER;
j           :  INTEGER;
RowOriginal :  pRGBArray;
RowProcessed:  pRGBArray;
BEGIN
IF   OriginalBitmap.PixelFormat &lt;&gt; pf24bit THEN 
RAISE EImageProcessingError.Create('GetImageSpace:  ' +
'Изображение должно быть 24-х битным.');
{Шаг через каждую строчку изображения.}
FOR j := OriginalBitmap.Height-1 DOWNTO 0 DO
BEGIN
RowOriginal  := pRGBArray(OriginalBitmap.Scanline[j]);
RowProcessed := pRGBArray(ProcessedBitmap.Scanline[j]);
FOR i := OriginalBitmap.Width-1 DOWNTO 0 DO
BEGIN
//           Доступ к RGB-цветам отдельных пикселей должен осуществляться следующим образом:
//           RowProcessed[i].rgbtRed     := RowOriginal[i].rgbtRed;
//           RowProcessed[i].rgbtGreen   := RowOriginal[i].rgbtGreen;
//           RowProcessed[i].rgbtBlue    := RowOriginal[i].rgbtBlue;
END
END
END
...
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

