<h1>Как послать нажатие кнопки мыши в окно?</h1>
<div class="date">01.01.2007</div>


<p>WM_LBUTTONDOWN</p>
<p>WM_RBUTTONDOWN</p>
<div class="author">Автор: Song</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Я решил проверить точку нажатия мышки таким вот образом:</p>
<p>...</p>
<p>SetForegroundWindow(WindowUO);</p>
<p>mouse_event(MOUSEEVENTF_MOVE,400,400,0,0);</p>
<p>...</p>
<p>и получилось, что мышка перемещалась не в те координаты(относительно разрешения монитора (800 на 600)) которые я задумал(в не зависимости от местоположения мышки она перемещалась строго по одному направлению на одинаковое расстояние), причем я сделал еще один вариант - dx=100, dy=100, но тогда перемещение мышки произошло в другую сторону(в сторону x=0 y=0 монитора)!</p>
<p>Подскажите плз в чем дело?</p>
<div class="author">Автор: Spawn</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Mouse_event программирует не абсолюьные, а относительные координаты.</p>
<p>Чтобы не думалось, просто сначала установите курсор в нужную позицию - SetCursorPos(), а потом делайте клик - Mouse_event()</p>
<div class="author">Автор: Song</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>На форму вынесите компонент TTimer и опишите его единственное событие следующим образом:</p>
<pre>
procedure TForm1.Timer1Timer(Sender: TObject);
var
  x, y: Integer;
begin
  x := random(Screen.Width);
  y := random(Screen.Height);
  sendmessage(Handle, WM_LBUTTONDOWN, MK_LBUTTON, x + y shl 16);
  sendmessage(Handle, WM_LBUTTONUP, MK_LBUTTON, x + y shl 16);
end;
</pre>
<p>Для того, чтобы убедиться, что сообщения на самом деле посылаются, давайте обработаем событие OnMouseDown для формы. Мы попытаем обозначать те места, где якобы была нажата кнопка мыши.</p>
<pre>
procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
Shift: TShiftState; X, Y: Integer);
begin
  Form1.Canvas.Ellipse(x - 2, y - 2, x + 2, y + 2);
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<pre>
// Set the mouse cursor to position x,y: 
// Maus an Position x,y setzen: 
SetCursorPos(x, y);
 
 // Simulate the left mouse button down 
// Linke Maustaste simulieren 
mouse_event(MOUSEEVENTF_LEFTDOWN, 0, 0, 0, 0);
 mouse_event(MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);
 
 // Simulate the right mouse button down 
// Rechte Maustaste simulieren 
mouse_event(MOUSEEVENTF_RIGHTDOWN, 0, 0, 0, 0);
 mouse_event(MOUSEEVENTF_RIGHTUP, 0, 0, 0, 0);
 
 // Simulate a double click 
// Einen Doppelklick simulieren 
mouse_event(MOUSEEVENTF_LEFTDOWN, 0, 0, 0, 0);
 mouse_event(MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);
 GetDoubleClickTime;
 mouse_event(MOUSEEVENTF_LEFTDOWN, 0, 0, 0, 0);
 mouse_event(MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);
 
 // Simulate a double click on a panel 
// Einen Doppelklick auf einen Panel simulieren 
SendMessage(Panel1.Handle, WM_LBUTTONDBLCLK, 10, 10)
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

