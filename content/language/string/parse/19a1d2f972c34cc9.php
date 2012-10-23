<h1>Выделение подстроки по контексту</h1>
<div class="date">01.01.2007</div>

<p>Вот 2 функции которыми я очень часто пользуюсь - они выделяют из строки подстроку, которая находится до или после ключевого словаю Задача надо сказать частая, например есть строка:</p>
<p>"Total-2.00$"</p>
<p>Нижеприведенные функции позволяют выделить из строки логические элементы:</p>
<pre>
function GetBefore(substr, str:string):string;

begin
 if pos(substr,str)&gt;0 then
   result:=copy(str,1,pos(substr,str)-1)
 else
   result:='';
end;
 
function GetAfter(substr, str:string):string;

begin
 if pos(substr,str)&gt;0 then
   result:=copy(str,pos(substr,str)+length(substr),length(str))
 else
   result:='';
end;
</pre>
<p>Примеры:</p>
<p>1) Найти название параметра (оно находится до символа "-"):</p>
GetBefore('-', 'Total-2.00$')  // Результат будет "Total"
<p>&nbsp;</p>
<p>2) Найти сумму денег (оно находится после символа "-"):</p>
GetAfter('-', 'Total-2.00$')  // Результат будет "2.00$"
&nbsp;
<p>&nbsp;</p>
<p>3) Найти сумму денег без знака доллара и остатка строки(оно находится после символа "-", но до символа "$"):</p>
GetBefore('$',GetAfter('-', 'Total-2.00$ (общая сумма)')&nbsp; // Результат будет "2.00"
<p>&nbsp;</p>
<div class="author">Автор: Vit</div>
