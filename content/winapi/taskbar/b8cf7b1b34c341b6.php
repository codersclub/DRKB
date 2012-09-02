<h1>Как определить, включено ли автоскрытие у панели задач?</h1>
<div class="date">01.01.2007</div>


<pre>
uses ShellAPI; 
 
... 
 
function IsTaskbarAutoHideOn : boolean; 
var ABData : TAppBarData; 
begin 
ABData.cbSize := sizeof(ABData); 
Result :=(SHAppBarMessage(ABM_GETSTATE, ABData) and ABS_AUTOHIDE) &gt; 0; 
end; 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
