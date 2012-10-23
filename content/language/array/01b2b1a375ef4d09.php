<h1>Как поместить двумерный массив в TImage?</h1>
<div class="date">01.01.2007</div>

Представим, что данные находятся в массиве:</p>
<pre>
TestArray : array[0..127, 0..127] of Byte;
</pre>
<p>Картинка будет иметь размер 128 x 128 точек:</p>
<pre>
Image1.Picture.Bitmap.Width := 128; 
Image1.Picture.Bitmap.Height := 128; 
</pre>
<p>Вызываем функцию Windows API для формирования BitMap:</p>
<pre>
SetBitmapBits(Image1.Picture.Bitmap.Handle, sizeof(TestArray), @TestArray); 
Image1.Refresh; {для того, чтобы изменения отобразились}
</pre>
<p>Однако, если вы используете свою палитру, то ее нужно создать</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
&nbsp;</p>
