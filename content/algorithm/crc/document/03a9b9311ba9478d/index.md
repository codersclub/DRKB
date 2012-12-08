---
Title: Алгоритм расчета контрольного числа ИНН
Date: 01.01.2007
---


Алгоритм расчета контрольного числа ИНН
=======================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Алгоритм расчета контрольного числа ИНН
     
    Зависимости: System, Sysutils
    Автор:       Камбалов А.Н., ACampball@mail.ru, Вологда
    Copyright:   Камбалов А.Н.
    Дата:        3 июня 2002 г.
    ********************************************** }
     
    // ===========================================
    // Алгоритм расчета контрольного числа ИНН
    // ===========================================
    function CheckINN(const INN: string): Boolean;
    const
      factor1: array[0..8] of byte = (2, 4, 10, 3, 5, 9, 4, 6, 8);
      factor2: array[0..9] of byte = (7, 2, 4, 10, 3, 5, 9, 4, 6, 8);
      factor3: array[0..10] of byte = (3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8);
    var
     i: byte;
     sum: word;
     sum2: word;
    begin
      Result := False;
     
      try
        if Length(INN) = 10 then begin
          sum := 0;
          for i:=0 to 8 do
            sum := sum + StrToInt(INN[i+1])*factor1[i];
          sum := sum mod 11;
          sum := sum mod 10;
          Result := StrToInt(INN[10]) = sum;
        end
        else if Length(INN) = 12 then begin
          sum := 0;
          for i:=0 to 9 do
            sum := sum + StrToInt(INN[i+1])*factor2[i];
          sum := sum mod 11;
          sum := sum mod 10;
          sum2 := 0;
          for i:=0 to 10 do
            sum2 := sum2 + StrToInt(INN[i+1])*factor3[i];
          sum2 := sum2 mod 11;
          sum2 := sum2 mod 10;
          Result := (StrToInt(INN[11]) = sum) and
                    (StrToInt(INN[12]) = sum2);
        end; //
      except
        Result := False;
      end; // try
    end;
