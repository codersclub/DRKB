<h1>Переадресация</h1>
<div class="date">01.01.2007</div>


<p>Переадресация</p>
Заголовок HTTP-ответа</p>
Мы уже знаем, что CGI-программа отсылает серверу заголовок, не отображаемый браузером: </p>
  WriteLn('Content-Type: text/html');</p>
  WriteLn(''); </p>
Вид заголовка для переадресации</p>
Следует отметить, что в заголовке может быть приведено множество других директив, в частности, CGI-программа может переадресовать запрос на другую страницу... </p>
Для переадресации достаточно вывести заголовок в следующем виде: </p>
  WriteLn('Location: redirection.htm');</p>
  WriteLn(''); </p>
Кроме того, ваш сервер автоматически добавляет в этот заголовок еще и свои собственные сообщения. </p>
Допустим, вы запрашиваете в браузере URL http://yahoo.com. В этом случае вы получите от сервера следующий ответ: </p>
  HTTP/1.0 302 Found</p>
  Location: http://www.yahoo.com</p>
Получив такой заголовок, браузер перезапрашивает у сервера новый URL http://www.yahoo.com, и в ответ получает следующее: </p>
  HTTP/1.0 200 OK</p>
  Content-Length: 9332</p>
  Expires: Wed, 18 Mar 1998 08:00:03 GMT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
  Content-Type: text/html</p>
&nbsp;</p>
  &lt;html&gt;&lt;head&gt;&lt;title&gt;Yahoo!&lt;/title&gt;</p>
  &lt;base href="https://www.yahoo.com/"&gt;&lt;/head&gt;</p>
  &lt;body&gt;&lt;center&gt;</p>
  &lt;form action="http://search.yahoo.com/bin/search"&gt;</p>
  &lt;a href="/bin/top3"&gt;</p>
  &lt;img width=460 height=59 border=0 usemap="#top3" ismap</p>
 &nbsp;&nbsp; src="http://us.yimg.com/i/main32.gif" alt="Yahoo!"&gt;&lt;/a&gt;</p>
  &lt;br&gt;</p>
  &lt;table cellpadding=3 cellspacing=0&gt;</p>
 &nbsp;&nbsp; &lt;tr&gt;</p>
 &nbsp;&nbsp;&nbsp;&nbsp; &lt;td align=center nowrap&gt;</p>
  ...</p>
Таким образом происходит просто переадресация на другую страницу! </p>
&nbsp;</p>
И последнее замечание: вам не нужно заботиться самим о выводе строк типа "HTTP/1.0...", и "Content-Length: ...", поскольку это делает автоматически сам сервер. </p>
