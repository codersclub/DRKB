<h1>Получить дескриптор панели задач</h1>
<div class="date">01.01.2007</div>

Используем функцию нахождения окна FindWindow, указывая ей в качестве параметров сначала название класса окна, затем его заголовок. Если окно будет найдено, функция выдаст его дескриптор.</p>
<pre>handle_taskbar := FindWindow('Shell_TrayWnd', nil);
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

