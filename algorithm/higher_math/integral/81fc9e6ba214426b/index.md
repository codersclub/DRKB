---
Title: Вычисление интеграла
Date: 01.01.2007
---


Вычисление интеграла
====================

::: {.date}
01.01.2007
:::

Вычисление интеграла с заданной точностью алгоритмом Симпсона.

    // (c) Copydown 2002, all left reserved. http://world.fpm.kubsu.ru.
     
    {$APPTYPE CONSOLE}
     
    {$F+} {разрешение передачи функций, как параметров}
     
    type FunctionType = function(x: real): real;
     
    {интегрируемая функция}
    function f(x: real): real; begin f := x end;
     
    {интегрирование от a до b функции f с точностью e}
    function IntegralSimpson(a, b: real; f: FunctionType; e: real): real;
      var
        h, x, s, s1, s2, s3, sign: real;
     begin
     
      if (a = b) then
        begin
          IntegralSimpson := 0; exit
        end;
     
      if (a > b) then
        begin
          x := a; a := b; b := x; sign := -1
        end
       else sign:=1;
     
      h := b - a; s := f(a) + f(b); s2 := s;
     
      repeat
        s3 := s2; h := h/2; s1 := 0; x := a + h;
     
        repeat
          s1 := s1 + 2*f(x); x := x + 2*h;
        until (not(x < b));
     
        s := s + s1; s2 := (s + s1)*h/3; x := abs(s3 - s2)/15
      until (not(x > e));
     
      IntegralSimpson := s2*sign;
     end;
     
    begin
      {вывод результата интегрирования от 0 до 1 функции f с точностью 0.001}
      writeln(IntegralSimpson(0, 1, f, 0.001));
      writeln; writeln('Press Enter'); readln;
    end.

Взято с <https://delphiworld.narod.ru>
