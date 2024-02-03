---
Title: Название месяца -> номер месяца
Date: 01.01.2007
---


Название месяца -> номер месяца
===============================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Функция преобразует текстовую строку, задающую название месяца, в номер месяца
     
    функция преобразует текстовую строку,задающую название месяца, в номер месяца
     
    Зависимости: ???
    Автор:       Сергей, nfkazak@inbox.ru, Краснодар
    Copyright:   VIP BANK
    Дата:        11 сентября 2002 г.
    ***************************************************** }
     
    function NumMonth(SMonth: string): word;
    var
      i: byte;
    begin
      Result := 0;
      for i := 1 to 12 do
        if AnsiUpperCase(SMonth) = Month[i] then
          Result := i
    end;

 

------------------------------------------------------------------------

...через цикл обхода элементов глобального массива LongMonthNames:

    Function GetMonthNumber(Month: String): Integer;
    Begin
      For Result := 1 to 12 do
        If Month = LongMonthNames[Result] Then
          Exit;
      Result := 0;
    End;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
