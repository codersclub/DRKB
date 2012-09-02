<h1>Как программно заставить выпасть меню?</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: InSAn</p>

<p>В примере показано как показать меню и выбрать в нем какой-то пункт, эмулируя нажатие "быстрой кдавиши" пункта меню. Если у Вашего пункта меню нет "быстрой клавиши" Вы можете посылать комбинации VK_MENU, VK_LEFT, VK_DOWN, и VK_RETURN, чтобы программно "путешествовать" по меню.</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  //Allow button to finish painting in response to the click
  Application.ProcessMessages;
  {Alt Key Down}
  keybd_Event(VK_MENU, 0, 0, 0);
  {F Key Down - Drops the menu down}
  keybd_Event(ord('F'), 0, 0, 0);
  {F Key Up}
  keybd_Event(ord('F'), 0, KEYEVENTF_KEYUP, 0);
  {Alt Key Up}
  keybd_Event(VK_MENU, 0, KEYEVENTF_KEYUP, 0);
  {F Key Down}
  keybd_Event(ord('S'), 0, 0, 0);
  {F Key Up}
  keybd_Event(ord('S'), 0, KEYEVENTF_KEYUP, 0);
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

