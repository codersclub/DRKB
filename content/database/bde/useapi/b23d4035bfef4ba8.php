<h1>Изменение месторасположения *.NET-файла</h1>
<div class="date">01.01.2007</div>


<p>Кто-нибудь знает как изменить месторасположение файла PDOXUSRS.NET во время выполнения программы?</p>

<p>DbiSetProp(hSessionHandle, sesNetFile, pchar('c:\newdir'));</p>

<p>Для получения дескриптора сеанса, если вы используете сессию по умолчанию, необходимо вызвать DbiGetCurrSession .</p>

<div class="author">Автор: Scott Frolich</div>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

