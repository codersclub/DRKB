<h1>Как мне узнать о воздействии мыши на иконку, находящуюся на Tray?</h1>
<div class="date">01.01.2007</div>


<p>При&nbsp; добавлении&nbsp; иконки&nbsp; на&nbsp; Tray вы&nbsp; указывали окно - обработчик&nbsp;&nbsp;&nbsp; сообщения&nbsp; и&nbsp; сообщение (CallbackMessage). Теперь окно, указанное&nbsp;&nbsp;&nbsp;&nbsp; вами&nbsp; будет&nbsp; при&nbsp; любых&nbsp; событиях&nbsp; мыши, происходящих над иконкой&nbsp;&nbsp; получать&nbsp; сообщение,&nbsp; указанное&nbsp; при&nbsp; добавлении иконки. При этом&nbsp;&nbsp; параметры lParam и wParam будут задействованы следующим образом:</p>

<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (UINT)wParam&nbsp;&nbsp; -&nbsp;&nbsp; содержит ID иконки, над которой произошло</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; событие</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (UINT)lParam&nbsp;&nbsp; -&nbsp;&nbsp; содержит стандартное событие мыши, такое</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; как WM_MOUSEMOVE или WM_LBUTTONDOWN.</p>

<p>При&nbsp; этом,&nbsp; информация&nbsp; о&nbsp; клавишах&nbsp; смены регистра, так же как и&nbsp;&nbsp;&nbsp;&nbsp; местоположения&nbsp; события, передаваемые при стандартных " настоящих"&nbsp;&nbsp;&nbsp;&nbsp; сообщениях мыши, теряются.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hо&nbsp; положение&nbsp; курсора&nbsp; можно узнать функцией GetCursorPos(), а состояние&nbsp;&nbsp; клавиш&nbsp;&nbsp; смены&nbsp; регистра&nbsp; -&nbsp; функцией&nbsp; GetKeyState(),&nbsp; описанных в winuser.h.</p>

<p>Взято из FAQ:</p>
<a href="https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml]http://blackman.km.ru/myfaq/cont4.phtml</a></p>

