<h1>Очистить переменную в оперативной памяти</h1>
<div class="date">01.01.2007</div>

If you want to erase a variable, that no other program can read it out of the memory anymore, just use this function:</p>
<pre>
ZeroMemory(Addr(yourVar), SizeOf(yourVar));
ZeroMemory(Addr(yourStr), Length(yourStr));
// ZeroMemory(Address of the variable, Size of the variable); 
</pre>

<p>Very usefull, if you asked for a password and you want, that nobody other can get it.</p>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
