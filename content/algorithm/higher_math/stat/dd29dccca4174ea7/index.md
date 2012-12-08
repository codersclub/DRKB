---
Title: Нормальное распределение
Author: Vit
Date: 01.01.2007
---


Нормальное распределение
========================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Нормальное распределение
     
    Возвращает случайное число, распределенное по нормальному закону распределения
    с заданным математическим ожиданием и дисперсией
     
    Зависимости: System
    Автор:       Mystic, mystic2000@newmail.ru, ICQ:125905046, Харьков
    Copyright:   Из книги Полякова и Круглова "Turbo Pascal 5.5"
    Дата:        25 апреля 2002 г.
    ********************************************** }
     
    function Gauss(Mx, Sigma: Extended): Extended;
    var
      a, b, r, Sq: Extended;
    begin
      repeat
        a := 2*Random - 1;
        b := 2*Random - 1;
        r := Sqr(a) + Srq(b);
      until r<1;
      Sq := Sqrt(-2*Ln(r)/r);
      Result := Mx + Sigma * a * Sq;
    end; 

Пример использования:

    X := Gauss(0, 1); 

------------------------------------------------------------------------

В стандартном модуле  Math есть функция

function RandG(Mean, StdDev: Extended): Extended;

Автор: Vit

 

 
