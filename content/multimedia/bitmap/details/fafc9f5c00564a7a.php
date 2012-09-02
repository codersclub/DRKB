<h1>Bitmap.PixelFormat := pf8bit;</h1>
<div class="date">01.01.2007</div>


<p>Доступ к такому формату изображения легко получить, используя TByteArray (определен в SysUtils.PAS):</p>

<pre>
PByteArray = ^TByteArray;
TByteArray = array[0..32767] of Byte;
</pre>

<p>(Я думаю (но сам этого не пробовал), что вы сможете получить доступ к pf16bit-изображениям, используя следующие определения в SysUtils.PAS:</p>

<pre>
PWordArray = ^TWordArray;
TWordArray = array[0..16383] of Word; 
</pre>

<p>Для того, чтобы обработать 8-битное (pf8bit) изображение, используйте конструктор подобный этому, который создает гистограмму изображения:</p>

<pre>
TYPE
THistogram  = ARRAY[0..255] OF INTEGER;
...
 
 
VAR
Histogram:  THistogram;
i      :  INTEGER;
j      :  INTEGER;
Row    :  pByteArray;
 
 
...
FOR i := Low(THistogram) TO High(THistogram) DO
  Histogram[i] := 0;
IF  Bitmap.PixelFormat = pf8bit THEN 
BEGIN
  FOR j := Bitmap.Height-1 DOWNTO 0 DO
    BEGIN
      Row  := pByteArray(Bitmap.Scanline[j]);
      FOR i := Bitmap.Width-1 DOWNTO 0 DO
        BEGIN
          INC (Histogram[Row[i]])
        END
   END
END
...
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

