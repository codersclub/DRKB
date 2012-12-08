---
Title: Как получить более светлый или более темный цвет?
Date: 01.01.2007
---


Как получить более светлый или более темный цвет?
=================================================

::: {.date}
01.01.2007
:::

    { 
      Here's some function that returns the lighter or darker color of a TColor. 
      You can use it, for example, to design a bevel or something like that. 
    } 
     
    {=======================================} 
     
    function Min(a, b: Longint): Longint; 
    begin 
      if a > b then Result := b  
      else  
        Result := a; 
    end; 
     
    function Max(a, b: Longint): Longint; 
    begin 
      if a > b then Result := a  
      else  
        Result := b; 
    end; 
     
    {=======================================} 
     
    function GetHighlightColor(BaseColor: TColor): TColor; 
    begin 
      Result := RGB(Min(GetRValue(ColorToRGB(BaseColor)) + 64, 255), 
        Min(GetGValue(ColorToRGB(BaseColor)) + 64, 255), 
        Min(GetBValue(ColorToRGB(BaseColor)) + 64, 255)); 
    end; 
     
     
    function GetShadowColor(BaseColor: TColor): TColor; 
    begin 
      Result := RGB(Max(GetRValue(ColorToRGB(BaseColor)) - 64, 0), 
        Max(GetGValue(ColorToRGB(BaseColor)) - 64, 0), 
        Max(GetBValue(ColorToRGB(BaseColor)) - 64, 0)); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
