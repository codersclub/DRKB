<h1>Как удалить данные из BLOB-поля?</h1>
<div class="date">01.01.2007</div>


<p>Только с использованием SQL</p>
<pre>
UPDATE MyTable
Set MyBlobField = Null
WHERE SomeField = 'Somevalue'
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
