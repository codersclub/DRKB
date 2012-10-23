<h1>Как в байте информации выделить биты?</h1>
<div class="date">01.01.2007</div>

<p>В Delphi используй операцию and, которая возвращает результат побитового умножения. Пример a and $10 &#8212; выделить 4-ый бит. Если результат не ноль &#8212; бит установлен.</p>
<p>То же самое, но на ассемблере. Это позволяет достичь максимальной скорости выполнения.</p>
<pre>
function GetBites(t, Mask: LongWord): LongWord;  
asm
  mov eax, t;
  and eax, mask;
end;
</pre>
<p>Эта функция возвращает t and Mask. Если необходимо выполнить сдвиг, то применяется команда shr:</p>
<pre>
function ShiftBites(t, Mask: LongWord; shift: byte): LongWord; 
asm
  mov eax, t;
  mov cl, shift;
  shr eax;
  and eax, Mask;
end;
</pre>
<p>Эта функция возвращает (t shr shift) and Mask. Если же ассемблер не поможет, надо или переделывать алгоритм, или менять компьютер :))</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
