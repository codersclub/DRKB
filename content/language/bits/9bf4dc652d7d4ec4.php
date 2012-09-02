<h1>Битовые множества</h1>
<div class="date">01.01.2007</div>

<p>В явном виде битовых множеств в языке Object Pascal нет. Но вместо этого можно использовать обычные множества, которые на самом деле и хранятся как битовые. Если множество вам нужно для проверки, установлен ли какой то бит в слове </p>
<pre>
type  
  PByteSet = ^TByteSet;  
  TByteSet = set of Byte;  
var  
  W: Word;  
...  
{ если бит 3 в слове W установлен, тогда ... }  
  if 3 in PByteSet(@W)^ then ...  
... 
</pre>
<p>С Delphi 2.0 появился специальный класс TBitSet, который ведет себя как битовое множество.Для Delphi 1.0 вы можете написать такой класс самостоятельно. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

