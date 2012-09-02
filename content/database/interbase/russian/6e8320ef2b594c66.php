<h1>В InterBase при создании базы ввести параметр для поддержки русского языка</h1>
<div class="date">01.01.2007</div>


<pre>
UPDATE RDB$FIELDS 
SET RDB$CHARACTER_SET_ID = 52 
WHERE RDB$FIELD_NAME = 'RDB$SOURCE''
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
