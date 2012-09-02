<h1>Как запустить текущий screensaver?</h1>
<div class="date">01.01.2007</div>



<p>SendMessage(Application.Handle, WM_SYSCOMMAND, SC_SCREENSAVE, 0); </p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />
<p>Сначала мы проверяем, установлен ли Screen Saver, если нет - возвращаемся с отрицательным ответом, в противном случае - запускаем его и возвращаем true. </p>
<pre>
function RunScreenSaver: bool;
var
  b: boolean;
begin
  result := false;
  if SystemParametersInfo(SPI_GETSCREENSAVEACTIVE, 0, @b, 0) &lt;&gt; true then
    exit;
  if not b then
    exit;
  PostMessage(GetDesktopWindow, WM_SYSCOMMAND, SC_SCREENSAVE, 0);
  result := true;
end;
</pre>
<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
