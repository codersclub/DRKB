<h1>Вернуть только время без части даты</h1>
<div class="date">01.01.2007</div>


<pre>
cast(cast(@Date as float)-floor(cast(@Date as float)) as datetime)
</pre>
<div class="author">Автор: Vit</div>

