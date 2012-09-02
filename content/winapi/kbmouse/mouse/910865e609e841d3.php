<h1>Функции и процедуры управления мышью</h1>
<div class="date">01.01.2007</div>


<p>Функция FindVCLWindow( const Pos: TPoint ): TWinControl;</p>
<p>Функция возвращает оконное средство управления для местоположения, определенного параметром Pos. Если для данного местоположения нет оконных средств управления, то функция возвращает nil. </p>
<p>Функция GetCaptureControl: TControl;</p>
<p>Функция возвращает средство управления класса TControl, которое получает в текущий момент все сообщения от мыши.</p>
<p>Функция SetCaptureControl( Control: TControl );</p>
<p>Функция передает управление мышью средству управления, определенному в параметре Control. Данное средство управления будет получать все сообщения от мыши, пока управление мышью не будет передано другому средству управления с помощью функции SetCaptureControl или функцией ReleaseCapture Windows API. </p>
<p>Взято с <a href="https://atrussk.ru/delphi/" target="_blank">https://atrussk.ru/delphi/</a></p>
