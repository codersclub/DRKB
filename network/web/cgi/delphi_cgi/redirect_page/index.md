---
Title: Переадресация
Date: 01.01.2007
---


Переадресация
=============

::: {.date}
01.01.2007
:::

Переадресация

Заголовок HTTP-ответа

Мы уже знаем, что CGI-программа отсылает серверу заголовок, не
отображаемый браузером:

WriteLn(\'Content-Type: text/html\');

WriteLn(\'\');

Вид заголовка для переадресации

Следует отметить, что в заголовке может быть приведено множество других
директив, в частности, CGI-программа может переадресовать запрос на
другую страницу...

Для переадресации достаточно вывести заголовок в следующем виде:

WriteLn(\'Location: redirection.htm\');

WriteLn(\'\');

Кроме того, ваш сервер автоматически добавляет в этот заголовок еще и
свои собственные сообщения.

Допустим, вы запрашиваете в браузере URL http://yahoo.com. В этом случае
вы получите от сервера следующий ответ:

HTTP/1.0 302 Found

Location: http://www.yahoo.com

Получив такой заголовок, браузер перезапрашивает у сервера новый URL
http://www.yahoo.com, и в ответ получает следующее:

HTTP/1.0 200 OK

Content-Length: 9332

Expires: Wed, 18 Mar 1998 08:00:03 GMT     

Content-Type: text/html

 

\<html\>\<head\>\<title\>Yahoo!\</title\>

\<base href="https://www.yahoo.com/"\>\</head\>

\<body\>\<center\>

\<form action="http://search.yahoo.com/bin/search"\>

\<a href="/bin/top3"\>

\<img width=460 height=59 border=0 usemap="#top3" ismap

   src="http://us.yimg.com/i/main32.gif" alt="Yahoo!"\>\</a\>

\<br\>

\<table cellpadding=3 cellspacing=0\>

   \<tr\>

     \<td align=center nowrap\>

...

Таким образом происходит просто переадресация на другую страницу!

 

И последнее замечание: вам не нужно заботиться самим о выводе строк типа
"HTTP/1.0...", и "Content-Length: ...", поскольку это делает
автоматически сам сервер.
