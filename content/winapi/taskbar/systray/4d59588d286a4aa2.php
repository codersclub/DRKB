<h1>Как удалить иконку с Tray?</h1>
<div class="date">01.01.2007</div>


<p>Для&nbsp; удаления&nbsp; иконки&nbsp; вы&nbsp; должны&nbsp; знать&nbsp; ее&nbsp; ID&nbsp; и&nbsp; дескриптор&nbsp;&nbsp; окна-обработчика сообщений.&nbsp;&nbsp; Для&nbsp;&nbsp;&nbsp; удаления&nbsp;&nbsp;&nbsp; иконки&nbsp;&nbsp; с&nbsp;&nbsp; Tray&nbsp;&nbsp; надо&nbsp;&nbsp; вызвать&nbsp;&nbsp; функцию&nbsp;&nbsp;&nbsp;&nbsp; Shell_NotifyIcon()&nbsp;&nbsp; с&nbsp; параметром&nbsp; NIM_DELETE&nbsp; и&nbsp; указателем&nbsp; на&nbsp;&nbsp; экземпляр&nbsp;&nbsp; структуры&nbsp; NOTIFYICONDATA,&nbsp; у&nbsp; которого&nbsp; должны&nbsp; быть&nbsp; заполнены следующие поля: cbSize, hWnd, uID.</p>

<p>Взято из FAQ:</p>
<a href="https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml</a></p>

