<h1>Кнопка или пункт меню выполняет другую функцию при нажатой кнопке shift</h1>
<div class="date">01.01.2007</div>


<p>сли вы хотите, чтобы кнопка или пункт меню выполнял другую функцию при нажатой кнопке&nbsp; shift ,</p>
<p>вы можете использовать функцию GetKeyState .</p>

<p>GetKeyState принимает в качестве параметра виртуальный код кнопки и возвращает значение меньше 0,</p>
<p>если кнопка нажата.</p>

<p>Вот пример события&nbsp; OnClick для кнопки:</p>
<pre>
procedure Form1.Button1Click(Sender: TObject);
begin
   if GetKeyState(VK_SHIFT) &lt; 0 then
      ShowMessage('Кнопка Shift нажата')
   else
      ShowMessage('Обычное нажатие кнопки');
end; 
</pre>


<p>Отмечу, что вы можете также использовать параметры VK_CONTROL или VK_MENU</p>
<p> для проверки нажатия кнопок control и&nbsp; alt,&nbsp; соответственно!</p>

<p> &nbsp;&nbsp; Matt Hamilton</p>
<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>

