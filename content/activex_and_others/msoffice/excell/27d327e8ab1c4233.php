<h1>Как вставить конец страницы?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ ... }
Excel.ActiveWindow.View := xlPageBreakPreview;
WS.HPageBreaks.Add(WS.Cells.Item[78, 1]);
{ ... }
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
