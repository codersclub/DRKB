<h1>Фильтр посредством логического поля</h1>
<div class="date">01.01.2007</div>


<p>В таблице имеется поле Customer:Boolean. Я хочу чтобы таблица показывала только Customer или только не-customer.</p>

<p>Установите ключ (вы должны иметь индекс для этого поля) одним из указанных способов:</p>

<pre>
tablex.SetRange([False],[False])  // для всех не-customer...
tablex.SetRange([True], [True]])  // для всех customer...
tablex.SetRange([False],[True])   // для всех записей...
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
