<h1>Мое CGI-приложение при обращении к нему ничего не возвращает</h1>
<div class="date">01.01.2007</div>


<p>Вопрос: Мое CGI-приложение при обращении к нему, имеющим вид, например, http://127.0.0.1/cgi-bin/mycgi.exe ничего не возвращает. Что делать? </p>

<p>Установите свойство TWebAction.Default: Boolean в true для той Action из списка, которая должна по обрабатывать запросы тогда, когда это не делает ни одна из других Actions. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
