---
Title: CMYK \> RGB
Date: 01.01.2007
---


CMYK \> RGB
===========

::: {.date}
01.01.2007
:::

    procedure CMYKTORGB(C : byte;
                        M: byte;
                        Y : byte;
                        K : byte;
                        var R : byte;
                        var G : byte;
                        var B : byte);
    begin
      if (Integer(C) + Integer(K))  255 then MinColor := 255 - K;
      C := C - MinColor;
      M := M - MinColor;
      Y := Y - MinColor;
      K := K + MinColor;
    end;
