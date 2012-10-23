<h1>Как заполнить форму и отправить на сервер?</h1>
<div class="date">01.01.2007</div>

<p>Для того, чтобы отправить форму на сервер, необходимо:<br>
&nbsp;<br>
1. Найти форму в исходном тексте страницы.<br>
Для этога найти в исходном тексте страницы теги &lt;form&gt;...&lt;/form&gt;<br>
&nbsp;<br>
<p>Например:</p>
<pre>
&lt;form method=GET action=http://localhost/cgi-bin/mget?&gt;
&lt;input type=text name=name1 value="имя" size="40" maxlength="20"&gt;&lt;br&gt;
&lt;input type=text name=name2 value="фамилия" size="40" maxlength="20"&gt;&lt;br&gt;
&lt;input type=submit&gt;
&lt;/form&gt;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
2. Определить метод, который используется для отправки данных. В указанном выше примере это "GET" - form method=GET<br>
&nbsp;<br>
3. Найти поля, которые необходимо заполнить.<br>
&nbsp;<br>
<p>В примере это:</p>
<pre>
&lt;input type=text name=name1 value="имя" size="40" maxlength="20"&gt;&lt;br&gt;
&lt;input type=text name=name2 value="фамилия" size="40" maxlength="20"&gt;&lt;br&gt;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
4. Используя компоненты для работы с протоколом TCP/IP, сформировать строку запроса.<br>
Для определенности пусть это будет компонент TIdHTTP из пакета Indy, входящий в стандартный набор компонент Delphi.<br>
--------------<br>
&nbsp;<br>
Сформируем строку для отправки на сервер для нашего примера:<br>
&nbsp;<br>
Пусть нам нужно отправить значениядля полей: имя=Vasya, фамилия=Pupkin.<br>
&nbsp;<br>
<p>В этом случае запрос будет выглядеть так:</p>
<pre>
var
  s: String;
begin
  s := IdHTTP1.Get('http://localhost/cgi-bin/mget?name1=Vasya&amp;name2=Pupkin')
</pre>

<p>&nbsp;<br>
<p>В случае, если форма использует метод POST:</p>
<pre>
&lt;form method=POST action=http://localhost/cgi-bin/mget?&gt;
&lt;input type=text name=name1 value="имя" size="40" maxlength="20"&gt;&lt;br&gt;
&lt;input type=text name=name2 value="фамилия" size="40" maxlength="20"&gt;&lt;br&gt;
&lt;input type=submit&gt;
&lt;/form&gt;
</pre>
<p>&nbsp;<br>
&nbsp;<br>
<p>формируем запрос для отправки несколько по-другому:</p>
<pre>
var
  tL: TStringList;
  s: String;
begin
  tL := TStringList.Create;
  tL.Add('name1=Vasya');
  tL.Add('name2=Pupkin');
  try
    s := IdHTTP1.Post('http://localhost/cgi-bin/mget',tL);
  finally
    tL.Free;
  end;
</pre>

<p>&nbsp;<br>
<p>&nbsp;</p>
<div class="author">Автор: Демо</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
