---
Title: Вычисление автокорреляционной функции
Date: 02.06.2002
Author: lookin, lookin@mail.ru
---


Вычисление автокорреляционной функции
=====================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Вычисление автокорреляционной функции
     
    Зависимости: Math
    Автор:       lookin, lookin@mail.ru, Екатеринбург
    Copyright:   lookin
    Дата:        2 июня 2002 г.
    ***************************************************** }
     
    //TDoubleArray = array of double
     
    procedure AutoCorrelation(ValueArray: TDoubleArray; var ACArray: TDoubleArray;
      FromValue, ToValue: integer);
    var
      i, j, N: integer;
      avr, dev, xxsum: double;
    begin
      //ValueArray - массив типа double для которого вычисляется функция
      //FromValue - номер точки, начиная с которого выбираются элементы массива
      //ToValue - номер точки, на котором заканчивается выбор элементов массива
      //ACArray - массив возвращаемых значений автокорреляционной функции
      //для 5-и точек
      N := ToValue - FromValue;
      SetLength(ACArray, 5);
      if N < 5 then
      begin
        for i := 0 to 4 do
          ACArray[i] := 0;
        Exit;
      end
      else
      begin
        SetLength(rv, N);
        dev := 0;
        for i := 0 to N - 1 do
          rv[i] := ValueArray[i + FromValue];
        avr := Mean(rv);
        for i := 0 to N - 1 do
          dev := dev + Sqr(rv[i] - avr);
        dev := dev / N;
        for j := 0 to 4 do
        begin
          xxsum := 0;
          for i := 0 to (N - 1) - j do
            xxsum := xxsum + (rv[i] - avr) * (rv[i + j] - avr);
          ACArray[j] := xxsum / (dev * (N - j));
        end;
      end;
    end;
     
    // Пример использования: 
     
    var
      SourceArray, ACCoefs: TDoubleArray;
    begin
      AutoCorrelation(SourceArray, ARCoefs, 0, Length(SourceArray) - 1);
      for i := 0 to Length(ACCoefs) - 1 do
        showmessage(FloatToStr(ACCoefs[i]));
