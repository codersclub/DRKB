---
Title: Нeсколько полезных функций для работы с цветами
Author: Gero, tov.vaskin@inbox.ru
Date: 11.02.2004
---


Нeсколько полезных функций для работы с цветами
===============================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Работа с цветами
     
    Нeсколько полезных функций для работы с цветами.
     
    // Получить цвет, темнее исходного на Percent процентов
    function DarkerColor(const Color : TColor; Percent : Integer) : TColor;
    // Получить цвет, светлее исходного на Percent процентов
    function LighterColor(const Color : TColor; Percent : Integer) : TColor;
    // Смешать несколько цветов и получить средний
    function MixColors(const Colors : array of TColor) : TColor;
    // Сделать цвет черно-белым
    function GrayColor(Color : TColor) : TColor;
     
    Зависимости: Windows, Graphics
    Автор:       Gero, tov.vaskin@inbox.ru, Днепропетровск(Украина)
    Copyright:   Gero
    Дата:        11 февраля 2004 г.
    ********************************************** }
     
    function DarkerColor(const Color : TColor; Percent : Integer) : TColor;
    var
       R, G, B : Byte;
    begin
      Result := Color;
      if Percent <= 0 then Exit;
      if Percent > 100 then Percent := 100;
      Result := ColorToRGB(Color);
      R := GetRValue(Result);
      G := GetGValue(Result);
      B := GetBValue(Result);
      R := R - R * Percent div 100;
      G := G - G * Percent div 100;
      B := B - B * Percent div 100;
      Result := RGB(R, G, B);
    end;
     
    function LighterColor(const Color : TColor; Percent : Integer) : TColor;
    var
      R, G, B : Byte;
    begin
      Result := Color;
      if Percent <= 0 then Exit;
      if Percent > 100 then Percent := 100;
      Result := ColorToRGB(Result);
      R := GetRValue(Result);
      G := GetGValue(Result);
      B := GetBValue(Result);
      R := R + (255 - R) * Percent div 100;
      G := G + (255 - G) * Percent div 100;
      B := B + (255 - B) * Percent div 100;
      Result := RGB(R, G, B);
    end;
     
    function MixColors(const Colors : array of TColor) : TColor;
    var
      R, G, B : Integer;
      i : Integer;
      L : Integer;
    begin
      R := 0;
      G := 0;
      B := 0;
      for i := Low(Colors) to High(Colors) do
        begin
          Result := ColorToRGB(Colors[i]);
          R := R + GetRValue(Result);
          G := G + GetGValue(Result);
          B := B + GetBValue(Result);
        end;
      L := Length(Colors);
      Result := RGB(R div L, G div L, B div L);
    end;
     
    function GrayColor(Color : TColor) : TColor;
    var
      Gray : Byte;
    begin
      Result := ColorToRGB(Color);
      Gray := (GetRValue(Result) + GetGValue(Result) + GetBValue(Result)) div 3;
      Result := RGB(Gray, Gray, Gray);
    end;
