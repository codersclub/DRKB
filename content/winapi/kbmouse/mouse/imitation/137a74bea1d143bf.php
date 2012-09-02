<h1>Как использовать mouse_event() для эмулирования событий мышки?</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример демонстрирует использование API функции mouse_event() для эмуляции событий мышки. Когда Button2 нажата, то мышь перемещается на Button1 и щёлкает по ней. Координаты мыши даны в "Mickeys", где 65535 соответствует ширине экрана.</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  ShowMessage('Button 1 clicked'); 
end; 
 
procedure TForm1.Button2Click(Sender: TObject); 
var 
  Pt : TPoint; 
begin 
{Allow Button2 to repaint it's self} 
  Application.ProcessMessages; 
{Получаем координаты центра button 1} 
  Pt.x := Button1.Left + (Button1.Width div 2); 
  Pt.y := Button1.Top + (Button1.Height div 2); 
{Преобразуем Pt в координаты экрана} 
  Pt := ClientToScreen(Pt); 
{Преобразуем Pt в mickeys} 
  Pt.x := Round(Pt.x * (65535 / Screen.Width)); 
  Pt.y := Round(Pt.y * (65535 / Screen.Height)); 
{Перемещаем мышку} 
  Mouse_Event(MOUSEEVENTF_ABSOLUTE or 
              MOUSEEVENTF_MOVE, 
              Pt.x, 
              Pt.y, 
              0, 
              0); 
{Эмулируем нажатие левой кнопки мыши} 
  Mouse_Event(MOUSEEVENTF_ABSOLUTE or 
              MOUSEEVENTF_LEFTDOWN, 
              Pt.x, 
              Pt.y, 
              0, 
              0);; 
{Эмулируем отпускание левой кнопки мыши} 
  Mouse_Event(MOUSEEVENTF_ABSOLUTE or 
              MOUSEEVENTF_LEFTUP, 
              Pt.x, 
              Pt.y, 
              0, 
              0);; 
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

