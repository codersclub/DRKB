---
Title: Сохранение типа данных множество (TFontStyles)
Date: 01.01.2007
---


Сохранение типа данных множество (TFontStyles)
==============================================

::: {.date}
01.01.2007
:::

    {You do that simple by converting it to an integer, and then stores that:}
     
     type
       pFontStyles = ^TFontStyles;
       pInteger = ^integer;
     
     function FontStylesToInteger(const Value : TFontStyles): integer;
     begin
       Result := pInteger(@Value)^;
     end;
     
     function IntegerToFontStyles(const Value : integer): TFontStyles;
     begin
       Result := pFontStyles(@Value)^;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
