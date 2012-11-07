<h1>Как удалить иконку с Tray?</h1>
<div class="date">01.01.2007</div>


<p>Для  удаления  иконки  вы  должны  знать  ее  ID  и  дескриптор   окна-обработчика сообщений.   Для    удаления    иконки   с   Tray   надо   вызвать   функцию     Shell_NotifyIcon()   с  параметром  NIM_DELETE  и  указателем  на   экземпляр   структуры  NOTIFYICONDATA,  у  которого  должны  быть  заполнены следующие поля: cbSize, hWnd, uID.</p>

<p>Взято из FAQ:</p>
<a href="https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml</a></p>

