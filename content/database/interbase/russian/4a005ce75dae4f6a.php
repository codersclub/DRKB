<h1>Как заставить InterBase принять COLLATE PXW_CYRL по умолчанию?</h1>
<div class="date">01.01.2007</div>


<p>(Это очень полезно при прямой работе с IB из различного CASE-инструментария, типа PowerDesigner или ErWIN) </p>

<p>Чтобы не писать каждый раз COLLATE, я сделал следующее: </p>

<p>Создал сохранённую процедуру</p>
<pre>
create procedure fix_character_sets
as
begin
update
rdb$character_sets
set
rdb$default_collate_name = 'PXW_CYRL'
where
rdb$character_set_name = 'WIN1251'
and
rdb$default_collate_name = 'WIN1251'
;
end
</pre>

<p>Запустил ее один раз. </p>

<p>Создаю таблицы без указания COLLATE. </p>

<p>После восстановления из архива, запускаю еще раз.</p>

<p class="author">Автор: Nomadic</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
