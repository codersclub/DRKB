---
Title: Вычисление наибольшего общего делителя двух целых неотрицательных чисел
Date: 27.10.2002
Author: Fenik, chook_nu@uraltc.ru
---


Вычисление наибольшего общего делителя двух целых неотрицательных чисел
=======================================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Вычисление наибольшего общего делителя двух целых неотрицательных чисел
     
    Зависимости: System
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Turbo Pascal / С.А. Немнюгин. - СПб: Издательство "Питер", 2000.
    Дата:        27 октября 2002 г.
    ********************************************** }
     
    function GCD(const m, n: LongWord): LongWord;
    {Вычисление наибольшего общего делителя
     двух неотрицательных целых чисел.
     Если какое-то из чисел = 0, то функция возвратит 0.
     Взято из учебника:
     Turbo Pascal / С.А. Немнюгин. - СПб: Издательство "Питер", 2000.}
    var p, n1, m1: LongWord;
    begin
      if (n = 0) or (m = 0) then Result := 0
      else begin
        if m < n then begin
          n1 := m;
          m1 := n;
        end
        else begin
          n1 := n;
          m1 := m;
        end;
        while n1 > 0 do begin
          p := m1 mod n1;
          m1 := n1;
          n1 := p;
        end;
        Result := m1;
      end;
    end; 

Пример использования:

    p := GCD(54, 36); {p := 18} 
