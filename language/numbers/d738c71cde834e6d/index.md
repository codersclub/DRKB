---
Title: Арабские \> Римские
Date: 01.01.2007
---


Арабские \> Римские
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
     
    Function ArabicToRoman(N : Integer) : String; //Арабские в римские
    Var
       i : Integer;
    begin
     Result := '';
     i := 13;
     While N >0 do
     begin
       While A[i] >N do Dec(i);
       Result := Result + R[i];
       Dec(N, A[i]);
     end;
    end;
