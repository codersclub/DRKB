<h1>Как осуществить поиск ячейки по её значению?</h1>
<div class="date">01.01.2007</div>


<pre>
{ ... }
var
  Rnge: OleVariant;
  { ... }
 
Rnge := WS.Cells;
Rnge := Rnge.Find('Is this text on the sheet?');
if Pointer(IDispatch(Rnge)) &lt;&gt; nil then
  {The text was found somewhere, so colour it pink}
  Rnge.Interior.Color := clFuchsia;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
