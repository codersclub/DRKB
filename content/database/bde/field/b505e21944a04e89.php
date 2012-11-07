<h1>Использование нумерации в TFields</h1>
<div class="date">01.01.2007</div>


<p>Я хочу хранить журнал транзакций в таблице Paradox и хотел бы писать и читать коды транзаций вместо простых целых чисел, которые они представляют в данный момент...</p>

<p>Можете попробовать сделать так:</p>

<pre class="delphi">
type Tcodes = (c1,c2,c3,c4);
 
var code: Tcodes;
 
code := Tcodes(Table1Field1.AsInteger);
if code in [c2,c4] then .....
  Table1Field1.AsInteger := Integer(code);
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
