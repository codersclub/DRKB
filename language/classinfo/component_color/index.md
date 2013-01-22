---
Title: Как изменить цвет всех компонентов на форме в runtime?
Date: 01.01.2007
---


Как изменить цвет всех компонентов на форме в runtime?
======================================================

::: {.date}
01.01.2007
:::

I would like to change the font color on all components on a form at
runtime (and the components owned by the components etc). I devised a
recursive algorithm using RTTI that accepts a TComponent as a parameter.
It works to some extent, but I still have to use \'if\' statements to
cast the object to a particular descendant, resulting in about 30 lines
of code to test for all of the components I use. Also, some objects
(TColumnTitle), are not descended from TComponent, even though they have
a font property.

This may do the trick (with D6 and maybe D5):

    uses
      TypInfo;
     
    { ... }
    var
      i: integer;
      aFont: TFont;
    begin
      for i := 0 to aComponent.ComponentCount - 1 do
      begin
        aFont := TFont(GetOrdProp(aComponent.Components[i], 'Font'));
        if assigned(aFont) then
          aFont.Color := clWhite;
      end;
    end;

With D4:

    { ... }
    var
      i: integer;
      aFont: TFont;
      pi: PPropInfo;
    begin
      for i := 0 to aComponent.ComponentCount - 1 do
      begin
        pi := GetPropInfo(aComponent.Components[i].ClassInfo, 'Font');
        if assigned(pi) then
          TFont(GetOrdProp(aComponent.Components[i],pi)).Color := clWhite;
      end;
    end;

Tip by Charles McNicoll

Взято из <https://www.lmc-mediaagentur.de/dpool>
