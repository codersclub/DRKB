<h1>Как узнать, присутствует ли мышка?</h1>
<div class="date">01.01.2007</div>


<pre>function MousePresent : Boolean; </p>
<p>begin </p>
if GetSystemMetrics(SM_MOUSEPRESENT) &lt;&gt; 0 then </p>
  Result := true </p>
else </p>
  Result := false; </p>
end; 
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

