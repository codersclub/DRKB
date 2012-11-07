<h1>Как передать массив как параметр?</h1>
<div class="date">01.01.2007</div>


<p>Передача параметров процедуры и функции в дельфи:</p>
<pre>
type Ta=array of something;
Var a:Ta;
</pre>
<p class="p_Heading1">Вариант 1.</p>
<pre>
procedure Proc(a:Ta); 
</pre>
<p>внутри процедуры создаётся копия массива, внутри процедуры работа осуществляется только с копией данных. Недостаток: если а имеет большой размер то передача его в процедуру будет долгой и с большими затратами памяти, так как процедура должна будет скопировать всё содержимое и выделить память для копии.</p>
<p class="p_Heading1">Вариант 2.</p>
<pre>
procedure Proc(var a:Ta);
</pre>
<p>внутри процедуры код работает именно с переменной а и её содержимым</p>
<p class="p_Heading1">Вариант 3.</p>
<pre>
procedure Proc(const a:Ta);
</pre>
внутри процедуры запрещено изменять данные переменной а
<p></p>
<p class="p_Heading1">Вариант 4.</p>
<pre>
procedure Proc(out a:Ta);
</pre>
<p>при входе в процедуру массив рассматривается как пустой, но после выполнения процедуры можно получить значения</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
