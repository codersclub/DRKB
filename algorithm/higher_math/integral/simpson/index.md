---
Title: Взятие интеграла методом Симпсона
Author: Mystic, mystic2000@newmail.ru
Date: 25.04.2002
---


Взятие интеграла методом Симпсона
=================================

    {**** UBPFD *********** by kladovka.net.ru ****
    >> Взятие интеграла методом Симпсона
     
    Интеграл методом Симпсона
    A, B - интервал интегрирования
    N - число точек на интервале
    Func - функция, от которой берется интеграл.
     
    Возвращаемое значение - значение интеграла
     
    Зависимости: System
    Автор:       Mystic, mystic2000@newmail.ru, ICQ:125905046, Харьков
    Copyright:   Mystic
    Дата:        25 апреля 2002 г.
    ********************************************** }
     
    type
      TFunction = function(X: Extended; Arg: Pointer): Extended;
     
    function Simpson(A, B: Extended; N: Cardinal; Func: TFunction; Arg: Pointer): Extended;
    var
      h: Extended;
      X: Extended;
      K: Extended;
      I: Integer;
    begin
      Assert(N>0);
      h := 0.5 * (B-A) / N;
      Result := Func(A, Arg);
      X := A + h;
      for I := 1 to 2*N-1 do
      begin
        if I mod 2 = 0
          then K := 2
          else K := 4;
        Result := Result + K*Func(X, Arg);
        X := X + h;
      end;
      Result := Result + Func(B, Arg);
      Result := h * Result / 3;
    end;

------------------------------------------------------------------------

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Вычисление определённого интеграла методом Симпсона
     
    A, B - границы интегрирования
    Eps - заданная относительная точность вычисления
    F - подинтегральная функция
     
    Зависимости: нет
    Автор:       Dimka Maslov, mainbox@endimus.ru
    Copyright:   Dimka Maslov
    Дата:        26 ноября 2003 г.
    ********************************************** }
     
    type
     TDoubleFunc = function (X: Double): Double;
     
    function Integral(A, B, Eps: Double; F: TDoubleFunc): Double;
     
     function InternalCalc(A, B: Double; F: TDoubleFunc; N: Integer): Double;
     var
      x, dx: Double;
      i: Integer;
     begin
      dx := (B - A) / N;
      Result := 0;
      x := A;
      for i := 1 to N do begin
       Result := Result + dx * (F(x) + 4*F(x+dx/2) + F(x+dx)) / 6;
       x := x + dx;
      end; 
     end;
     
    var
     N: Integer;
     Prev: Double;
    begin
     Result := InternalCalc(A, B, F, 4);
     N := 4;
     repeat
      Prev := Result;
      N := N shl 1;
      Result:= InternalCalc(A, B, F, N);
     until (Result = 0) or (Abs((Result-Prev) / Result) < Eps);
    end; 

Пример использования:

    function F(X: Double): Double;
    begin
     Result := X * X * X;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     Label1.Caption := FloatToStr(Integral(-10, 10, 0.00001, F));
    end; 
