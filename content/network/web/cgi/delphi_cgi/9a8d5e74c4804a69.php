<h1>Частые Вопросы и Ответы</h1>
<div class="date">01.01.2007</div>


1) Настройка CGI для IIS</p>
Запустите программу </p>
 Пуск/Программы/Microsoft Internet Server/Служба Управления</p>
Кликните два раза на службе WWW, и выберите закладку "Каталоги": </p>
&nbsp;</p>
<p>Каталог &nbsp; &nbsp; &nbsp; &nbsp;Алиас &nbsp; &nbsp; &nbsp; &nbsp;Адрес  &nbsp; &nbsp; &nbsp; &nbsp;Ошибка &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>C:\InetPub\wwwroot &nbsp; &nbsp; &nbsp; &nbsp;&lt;базовый каталог&gt; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>C:\InetPub\scripts &nbsp; &nbsp; &nbsp; &nbsp;/Scripts &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>C:\WINNT\System32\inetsrv\iisadmin  &nbsp; &nbsp; &nbsp; &nbsp;/iisadmin &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
&nbsp;</p>
Кликните на Добавить, укажите каталог, в котором будут содержаться CGI-программы (например C:\DELPHI). </p>
Алиас виртуального каталога, обычно называемый "/cgi bin", заменяет права доступа для чтения на права доступа для "Выполнения". </p>
&nbsp;</p>
<p>Каталог &nbsp; &nbsp; &nbsp; &nbsp;Алиас &nbsp; &nbsp; &nbsp; &nbsp;Адрес  &nbsp; &nbsp; &nbsp; &nbsp;Ошибка &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>C:\InetPub\wwwroot &nbsp; &nbsp; &nbsp; &nbsp;&lt;базовый каталог&gt; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>c:\delphi &nbsp; &nbsp; &nbsp; &nbsp;/cgi-bin &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>C:\InetPub\scripts &nbsp; &nbsp; &nbsp; &nbsp;/Scripts &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>C:\WINNT\System32\inetsrv\iisadmin  &nbsp; &nbsp; &nbsp; &nbsp;/iisadmin &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
&nbsp;</p>
Теперь нам достаточно поместить наши CGI-программы в каталог C:\DELPHI и обращаться к ним примерно так: http://ваш_сервер/cgi-bin/program.exe </p>
&nbsp;</p>
Если ваша NT выдает ошибку прав доступа на конкретном документе, кликните на этом документе, и проверьте, разрешен ли доступ... </p>
&nbsp;</p>
2) Как избавиться от запроса СОХРАНИТЬ/ВЫПОЛНИТЬ при клике на ссылку вида &lt;a href="/cgi-bin/programm.exe"&gt; ?</p>
Для того, чтобы браузер не спрашивал у вас, надо ли сохранить или выполнить вашу CGI-программу, необходимо обязательно размещать выполняемые программы не где попало, а именно в том каталоге, который вы указали серверу в качестве каталога CGI... </p>
&nbsp;</p>
Если вы установили web-сервер на локальный компьютер (localhost), то обращаться к нему нужно следующим образом: </p>
http://127.0.0.1/cgi-bin/programm.exe </p>
