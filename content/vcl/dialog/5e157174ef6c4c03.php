<h1>Как открыть диалог Add Printer?</h1>
<div class="date">01.01.2007</div>


<p>добавьте ShellAPI в USES</p>
<pre>
ShellExecute(handle, nil, 
'rundll32.exe', 
'shell32.dll,SHHelpShortcuts_RunDLL AddPrinter', '', SW_SHOWNORMAL); 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

