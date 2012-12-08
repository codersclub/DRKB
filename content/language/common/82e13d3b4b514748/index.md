---
Title: Использование PosEx взамен Pos
Author: RoboSol
Date: 01.01.2007
---


Использование PosEx взамен Pos
==============================

::: {.date}
01.01.2007
:::

В Delphi 7 в модуле StrUtils внесены некоторые изменения.

Есть новая функция: PosEx.

Обьявление этих функций:

    function Pos(Substr: String; S: String): Integer;
    function PosEx(Const SubStr, S: String; Offset: Cardinal = 1): Integer;

Новая функция PosEx, позволяет указать начальную позицию поиска внутри
строки, что избавит вас от необходимости изменения исходной строки.
Незабудьте указать модуль StrUtils.

Ниже приведена реализация функции в модуле StrUtils (если вы используете
более старшую версию среди разработки вы сможете сами добавить этот код
и использовать его вместо функции Pos):

    function PosEx(Const SubStr, S: String; Offset: Cardinal = 1): Integer;
    var
      I,X: Integer;
      Len, LenSubStr: Integer;
    begin
      if Offset = 1 then
        Result := Pos(SubStr, S)
      else
      begin
        I := Offset;
        LenSubStr := Length(SubStr);
        Len := Length(S) - LenSubStr + 1;
        while I <= Len do
        begin
          if S[I] = SubStr[1] then
          begin
            X := 1;
            while (X < LenSubStr) and (S[I + X] = SubStr[X + 1]) do
              Inc(X);
            if (X = LenSubStr) then
            begin
              Result := I;
              Exit;
            end;
          end;
          Inc(I);
        end;
        Result := 0;
      end;
    end;

Автор: RoboSol

Взято из <https://forum.sources.ru>
