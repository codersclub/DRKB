<h1>Как найти директорию Temp в Windows?</h1>
<div class="date">01.01.2007</div>


<pre>
function c_GetTempPath: String; 
var 
  Buffer: array[0..1023] of Char; 
begin 
  SetString(Result, Buffer, GetTempPath(Sizeof(Buffer)-1,Buffer)); 
end; 
</pre>
<p>этот код так же можно использовать для:</p>
<p>GetCurrentDirectory</p>
<p>GetSystemDirectory</p>
<p>GetWindowsDirectory</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
