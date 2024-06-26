---
Title: Как сделать grayscale dithering?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как сделать greyscale dithering?
================================

    procedure Greyscale(dib8, dib24: TFastDIB; Colors: Byte);
    type
      TDiv3 = array[0..767] of Byte;
      TScale = array[0..255] of Byte;
      TLineErrors = array[-1.. - 1] of DWord;
      PDiv3 = ^TDiv3;
      PScale = ^TScale;
      PLineErrors = ^TLineErrors;
    var
      x, y, i, Ln, Nxt: Integer;
      pc: PFColor;
      pb: PByte;
      Lines: array[0..1] of PLineErrors;
      Div3: PDiv3;
      Scale: PScale;
      pti: PDWord;
      dir: ShortInt;
    begin
      dib8.FillColors(0, Colors, tfBlack, tfWhite);
      New(Div3);
      pb := Pointer(Div3);
      for i := 0 to 255 do
      begin
        pb^ := i;
        Inc(pb);
        pb^ := i;
        Inc(pb);
        pb^ := i;
        Inc(pb);
      end;
      New(Scale);
      pb := Pointer(Scale);
      x := (Colors shl 16) shr 8;
      y := x;
      for i := 0 to 255 do
      begin
        pb^ := y shr 16;
        Inc(y, x);
        Inc(pb);
      end;
      GetMem(Lines[0], 24 * (dib24.Width + 2));
      GetMem(Lines[1], 24 * (dib24.Width + 2));
      pc := PFColor(dib24.Bits);
      for x := 0 to dib24.Width - 1 do
      begin
        Lines[0, x] := Div3[pc.r + pc.g + pc.b] * 16;
        Inc(pc);
      end;
      pc := Ptr(Integer(pc) + dib24.Gap);
      dir := 1;
      for y := 1 to dib24.Height do
      begin
        Nxt := y mod 2;
        Ln := 1 - Nxt;
        if y < dib24.Height then
        begin
          for x := 0 to dib24.Width - 1 do
          begin
            Lines[Nxt, x] := Div3[pc.r + pc.g + pc.b] * 16;
            Inc(pc);
          end;
          pc := Ptr(Integer(pc) + dib24.Gap);
        end;
        x := 0;
        if dir = -1 then
          x := dib24.Width - 1;
        pti := @Lines[Ln, x];
        pb := @dib8.Pixels8[y - 1, x];
        while ((x > -1) and (x < dib24.Width)) do
        begin
          pti^ := pti^ div 16;
          if pti^ > 255 then
            pti^ := 255
          else if pti^ < 0 then
            pti^ := 0;
          pb^ := Scale[pti^];
          i := pti^ - dib8.Colors[pb^].r;
          if i <> 0 then
          begin
            Inc(Lines[Ln, x + dir], i * 7);
            Inc(Lines[Nxt, x - dir], i * 3);
            Inc(Lines[Nxt, x], i * 5);
            Inc(Lines[Nxt, x + dir], i);
          end;
          Inc(pb, dir);
          Inc(pti, dir);
          Inc(x, dir);
        end;
        Inc(pb, dib8.Gap);
        dir := -dir;
      end;
      Dispose(Lines[0]);
      Dispose(Lines[1]);
      Dispose(Scale);
      Dispose(Div3);
    end;

