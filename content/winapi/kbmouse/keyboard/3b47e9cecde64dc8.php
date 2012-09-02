<h1>Заставить мерцать индикаторы клавиш CapsLock, NumLock и ScrollLock</h1>
<div class="date">01.01.2007</div>

Представьте себе такую ситуацию: глупый пользователь включает тачку, а тут... светомузыка, индикаторы состояния клавиш то включатся, то погаснут... а если ещё каждую секунду проходит 500 тактов!!! Шутка, конечно злостная, но воспроизводится весьма легко. </p>
<p>Всё основывается на следующем коде: </p>
<pre>
var
  KS: TKeyboardState;
begin
  GetKeyboardState(KS);
  KS[020] := KS[020] xor 1;
  KS[144] := KS[144] xor 1;
  KS[145] := KS[145] xor 1;
  SetKeyboardstate(KS);
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
