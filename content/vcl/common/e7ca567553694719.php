<h1>Как заставить приложение показывать различные иконки при различных разрешениях дисплея?</h1>
<div class="date">01.01.2007</div>


<p>Для этого достаточно текущее разрешение экрана и в соответствии с ним изменить дескриптор иконки приложения. Естевственно, что Вам прийдётся создать в ресурсах новые иконки.</p>

<p>Поместите следующий код в файл проекта (.DPR) Вашего приложения:</p>
<pre>
Application.Initialize;
Application.CreateForm(TForm1, Form1);
case GetDeviceCaps(GetDC(Form1.Handle), HORZRES) of
  640: Application.Icon.Handle := LoadIcon(hInstance, 'ICON640');
  800: Application.Icon.Handle := LoadIcon(hInstance, 'ICON800');
  1024: Application.Icon.Handle := LoadIcon(hInstance, 'ICON1024');
  1280: Application.Icon.Handle := LoadIcon(hInstance, 'ICON1280');
end;
Application.Run;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

