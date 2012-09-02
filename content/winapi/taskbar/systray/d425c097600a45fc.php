<h1>Как изменить иконку на Tray?</h1>
<div class="date">01.01.2007</div>



<p>После добавления иконки на Tray можно менять саму иконку, ToolTip&nbsp; и&nbsp; сообщение,&nbsp; посылаемое&nbsp; окну.&nbsp; Для&nbsp; этого необходимо заполнить&nbsp; экземпляр&nbsp;&nbsp;&nbsp;&nbsp; структуры&nbsp;&nbsp;&nbsp; NOTIFYICONDATA&nbsp;&nbsp; и&nbsp;&nbsp; вызвать&nbsp;&nbsp; функцию&nbsp; Shell_NotifyIcon()&nbsp;&nbsp;&nbsp; с&nbsp;&nbsp; параметром&nbsp;&nbsp; NIM_MODIFY&nbsp;&nbsp; и&nbsp; указателем&nbsp; на заполненный экземпляр структуры.&nbsp; При&nbsp; изменении&nbsp; иконки&nbsp; необходимо заполнить поля cbSize, hWnd,&nbsp;&nbsp; uID,&nbsp; uFlags&nbsp; и&nbsp; поля, отвечающие за параметры иконки, которые вы хотите&nbsp; менять.&nbsp; При&nbsp; этом&nbsp; uFlags&nbsp; должен&nbsp; содержать&nbsp; комбинацию флагов, описывающую поля, которые необходимо модифицировать.</p>

<p>Взято из FAQ: </p>
<a href="https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml</a></p>
