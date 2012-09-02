<h1>Проблема с AddIndex</h1>
<div class="date">01.01.2007</div>

<p>При попытке использования AddIndex я получаю ошибку 'Invalid Index/Tag name. (Неверное имя Индекса/Тэга) Index: cusname'. Но у меня нет никаких проблем с этим именем при использовании DeleteIndex.</p>
<p>Есть глючокс с именемани индексов:</p>
<pre>
if IndexName = Fieldname then
  ixCaseSensitive is reqd // по умолчанию
if IndexName <> Fieldname then
  ixCaseInsensitive is reqd
</pre>
<p>Таким образом, вам нужно: </p>
<pre>
InvTbl.AddIndex('cusname', 'name', [ixCaseInsensitive]);
</pre>
<p>или</p>
<pre>InvTbl.AddIndex('name', 'name', []);
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
