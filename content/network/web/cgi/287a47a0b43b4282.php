<h1>Простейшая авторизация в ISAPI/CGI приложениях</h1>
<div class="date">01.01.2007</div>


<p>Самый простой способ защитить директорию на web сервере - это применить авторизацию. Этот пример показывает как это сделать используя только ISAPI приложение.</p>
<p>Совместимость: Delphi 5.x (или выше)</p>
<p>Исходный код:</p>
<p>============</p>
<p>- Эти две строчки заставляют браузер спросить имя пользователя и пароль:</p>
<p>Response.StatusCode := 401; // Запрос логина и пароля</p>
<p>Response.WWWAuthenticate := 'Basic realm="Delphi"'; // Заголовок</p>
<p>- Браузер посылает имя пользователя и пароль и мы получаем их:</p>
<p>Request.Authorization</p>
<p>- Но информация закодирована в Base64. Существует довольно много исходников, которые показывают как кодировать/декодировать в Base64. Следующая строчка возвращает декодированные данные в mAuthorization.</p>
<p>FBase64.DecodeData(Copy(Request.Authorization, 6,</p>
<p>Length(Request.Authorization)), mAuthorization);</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
