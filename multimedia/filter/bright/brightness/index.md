---
Title: Как изменить яркость и контраст?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как изменить яркость и контраст?
================================

Вариант 1:

You must change the RBG values of the pixels. For 1, 4 and 8 bit
bitmaps, you must edit the palette. For 15 - 32 bit bitmaps, you must
edit the pixel direct. For larger bitmaps you should precalulate a table
and set the RGB values from this table.

    Red := BCTable[Red];
    Green := BCTable[Green];
    Blue := BCTable[Blue];

You can find the calculation of the table below. The rest is standard
source code, look at EFG\'s Computer Lab for any solution.

I define the brightness and contrast value between 0..255. Other
definitions are possible, change BMax, CMax, BNorm and CNorm.

    type
      TBCTable = array[Byte] of Byte;
     
    const
      RGBCount = 256;
      RGBMax = 255;
      RGBHalf = 128;
      RGBMin = 0;
      BMax = 128; { Maximal value brightness 100% - 0% = 0% - - 100% }
      CMax = 128; { Maximal value contrast 100% - 0% = 0% - - 100% }
      BNorm = 128; { Normal value brightness 0% }
      CNorm = 128; { Normal value contrast 0% }
     
    procedure CalcBCTable(var ABCTable: TBCTable; ABrightness, AContrast: Integer);
    var
      i, v: Integer;
      BOffset: Integer;
      M, D: Integer;
    begin
      Dec(ABrightness, BNorm);
      Dec(AContrast, CNorm);
      { precalculation brightness assistance values }
      BOffset := ((ABrightness) * RGBMax div BMax);
      { precalculation contrast assistance values }
      if AContrast < CMax then
      begin { because Division by 0 on 100% }
        if AContrast <= 0 then
        begin { decrement contrast }
          M := CMax + AContrast;
          D := CMax;
        end
        else
        begin { increment contrast }
          M := CMax;
          D := CMax - AContrast;
        end;
      end
      else
      begin
        M := 0;
        D := 1;
      end;
      for i := RGBMin to RGBMax do
      begin
        { calculate contrast }
        if AContrast < CMax then
        begin
          v := ((i - RGBHalf) * M) div D + RGBHalf;
          { restrict to byte range }
          if v < RGBMin then
            v := RGBMin
          else if v > RGBMax then
            v := RGBMax;
        end
        else
        begin { contrast = 100% }
          if i < RGBHalf then
            v := RGBMin
          else
            v := RGBMax;
        end;
        { calculate brightness }
        Inc(v, BOffset);
        { restrict to byte range }
        if v < RGBMin then
          v := RGBMin
        else if v > RGBMax then
          v := RGBMax;
        ABCTable[i] := v;
      end;
    end;

------------------------------------------------------------------------

Вариант 2:

Add a fixed value and clip it to the range. I have used a LUT, which is
faster for larger bitmaps. The range of Brightness is -255 (-100%) to
255 (+100%). You can use a 32 or 24 Bit calculation depending on the
compiler setting ChangeBrightness24Bit.

    procedure ChangeBrightness(Bitmap: TBitmap; Brightness: Integer);
    var
      LUT: array[Byte] of Byte;
      v, i: Integer;
    {$IFDEF ChangeBrightness24Bit}
      w, h, x, y: Integer;
      LineSize: LongInt;
      pLineStart: PByte;
    {$ENDIF}
      p: PByte;
    begin
      { create LUT }
      for i := 0 to 255 do
      begin
        v := i + Brightness;
        if v < 0 then
          v := 0
        else if v > 255 then
          v := 255;
        LUT[i] := v;
      end;
     
    {$IFDEF ChangeBrightness24Bit}
      { edit bitmap }
      w := Bitmap.Width;
      h := Bitmap.Height - 1;
      Bitmap.PixelFormat := pf24Bit;
      pLineStart := PByte(Bitmap.ScanLine[h]);
      { pixel line is aligned to 32 Bit }
      LineSize := ((w * 3 + 3) div 4) * 4;
      w := w * 3 - 1;
      for y := 0 to h do
      begin
        p := pLineStart;
        for x := 0 to w do
        begin
          p^ := LUT[p^];
          Inc(p);
        end;
        Inc(pLineStart, LineSize);
      end;
    {$ELSE}
      { edit bitmap }
      Bitmap.PixelFormat := pf32Bit;
      p := PByte(Bitmap.ScanLine[Bitmap.Height - 1]);
      for i := 0 to Bitmap.Width * Bitmap.Height - 1 do
      begin
        p^ := LUT[p^];
        Inc(p);
        p^ := LUT[p^];
        Inc(p);
        p^ := LUT[p^];
        Inc(p, 2);
      end;
    {$ENDIF}
    end;

