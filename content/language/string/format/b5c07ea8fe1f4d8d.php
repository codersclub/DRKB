<h1>Перевод символа в нижний регистр для русского алфавита</h1>
<div class="date">01.01.2007</div>


<pre>
function LoCaseRus( ch : Char ) : Char;
{Перевод символа в нижний регистр для русского алфавита}
asm
  CMP          AL,'A'
  JB              @@exit
  CMP          AL,'Z'
  JA              @@Rus
  ADD          AL,'a' - 'A'
  RET
@@Rus:
  CMP          AL,'Я'
  JA              @@Exit
  CMP          AL,'А'
  JB              @@yo
  ADD          AL,'я' - 'Я'
  RET
@@yo:
  CMP          AL,'?'
  JNE            @@exit
  MOV          AL,'?'
@@exit:
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
