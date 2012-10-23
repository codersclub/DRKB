<h1>Проблема передачи записи</h1>
<div class="date">01.01.2007</div>

Может это не то, что вы ищете, но идея такая:</p>
<p>Определите базовый класс с именем, скажем, allrecs:</p>
<pre>
tAllrecs = class
function getVal (field: integer): string; virtual;
end;
</pre>
<p>Затем создаем классы для каждой записи:</p>
<pre>
recA = class (tAllrecs)
this      : Integer;
that      : String;
the_other : Integer;
function getVal (field: integer): string; virtual;
end;
</pre>
<p>Затем для каждой функции класса определите возвращаемый результат:</p>
<pre>
function recA.getVal (field: integer); string;
begin
case field of
1: getVal := intToStr (this);
2: getVal := that;
3: getVal := intToStr (the_other);
end;
end;
</pre>
<p>Затем вы можете определить</p>
<pre>
function myFunc (rec: tAllrecs; field: integer);
begin
label2.caption := allrecs.getVal(field);
end;
</pre>
<p>затем вы можете вызвать myFunc с любым классом, производным от tAllrecs, например:</p>
<pre>
myFunc (recA, 2);
myFunc (recB, 29);
</pre>
<p>(getVal предпочтительно должна быть процедурой (а не функцией) с тремя var-параметрами, возвращающими имя, тип и значение.)</p>
<p>Все это работает, т.к. данный пример я взял из моего рабочего проекта.</p>
<p>[Sid Gudes, cougar@roadrunner.com]</p>
<p>Если вы хотите за один раз передавать целую запись, установите на входе ваших функций/процедур тип 'array of const' (убедитесь в правильном приведенни типов). Это идентично 'array of TVarRec'. Для получения дополнительной информации о системных константах, определяемых для TVarRec, смотри электронную справку по Delphi.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
