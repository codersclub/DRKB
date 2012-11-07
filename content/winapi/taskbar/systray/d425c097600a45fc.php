<h1>Как изменить иконку на Tray?</h1>
<div class="date">01.01.2007</div>



<p>После добавления иконки на Tray можно менять саму иконку, ToolTip  и  сообщение,  посылаемое  окну.  Для  этого необходимо заполнить  экземпляр     структуры    NOTIFYICONDATA   и   вызвать   функцию  Shell_NotifyIcon()    с   параметром   NIM_MODIFY   и  указателем  на заполненный экземпляр структуры.  При  изменении  иконки  необходимо заполнить поля cbSize, hWnd,   uID,  uFlags  и  поля, отвечающие за параметры иконки, которые вы хотите  менять.  При  этом  uFlags  должен  содержать  комбинацию флагов, описывающую поля, которые необходимо модифицировать.</p>

<p>Взято из FAQ:</p>
<a href="https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml</a></p>
