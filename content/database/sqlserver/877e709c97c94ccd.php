<h1>Конвертирование числа в строку, которую понимает Excel</h1>
<div class="date">01.01.2007</div>


<pre>
 /* Функция переводит число в строковое выражение числа с запятой, которое понимает Ёксель
 15.11.02  */
 
CREATE FUNCTION Float2Str
(@val as float )
RETURNS varchar(24)
 AS  
BEGIN 
 
declare @s as varchar(24)
set @s=str(@val,21,2)
return stuff(@s,len(@s)-2,1,',')
 
END
</pre>

<p class="author">Автор: Sh@dow </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
