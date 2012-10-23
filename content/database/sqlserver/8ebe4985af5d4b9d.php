<h1>Вернуть дату без временной части</h1>
<div class="date">01.01.2007</div>


<pre>
cast(floor(cast(@Date as float)) as datetime)
</pre>

<div class="author">Автор: Vit</div>

