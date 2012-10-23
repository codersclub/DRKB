<h1>Программно нажимаем Print Screen</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Simon Carter</div>
<p>Совместимость: Delphi 3.x (или выше)</p>
<p>Приведённая здесь функция делает копию изображения экрана и сохраняет её в буфере обмена (Clipboard). Так же необходимо включить в Ваш проект файл ClipBrd.pas.</p>
<pre>
procedure SendScreenImageToClipboard; 
var 
  bmp: TBitmap; 
begin 
bmp := TBitmap.Create; 
try 
bmp.Width := Screen.Width; 
bmp.Height := Screen.Height; 
BitBlt(bmp.Canvas.Handle, 0, 0, Screen.Width, Screen.Height, 
GetDC(GetDesktopWindow), 0, 0, SRCCopy); 
Clipboard.Assign(bmp); 
finally 
bmp.Free; 
end; 
end; 
</pre>


<p>Следующая функция скопирует изображение экрана в в bitmap. Переменная bitmap *должна* быть инициализирована до вызова этой функции.</p>
<pre>
procedure GetScreenImage(bmp: TBitmap); 
begin 
bmp.Width := Screen.Width; 
bmp.Height := Screen.Height; 
BitBlt(bmp.Canvas.Handle, 0, 0, Screen.Width, Screen.Height, 
GetDC(GetDesktopWindow), 0, 0, SRCCopy); 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

