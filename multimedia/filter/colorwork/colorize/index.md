---
Title: Как сделать colorize?
Date: 01.01.2007
---


Как сделать colorize?
=====================

::: {.date}
01.01.2007
:::

    function Colorize(RGB, Luma: Cardinal);
    var
      l, r, g, b: Single;
    begin
      Result := Luma;
      if Luma = 0 then { it's all black anyway}
        Exit;
      l := Luma / 255;
      r := RGB and $FF * l;
      g := RGB shr 8 and $FF * l;
      b := RGB shr 16 and $FF * l;
      Result := Round(b) shl 16 or Round(g) shl 8 or Round(r);
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
