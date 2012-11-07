<h1>Как узнать существует ли страница (worksheet)?</h1>
<div class="date">01.01.2007</div>



<pre class="delphi">
{ ... }
WB := Excel.Workbooks[1];
for Idx := 1 to WB.Worksheets.Count do
  if WB.Worksheets[Idx].Name = 'first' then
    Showmessage('Found the worksheet');
{ ... }
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
