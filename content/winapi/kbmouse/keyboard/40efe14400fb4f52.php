<h1>Как выполнять другую команду по нажатию на кнопку, если зажата клавиша Shift?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  if GetKeyState(VK_SHIFT) &lt; 0 then
    ShowMessage('Кнопка Shift нажата')
  else
    ShowMessage('Обычное нажатие кнопки');
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
