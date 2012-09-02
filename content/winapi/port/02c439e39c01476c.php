<h1>Как узнать адрес LPT-порта?</h1>
<div class="date">01.01.2007</div>


<p>Эта функция работает в Win95 и Win98.</p>
<pre>
function GetPortAddress(PortNo: integer): word; assembler; stdcall; 
asm 
  push es 
  push ebx 
  mov ebx, PortNo 
  shl ebx,1 
  mov ax,40h // Dos segment adress 
  mov es,ax 
  mov ax,ES:[ebx+6] // get port adress in 16Bit way :) 
  pop ebx 
  pop es 
end;
</pre>


<p>Для NT можно заглянуть сюда: <a href="https://www.wideman-one.com/gw/tech/Delphi/iopm/index.htm" target="_blank">https://www.wideman-one.com/gw/tech/Delphi/iopm/index.htm</a></p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

