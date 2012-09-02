<h1>Изменить размер кнопки «Пуск»</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
 begin
   MoveWindow(FindWindowEx(FindWindow('Shell_TrayWnd', nil), 0, 'Button', nil),
              300, 0, 80, 22, true);
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
