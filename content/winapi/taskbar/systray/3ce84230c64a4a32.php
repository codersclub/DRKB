<h1>Как сделать popup меню при щелчке иконке в tray?</h1>
<div class="date">01.01.2007</div>


<p>Многие программы показывают Pop-Up меню при щелчке на их иконке,&nbsp; помещенной на Tray, как этого добиться ?</p>

<p>Вы&nbsp; должны&nbsp; обрабатывать сообщение, указанное вами при добавлении&nbsp;&nbsp; иконки&nbsp; на Tray. При значении (UINT)lParam, равном WM_RBUTTONDOWN&nbsp; (это обычно дял Pop-Up меню по правой кнопке), или любому другому&nbsp; необходимому&nbsp;&nbsp; вам,&nbsp; вы&nbsp; должны&nbsp; вызовом&nbsp; функции&nbsp; GetCursorPos()&nbsp; получить&nbsp; позицию&nbsp; курсора в момент события (вряд ли пользователь&nbsp;&nbsp;&nbsp;&nbsp; успеет&nbsp; убрать&nbsp; мышь&nbsp; за время обработки сообщения, особенно если&nbsp;&nbsp; он ожидает меню), получить вескриптор Pop-Up меню одним из многих&nbsp; способов&nbsp; (LoadMenu(),&nbsp; GetSubMenu(),&nbsp; CreateMenu(),&nbsp; и&nbsp; т.д.)&nbsp; и&nbsp;&nbsp;&nbsp; выполнить следующий код:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<pre>
SetForegroundWindow(hWnd);
TrackPopupMenuEx(hMenu,TPM_HORIZONTAL|TPM_LEFTALIGN,x, y,hWnd, NULL);
DestroyMenu(hMenu);
PostMessage(hWnd,WM_USER,0,0);    
</pre>

<p>где&nbsp; hWnd&nbsp; -&nbsp; дескриптор окна, которое будет обрабатывать команду&nbsp; меню,&nbsp; </p>
<p>hMenu - дескриптор меню, </p>
<p>x&nbsp; и&nbsp; y&nbsp; -&nbsp; позиция&nbsp; курсора. </p>

<p>Для подробностей смотрите Win32 SDK Help по функции TrackPopupMenuEx.</p>

<p>Взято из FAQ: </p>
<a href="https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml</a></p>

