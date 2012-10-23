<h1>Integer как SmallInt</h1>
<div class="date">01.01.2007</div>


<p>Я перешел на Delphi 2.0 и у меня появилась проблема с типизированными файлами. У меня есть множество типизированных файлов с различными записями. Теперь, когда целое занимает 4 байта, определения всех моих записей должны быть изменены с расчетом на то, что вместо целого типа придется использовать тип SmallInts. Тем не менее, даже после такого изменения размер моих записей остается прежним...</p>
<p>Вам необходимо использовать модификатор "packed":</p>
<pre>
type
  TMyRecType = packed record
    ...
  end;
</pre>

<div class="author">Автор: Steve Schafer</div>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
