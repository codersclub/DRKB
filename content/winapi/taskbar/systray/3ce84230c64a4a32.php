<h1>Как сделать popup меню при щелчке иконке в tray?</h1>
<div class="date">01.01.2007</div>


<p>Многие программы показывают Pop-Up меню при щелчке на их иконке,  помещенной на Tray, как этого добиться ?</p>

<p>Вы  должны  обрабатывать сообщение, указанное вами при добавлении   иконки  на Tray. При значении (UINT)lParam, равном WM_RBUTTONDOWN  (это обычно дял Pop-Up меню по правой кнопке), или любому другому  необходимому   вам,  вы  должны  вызовом  функции  GetCursorPos()  получить  позицию  курсора в момент события (вряд ли пользователь     успеет  убрать  мышь  за время обработки сообщения, особенно если   он ожидает меню), получить вескриптор Pop-Up меню одним из многих  способов  (LoadMenu(),  GetSubMenu(),  CreateMenu(),  и  т.д.)  и    выполнить следующий код:</p>
<pre>
SetForegroundWindow(hWnd);
TrackPopupMenuEx(hMenu,TPM_HORIZONTAL|TPM_LEFTALIGN,x, y,hWnd, NULL);
DestroyMenu(hMenu);
PostMessage(hWnd,WM_USER,0,0);    
</pre>

<p>где  hWnd  -  дескриптор окна, которое будет обрабатывать команду  меню,</p>
<p>hMenu - дескриптор меню,</p>
<p>x  и  y  -  позиция  курсора.</p>

<p>Для подробностей смотрите Win32 SDK Help по функции TrackPopupMenuEx.</p>

<p>Взято из FAQ:</p>
<a href="https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml</a></p>

