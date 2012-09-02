<h1>Аналог функции С memcmp</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Dennis Passmore&nbsp; </p>

<p>Я создал следующие две функции, существенно повышающие произвотельность в приложениях, активно работающих с данными. Вам нужно всего-лишь обеспечить контроль типов и границ допустимого диапазона, все остальное они сделают с любым типом данных лучше нас :-) . </p>
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
 
function First_Key_is_Less(var NewRec, OldRec; Keyln : word): boolean; assembler;
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

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<p class="note">Примечание от Jin X</p>
<p>Примеры приведены для 16-битного Pascal'я и не могут использоваться в 32-битном Delphi! Зато можно делать так:</p>
<p>{ Возвращает -1 при X&lt;Y, 0 при X=Y, 1 при X&gt;Y. }</p>
<p>{ Сравнение идёт по DWord'ам, будто сравнивается массив чисел Integer или Cardinal, }</p>
<p>{ т.е. 01 02 03 04 05 06 07 08 &gt; 01 02 03 04 05 06 08 07, }</p>
<p>{ т.к. 04030201 = 04030201, но 08070605 &gt; 07080605 (hex). }</p>
<p>{ Однако, если Size and 3 &lt;&gt; 0, то последние Size mod 4 байт сравниваются побайтно! }</p>

<pre>
function memcmp(const X, Y; Size: DWord): Integer;
asm
  mov esi,X
  mov edi,Y
  mov ecx,Size
  mov dl,cl
  and dl,3
  shr ecx,2
  xor eax,eax
  rep cmpsd
  jb @@less
  ja @@great
  mov cl,dl
  rep cmpsb
  jz @@end
  ja @@great
 @@less:
  dec eax
  jmp @@end
 @@great:
  inc eax
 @@end:
end;
</pre>

