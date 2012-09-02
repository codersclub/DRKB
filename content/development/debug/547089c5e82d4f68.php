<h1>Как сэкономить память в ваших программах?</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Diego Jones</p>
<p>Совместимость: Delphi 4.x (или выше)</p>
<p>Обычно, когда класс располагается в памяти, то между полями остаются небольшие пространства, несодержащие никакой информации. Оказывается можно избавиться от таких участков памяти и соответственно Ваше приложение будет меньше расходовать оперативной памяти.</p>
<p>Но сначала обратимся к основам типов данных, используемых в Delphi, и детально рассмотрим - сколько байт памяти занимает каждый тип данных: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>boolean, char and byte = 1 байт </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>smallInt, word, wordbool = 2 байт </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>string, pointers, longint, integer = 4 байт </td></tr></table></div>Теперь давайте посмотрим на объявление класса в нашем исходном коде:</p>

<pre>
TMyClass = class
private
  field1: char;
  field2: longint;
  field3: boolean;
  field4: string;
  field5: byte;
  field6: integer;
public
  procedure proc1;
end;
</pre>


<p>теперь просуммируем байты, которы занимает каждый тип данных. По идее должно получиться 15 байт, но на самом деле это не так. Реальный размер, занимаемый данным экземпляром класса будет составлять 24 байта, т. е. 4 байта на каждое поле. Почему ? Потому что поумолчанию в Delphi, по правилам оптимизации, каждое поле располагается от предыдущего со сдвигом на 4 байта: field1 занимает 1 байт, поидее поле field2 должно следовать сразу же за field1, но по правилам оптимизации, остаются 3 байта не содержащие никакой информации, а следовательно напрасно потерянные. А если бы field2 был бы длиной в 1 байт или 2 байта, то он был бы помещён сразу же за полем field1, потому что это не нарушает правил оптимизации.</p>
<p>Какой же напрашивается вывод ? А если изменить порядок объявления переменных в классе ? Я просто сгруппировал переменные по их размеру (байтовому): вместе все однобайтовые, соответственно вместе все двухбайтовые и т.д.</p>
<p>Вот так стал выглядеть наш класс:</p>
<pre>
TMyClass = class
private
  field1: char;
  field3: boolean;
  field5: byte;
  field2: longint;
  field4: string;
  field6: integer;
public
  procedure proc1;
end;
</pre>


<p>С такой организацией классы, его длина стала 16 байт (сэкономили 8 байт на каждом экземпляре данного класса). Конечно же это не большая экономия памяти, но в тех случая, когда класс инициализируется многократно либо класс довольно велик, то такая экономия довольно ощутима.</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

