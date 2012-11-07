<h1>Как скопировать страницу?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ ... }
var
  After: OleVariant;
  Sh: _Worksheet;
begin
  Sh := Excel.Worksheets['Sheet1'] as _Worksheet;
  After := Excel.Workbooks[1].Sheets[3];
  Sh.Copy(EmptyParam, After, lcid);
  { ... }
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
