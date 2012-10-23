<h1>Как получить результирующим полем разницу между хранимой датой и текущей датой?</h1>
<div class="date">01.01.2007</div>


<pre>
SELECT CAST((поле_с_датой -"NOW") AS INTEGER) FROM MyBase
</pre>


<p>Получишь результат в днях.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
