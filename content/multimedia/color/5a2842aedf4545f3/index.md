---
Title: RGB \> CMYK
Date: 01.01.2007
---


RGB \> CMYK
===========

::: {.date}
01.01.2007
:::

    procedure RGBTOCMYK(R : byte;
                        G : byte;
                        B : byte;
                        var C : byte;
                        var M : byte;
                        var Y : byte;
                        var K : byte);
    begin
      C := 255 - R;
      M := 255 - G;
      Y := 255 - B;
      if C  0 then 
        begin
          c := c - k;
          m := m - k;
          y := y - k;
        end;
    end;