<h1>Создание/пересоздание индекса</h1>
<div class="date">01.01.2007</div>


<pre>
DbiRegenIndexes( Table1.Handle ); { Регенерация всех индексов } 
create index (зависит от существования выражения)
 
 
if (( Pos('(',cTagExp) + Pos('+',cTagExp) ) &gt; 0 ) then
  Table1.AddIndex( cTagName, cTagExp, [ixExpression])  // &lt;- ixExpression - _литерал_
else
  Table1.AddIndex( cTagName, cTagExp, []);
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
