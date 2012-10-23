<h1>Почему возникает ошибка «Access Violation»?</h1>
<div class="date">01.01.2007</div>


<p>Ошибка "Access Violation" возникает, когда идёт обращение к памяти к которой обращение запрещено. Это возможно во многих случаях, но наиболее типичные ситуации я попытаюсь перечислить:</p>
<p>1) Обращение к не созданному объекту.</p>
<pre>
var e:TEdit;
begin
  e.text:='Hello world!';
end;
</pre>
<p>В данном случае объект e ещё не создан и идёт обращение к памяти, которая ещё не выделена.</p>
<p>2) Обращение к уже разрушенному объекту:</p>
<pre>
var e:TEdit;
begin
  ...
  e.free;
  ...
  e.text:='Hello world';
end;
</pre>
<p>Тут есть хитрость, допустим вы хотите проверить есть ли объект и модернизируете код:</p>
<pre>
if e&lt;&gt;nil then e.text:='Hello world!';
</pre>
<p>или</p>
<pre>
if assigned(e) then  e.text:='Hello world!';
</pre>
<p>Особенно часто приходится такое делать когда надо уничтожить объект:</p>
<pre>
if e&lt;&gt;nil then e.free;
</pre>
<p>Так вот - такой код может быть источником ошибки, так как метод Free автоматически не устанавливает указатель в Nil. Обязательно после каждого Free используйте установление указателя в nil:</p>
<pre>
e.free;
e:=nil;
</pre>
<p>3) При выходе за границы динамического массива обычно генерится ошибка "Index out of bound", но возможно и возникновение Access Violation, особенно когда не стоят опции компилляции для проверки границ массивов. Эта ошибка может быть очень сложна в отлаживании - дело в том что допустим у вас есть массив а длиной в 10 элементов, в пишете:</p>
<pre>
a[20]:=something;
</pre>
<p>И эта строка может пройти как и надо, без всяких проблем, но её выполнение повредит какой-то другой код, причём каждый раз другой! Теперь самая безобидная операция типа i:=10 может вдруг внезапно дать Access Violation.</p>
<p>3) На форме на onCreate вызывается что-то с других форм - эти другие формы на этот момент еще не созданы</p>
<p>4) На форме на onDestroy вызывается что-то с других форм - эти другие формы на этот момент уже разрушены</p>
<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

