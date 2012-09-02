<h1>Как узнать имя компьютера?</h1>
<div class="date">01.01.2007</div>


<p>Чтобы узнать имя, идентифицирующее компьютер в сети, на котором запущена Ваша программа, можно воспользоваться следующей функцией:</p>
<pre>uses Windows;
 
function GetComputerNetName: string;
var
 buffer: array[0..255] of char;
 size: dword;
begin
 size := 256;
 if GetComputerName(buffer, size) then
   Result := buffer
 else
   Result := ''
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
