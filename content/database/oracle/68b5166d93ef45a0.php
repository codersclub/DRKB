<h1>Как настроить Personal Oracle с русским языком на корректную работу с числами и BDE</h1>
<div class="date">01.01.2007</div>



<p>прописать в </p>

<p>\HKEY_LOCAL_MACHINE\SOFTWARE\ORACLE параметр:</p>
<p>NLS_NUMERIC_CHARACTERS = '.,' </p>

<p>или </p>

<p>после соединения с ORACLE выполнить</p>
<pre>ALTER SESSION SET NLS_NUMERIC_CHARACTERS = '.,' 
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
