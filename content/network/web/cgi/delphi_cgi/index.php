<h1>Программирование CGI в Delphi и Kylix (статья)</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Paul TOTH </div>
<div class="author">Перевод с французского: Valery Votintsev </div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<p>Содержание:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Введение</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td><a href="x1.htm">Передача параметров </a></td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td><a href="x2.htm">Переадресация </a></td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td><a href="x3.htm">Вывод изображений </a></td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td><a href="x4.htm">Защита паролем </a></td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td><a href="x5.htm">Куки (Cookies) </a></td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td><a href="x6.htm">Работа с Базами Данных </a></td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td><a href="x7.htm">Частые Вопросы и Ответы </a></td></tr></table></div>
<p>Введение</p>
<p>В настоящем руководстве объясняется, как программировать CGI на Delphi и Kylix.</p>
<p>Автор будет рад Вашим замечаниям и пожеланиям!</p>
<p>Уточнения:</p>
<p>Для работы с CGI вам потребуется Web-сервер (для Delphi - под Windows, а для Kylix - под Linux)...</p>
<p>Автор тестировал свои программы на сервере Lotus Domino под NT, и на сервере Apache под Mandrake 7.0 (linux).</p>
<p>Автор использовал Delphi 2.0, однако это руководство применимо и для Delphi 3,4,5, 6... и Kylix !</p>
<p class="note">Примечание:</p>
<p>Если вы планируете использовать ISAPI/NSAPI DLL, то лучше будет программировать на Delphi 5/6; однако настоящее руководство остается весьма полезным, если Вы желаете разобраться в том, как функционирует CGI.</p>
<p>Основные понятия</p>
<p>Ссылки на CGI-программу:</p>
<p>На HTML-странице (или непосредственно в строке URL браузера) вы помещаете ссылку на вашу программу. Вот несколько примеров ссылок:</p>
<p>Простая ссылка:  &nbsp; &nbsp; &nbsp; &nbsp;&lt;a href="/cgi-bin/program.exe"&gt; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Запрос вывода изображения:  &nbsp; &nbsp; &nbsp; &nbsp;&lt;img src="/cgi-bin/program.exe"&gt; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Форма с запросом типа GET:  &nbsp; &nbsp; &nbsp; &nbsp;&lt;form method=GET action="/cgi-bin/program.exe"&gt; ... &lt;/form&gt; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Форма с запросом типа POST:  &nbsp; &nbsp; &nbsp; &nbsp;&lt;form method=POST action="/cgi-bin/program.exe"&gt; ... &lt;/form&gt; &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Прямое обращение по URL:  &nbsp; &nbsp; &nbsp; &nbsp;http://www.tonserver.fr/cgi-bin/program.exe &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Что такое cgi-bin:</p>
<p>cgi-bin - это псевдоним каталога на сервере, который указывает на реальный каталог, в котором размещены все CGI программы.</p>
<p>Например:</p>
<p>Под Windows:  &nbsp; &nbsp; &nbsp; &nbsp;c:\internet\delphi\cgi &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Под Linux:  &nbsp; &nbsp; &nbsp; &nbsp;/home/httpd/cgi-bin &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>Запуск CGI-программ:</p>
<p>Когда пользователь кликает на ссылке, указывающей на CGI-программу, сервер запускает данную программу и ожидает от нее ответа.</p>
<p>Ответ CGI-программы:</p>
<p>Самым простым вариантом CGI программы может служить консольное приложение {$apptype console}, которое похоже на DOS-программу, однако работает под Windows 95/NT, или под Linux.</p>
<p>Эта возможность позволяет тестировать CGI-программу локально, выводя результат работу на экран.</p>
<p>&nbsp;</p>
<p>Пример простейшей CGI-программы:</p>

<pre>Program ExampleCGI; 
 
{$apptype console}
 
begin
 WriteLn('Content-type: text/html');
 WriteLn;
 WriteLn('Всем привет !');
end.
</pre>

<p>&nbsp;</p>
<p>Разберем строки, выводимые программой:</p>
<p>&nbsp;</p>
<p>1) WriteLn('Content-type: text/html'); - Content-type - это описание типа выводимых данных (в данном случае - текста HTML)</p>
<p>2) WriteLn; - Вывод пустой строки ОБЯЗАТЕЛЕН, для того, чтобы отделить "заголовок" документа от выводимого далее содержимого этого документа.</p>
<p>3) WriteLn('Всем привет !'); - Здесь выводится собственно тело документа, т.е. то, что мы увидим, если нажмем в браузере "Файл - Просмотр в виде HTML"</p>
<p>&nbsp;</p>
<p>Для обращения к программе в строке адреса в браузере необходимо набрать:</p>
<p>&nbsp;</p>
<p>http://ваш_сервер/cgi-bin/ExampleCGI</p>
<p>&nbsp;</p>
<p>Использование Writeln:</p>
<p>&nbsp;</p>
<p>Все, что выводится командой WRITELN, направляется в "устройство стандартного вывода" STDOUT и отправляется сервером в браузер пользователя.</p>
<p>&nbsp;</p>
<p>Интересно, что под Windows можно написать CGI-программу даже с помощью .BAT-файла!</p>
<p>&nbsp;</p>
<p>@ECHO OFF</p>
<p>ECHO content-type: text/html</p>
<p>ECHO.</p>
<p>ECHO ^&lt;HTML^&gt;^&lt;HEAD^&gt;^&lt;TITLE^&gt;^&lt;/TITLE^&gt;^&lt;/HEAD^&gt;^&lt;BODY^&gt;</p>
<p>ECHO Всем привет !</p>
<p>ECHO ^&lt;/BODY^&gt;^&lt;/HTML^&gt;</p>
<p>&nbsp;</p>
<p>Обратите внимание, что специальные символы, используемые в DOS (такие, как "&lt;", "&gt;", "&amp;",...), необходимо предварять знаком "^".</p>
<p>&nbsp;</p>
<p>Не забывайте об этом при написании CGI с .BAT файлами...</p>
<p>&nbsp;</p>
