<h1>Перевод символа в верхний регистр для русского алфавита</h1>
<div class="date">01.01.2007</div>


<pre>
function UpCaseRus(ch: Char): Char;
asm
  CMP   AL,'a'
  JB    @@exit
  CMP   AL,'z'
  JA    @@Rus
  SUB   AL,'a' - 'A'
  RET
@@Rus:
  CMP   AL,'я'
  JA    @@Exit
  CMP   AL,'а'
  JB    @@yo
  SUB   AL,'я' - 'Я'
  RET
@@yo:
  CMP   AL,'?'
  JNE   @@exit
  MOV   AL,'?'
@@exit:
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>


