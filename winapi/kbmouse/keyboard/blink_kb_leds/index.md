---
Title: Заставить мерцать индикаторы клавиш CapsLock, NumLock и ScrollLock
Date: 01.01.2007
---


Заставить мерцать индикаторы клавиш CapsLock, NumLock и ScrollLock
==================================================================

::: {.date}
01.01.2007
:::

Представьте себе такую ситуацию: глупый пользователь включает тачку, а
тут... светомузыка, индикаторы состояния клавиш то включатся, то
погаснут... а если ещё каждую секунду проходит 500 тактов!!! Шутка,
конечно злостная, но воспроизводится весьма легко.

Всё основывается на следующем коде:

    var
      KS: TKeyboardState;
    begin
      GetKeyboardState(KS);
      KS[020] := KS[020] xor 1;
      KS[144] := KS[144] xor 1;
      KS[145] := KS[145] xor 1;
      SetKeyboardstate(KS);

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
