<h1>Отображаются ли полосы прокрутки для TStringGrid?</h1>
<div class="date">01.01.2007</div>


<pre>
if (GetWindowlong(Stringgrid1.Handle, GWL_STYLE) and WS_VSCROLL) &lt;&gt; 0 then
   ShowMessage('Vertical scrollbar is visible!');
 
 if (GetWindowlong(Stringgrid1.Handle, GWL_STYLE) and WS_HSCROLL) &lt;&gt; 0 then
   ShowMessage('Horizontal scrollbar is visible!');
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
&nbsp;</p>
