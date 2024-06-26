---
Title: Как преобразовать цвета RGB в CMYK и обратно?
Author: p0s0l
Date: 01.01.2007
---


Как преобразовать цвета RGB в CMYK и обратно?
=============================================

The following functions RGBTOCMYK() and CMYKTORGB()
demonstrate how to convert between RGB and CMYK color
spaces.

**Note:** There is a direct relationship between RGB
colors and CMY colors. In a CMY color, black tones are
achieved by printing equal amounts of Cyan, Magenta, and
Yellow ink. The black component in a CMY color is achieved
by reducing the CMY components by the minimum of (C, M,
and Y) and substituting pure black in its place producing a
sharper print and using less ink. Since it is possible for a user
to boost the C,M and Y components where boosting the black
component would have been preferable, a ColorCorrectCMYK()
function is provided to achieve the same color by reducing the
C, M and Y components, and boosting the K component.

Example:

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
     if C < M then
       K := C else
       K := M;
     if Y < K then
       K := Y;
     if k > 0 then begin
       c := c - k;
       m := m - k;
       y := y - k;
     end;
    end;
     
    procedure CMYKTORGB(C : byte;
                       M: byte;
                       Y : byte;
                       K : byte;
                       var R : byte;
                       var G : byte;
                       var B : byte);
    begin
      if (Integer(C) + Integer(K)) < 255 then
        R := 255 - (C + K) else
        R := 0;
      if (Integer(M) + Integer(K)) < 255 then
        G := 255 - (M + K) else
        G := 0;
      if (Integer(Y) + Integer(K)) < 255 then
        B := 255 - (Y + K) else
        B := 0;
    end;
     
    procedure ColorCorrectCMYK(var C : byte;
                              var M : byte;
                              var Y : byte;
                              var K : byte);
    var
     MinColor : byte;
    begin
     if C < M then
       MinColor := C else
       MinColor := M;
     if Y < MinColor  then
       MinColor := Y;
     if MinColor + K > 255 then
       MinColor := 255 - K;
     C := C - MinColor;
     M := M - MinColor;
     Y := Y - MinColor;
     K := K + MinColor;
    end;
