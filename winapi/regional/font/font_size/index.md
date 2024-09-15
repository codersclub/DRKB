---
Title: Какой шрифт установлен (крупный или мелкий)?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Какой шрифт установлен (крупный или мелкий)?
============================================

    function SmallFonts: Boolean;
    {Значение функции TRUE если мелкий шрифт}
    var
      DC: HDC;
    begin
      DC := GetDC(0);
      Result := (GetDeviceCaps(DC, LOGPIXELSX) = 96);
      { В случае крупного шрифта будет 120}
      ReleaseDC(0, DC);
    end;

