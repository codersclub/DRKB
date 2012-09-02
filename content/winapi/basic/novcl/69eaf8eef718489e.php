<h1>Как заставить приложение Delphi отвечать на сообщения Windows?</h1>
<div class="date">01.01.2007</div>


<p>Используем WM_WININICHANGED в качестве примера :</p>

<p>Объявление метода в TForm позволит вам обрабатывать сообщение WM_WININICHANGED:</p>

<p>procedure WMWinIniChange(var Message: TMessage); message WM_WININICHANGE;</p>

<p>Код в implementation может выглядеть так:</p>

<pre>
procedure TForm1.WMWinIniChange(var Message: TMessage);
        begin
          inherited;
        { ... ваша реакция на событие ... }
        end;
</pre>


<p>Вызов inherited метода очень важен. Обратите внимание также на то, что для функций, объявленных с директивой message (обработчиков событий Windows) после inherited нет имени наследуемой процедуры, потому что она может быть неизвестна или вообще отсутствовать (в этом случае вы в действительности вызываете процедуру DefaultHandler).</p>
<p>Copyright © 1996 Epsylon Technologies</p>
<p>Взято из FAQ Epsylon Technologies (095)-913-5608; (095)-913-2934; (095)-535-5349</p>

