<h1>Изменение палитры при выводе изображения</h1>
<div class="date">01.01.2007</div>


<p>Да, это не тривиальная задача! Палитра дочернего MDI-окна попортила нервов не одному мне.</p>
<p>В обработчике сообщения WM_PaletteChanged вы можете убедиться, что видимая TImage.Picture.Bitmap.Palette всегда "реализована". Так..</p>
<pre>
private
 
procedure WMPaletteChanged(var Msg: TWMPaletteChanged);
  message WM_PaletteChanged;
 
...
 
procedure Form1.WMPaletteChanged(var Msg: TWMPaletteChanged);
begin
  if Msg.PalChg &lt;&gt; Form1.Handle then
  begin
    PaletteChanged(true);
    Msg.Result := 0;
  end;
end;
</pre>


<p>Теперь вы можете масштабировать неотображенное изображение как вы хотите и не иметь проблем. Единственное, о чем вам необходимо помнить, если вы хотите вывести неотображенное изображение на видимый TImage, вам необходимо вызвать PaletteChanged снова после того, как изображение выведено. С кодом, который мы использовали...</p>
<p>Image1.Picture.Bitmap := obitmap;</p>
<p>PaletteChanged(true);</p>

<p>Если вы не делаете этот вызов, изображение отобразится с неправильной палитрой.</p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
