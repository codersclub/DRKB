---
Title: Римские -> Арабские
Date: 01.01.2007
---


Римские -> Арабские
===================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Конвертация : Римские -> арабские ; Арабские->Римские
     
    Зависимости: 
    Автор:       Gua, fbsdd@ukr.net, ICQ:141585495, Simferopol
    Copyright:   
    Дата:        03 мая 2002 г.
    ********************************************** }
     
    Const
    R: Array[1..13] of String[2] =
     ('I','IV','V','IX','X','XL','L','XC','C','CD','D','CM','M');
    A: Array[1..13] of Integer=
     (1,4,5,9,10,40,50,90,100,400,500,900,1000);
     
    ..............
     
    Function RomanToArabic(S : String) : Integer; //Римские в арабские
    var
      i, p : Integer;
    begin
      Result := 0;
      i := 13;
      p := 1;
      While p <=Length(S) do
      begin
        While Copy(S, p, Length(R[i])) <>R[i] do
        begin
          Dec(i);
          If i = 0 then Exit;
        end;
        Result := Result + A[i];
        p := p + Length(R[i]);
      end;
    end;
