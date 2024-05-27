---
Title: Сохранение типа данных множества (TFontStyles)
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Сохранение типа данных множества (TFontStyles)
==============================================

    {Сохранение множества делается просто:
     преобразуем его в целое число, а затем сохраняем:}
     
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

