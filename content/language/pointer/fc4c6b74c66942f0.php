<h1>Быстрое сравнение памяти</h1>
<div class="date">01.01.2007</div>

Автор: Dennis Passmore</p>
<p>Я ищу функцию, которая была бы эквивалентом сишной функции memcmp.</p>
<p>Я создал следующие две функции, существенно повышающие произвотельность в приложениях, активно работающих с данными. Вам нужно всего-лишь обеспечить контроль типов и границ допустимого диапазона, все остальное они сделают с любым типом данных лучше нас :-) .</p>
<pre>
function Keys_are_Equal(var OldRec, NewRec;
KeyLn : word): boolean; assembler;
asm
  PUSH    DS
  MOV     AL,01
  CLD
  LES     DI,NewRec
  LDS     SI,OldRec
  MOV     CX,KeyLn
  CLI
  REPE    CMPSB
  STI
  JZ      @1
  XOR     AL,AL
  @1:
  POP     DS
end;
</pre>
<pre>
function First_Key_is_Less(var NewRec, OldRec;
Keyln : word): boolean; assembler;
asm
  PUSH    DS
  MOV     AL,01
  CLD
  LES     DI,NewRec
  LDS     SI,OldRec
  MOV     CX,KeyLn
  CLI
  REPE    CMPSB
  STI
  JZ      @5
  JGE     @6
  @5: XOR     AL,AL
  @6: POP     DS
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

