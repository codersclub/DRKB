<h1>При попытке регистрации UDF возникает ошибка &ndash; udf not defined</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Nomadic&nbsp; </p>

<p>Располагайте DLL в каталоге Interbase/Bin, или в одном из каталогов, в которых ОС обязательно будет произведен поиск этой библиотеки (для Windows это %SystemRoot% и %Path%); </p>

<p>При декларировании функции не следует указывать расширение модуля (в Windows по умолчанию DLL):</p>

<pre>
declare external function f_SubStr
cstring(254), integer, integer
returns
cstring(254)
entry_point "Substr" module_name "UDF1"
</pre>

<p>Где UDF1 - UDF1.DLL. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
