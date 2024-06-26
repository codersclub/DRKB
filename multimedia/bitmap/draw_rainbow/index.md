---
Title: Как нарисовать радугу?
Date: 01.01.2007
---


Как нарисовать радугу?
======================

> How do I paint the color spectrum of a rainbow, and if the
> spectrum is clicked on, how do I calculate what color was
> clicked on?

The following example demonstrates painting a color spectrum,
and calculating the color of a given point on the spectrum.

Two procedures are presented: PaintRainbow() and
ColorAtRainbowPoint(). The PaintRainbow() procedure paints a
spectrum from red to magenta if the WrapToRed parameter is
false, or paint red to red if the WrapToRed parameter is true.

The rainbow can progress either in a horizontal or
vertical progression. The ColorAtRainbowPoint() function
returns a TColorRef containing the color at a given point in
the rainbow.

    procedure PaintRainbow(Dc : hDc; {Canvas to paint to}
                           x : integer; {Start position X}
                           y : integer;  {Start position Y}
                           Width : integer; {Width of the rainbow}
                           Height : integer {Height of the rainbow};
                           bVertical : bool; {Paint verticallty}
                           WrapToRed : bool); {Wrap spectrum back to red}
    var
      i : integer;
      ColorChunk : integer;
      OldBrush : hBrush;
      OldPen : hPen;
      r : integer;
      g : integer;
      b : integer;
      Chunks : integer;
      ChunksMinus1 : integer;
      pt : TPoint;
    begin
      OffsetViewportOrgEx(Dc,
                          x,
                          y,
                          pt);
     
      if WrapToRed = false then
        Chunks := 5 else
        Chunks := 6;
      ChunksMinus1 := Chunks - 1;
     
      if bVertical = false then
        ColorChunk := Width div Chunks else
        ColorChunk := Height div Chunks;
     
      {Red To Yellow}
      r := 255;
      b := 0;
      for i := 0 to ColorChunk do begin
        g:= (255 div ColorChunk) * i;
        OldBrush := SelectObject(Dc, CreateSolidBrush(Rgb(r, g, b)));
        if bVertical = false then
          PatBlt(Dc, i, 0, 1, Height, PatCopy) else
          PatBlt(Dc, 0, i, Width, 1, PatCopy);
        DeleteObject(SelectObject(Dc, OldBrush));
      end;
     
      {Yellow To Green}
      g:=255;
      b:=0;
      for i := ColorChunk  to (ColorChunk * 2) do begin
        r := 255 - (255 div ColorChunk) * (i - ColorChunk);
        OldBrush := SelectObject(Dc, CreateSolidBrush(Rgb(r, g, b)));
        if bVertical = false then
          PatBlt(Dc, i, 0, 1, Height, PatCopy) else
          PatBlt(Dc, 0, i, Width, 1, PatCopy);
        DeleteObject(SelectObject(Dc, OldBrush));
      end;
     
      {Green To Cyan}
      r:=0;
      g:=255;
      for i:= (ColorChunk * 2) to (ColorChunk * 3) do begin
        b := (255 div ColorChunk)*(i - ColorChunk * 2);
        OldBrush := SelectObject(Dc, CreateSolidBrush(Rgb(r, g, b)));
        if bVertical = false then
          PatBlt(Dc, i, 0, 1, Height, PatCopy) else
          PatBlt(Dc, 0, i, Width, 1, PatCopy);
        DeleteObject(SelectObject(Dc,OldBrush));
      end;
     
      {Cyan To Blue}
      r := 0;
      b := 255;
      for i:= (ColorChunk * 3) to (ColorChunk * 4) do begin
        g := 255 - ((255 div ColorChunk) * (i - ColorChunk * 3));
        OldBrush := SelectObject(Dc, CreateSolidBrush(Rgb(r, g, b)));
        if bVertical = false then
          PatBlt(Dc, i, 0, 1, Height, PatCopy) else
          PatBlt(Dc, 0, i, Width, 1, PatCopy);
        DeleteObject(SelectObject(Dc, OldBrush));
      end;
     
      {Blue To Magenta}
      g := 0;
      b := 255;
      for i:= (ColorChunk * 4) to (ColorChunk * 5) do begin
        r := (255 div ColorChunk) * (i - ColorChunk * 4);
        OldBrush := SelectObject(Dc, CreateSolidBrush(Rgb(r, g, b)));
        if bVertical = false then
          PatBlt(Dc, i, 0, 1, Height, PatCopy) else
          PatBlt(Dc, 0, i, Width, 1, PatCopy);
        DeleteObject(SelectObject(Dc, OldBrush))
      end;
     
      if WrapToRed <> false then begin
        {Magenta To Red}
        r := 255;
        g := 0;
        for i := (ColorChunk * 5) to ((ColorChunk * 6) - 1) do begin
          b := 255 -((255 div ColorChunk) * (i - ColorChunk * 5));
          OldBrush := SelectObject(Dc, CreateSolidBrush(Rgb(r,g,b)));
          if bVertical = false then
            PatBlt(Dc, i, 0, 1, Height, PatCopy) else
            PatBlt(Dc, 0, i, Width, 1, PatCopy);
          DeleteObject(SelectObject(Dc,OldBrush));
        end;
      end;
     
      {Fill Remainder}
      if (Width - (ColorChunk * Chunks) - 1 ) > 0 then begin
        if WrapToRed <> false then begin
          r := 255;
          g := 0;
          b := 0;
        end else begin
          r := 255;
          g := 0;
          b := 255;
        end;
        OldBrush := SelectObject(Dc, CreateSolidBrush(Rgb(r, g, b)));
        if bVertical = false then
          PatBlt(Dc,
                 ColorChunk * Chunks,
                 0,
                 Width - (ColorChunk * Chunks),
                 Height,
                 PatCopy) else
          PatBlt(Dc,
                 0,
                 ColorChunk * Chunks,
                 Width,
                 Height - (ColorChunk * Chunks),
                 PatCopy);
        DeleteObject(SelectObject(Dc,OldBrush));
      end;
      OffsetViewportOrgEx(Dc,
                          Pt.x,
                          Pt.y,
                          pt);
    end;
     
    function ColorAtRainbowPoint(ColorPlace : integer;
                                 RainbowWidth : integer;
                                 WrapToRed : bool) : TColorRef;
    var
      ColorChunk : integer;
      ColorChunkIndex : integer;
      ColorChunkStart : integer;
    begin
      if ColorPlace = 0 then begin
        result := RGB(255, 0, 0);
        exit;
     end;
     {WhatChunk}
      if WrapToRed <> false then
        ColorChunk := RainbowWidth div 6 else
        ColorChunk := RainbowWidth div 5;
        ColorChunkStart := ColorPlace div ColorChunk;
        ColorChunkIndex := ColorPlace mod ColorChunk;
      case ColorChunkStart of
       0 : result := RGB(255,
                         (255 div ColorChunk) * ColorChunkIndex,
                         0);
       1 : result := RGB(255 - (255 div ColorChunk) * ColorChunkIndex,
                         255,
                         0);
       2 : result := RGB(0, 255, (255 div ColorChunk) * ColorChunkIndex);
       3 : result := RGB(0,
                         255 - (255 div ColorChunk) * ColorChunkIndex,
                         255);
       4 : result := RGB((255 div ColorChunk) * ColorChunkIndex,
                         0,
                         255);
       5 : result := RGB(255,
                         0,
                         255 - (255 div ColorChunk) * ColorChunkIndex);
      else
        if WrapToRed <> false then
          result := RGB(255, 0, 0) else
          result := RGB(255, 0, 255);
      end;{Case}
    end;
     
     
    procedure TForm1.FormPaint(Sender: TObject);
    begin
      PaintRainbow(Form1.Canvas.Handle,
                   0,
                   0,
                   Form1.ClientWidth,
                   Form1.ClientHeight,
                   false,
                   true);
     
    end;
     
    procedure TForm1.FormResize(Sender: TObject);
    begin
      InvalidateRect(Form1.Handle, nil, false);
    end;
     
    procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    var
      Color : TColorRef;
    begin
      Color := ColorAtRainbowPoint(y,
                                   Form1.ClientWidth,
                                   true);
      ShowMessage(IntToStr(GetRValue(Color)) + #32 +
                  IntToStr(GetGValue(Color)) + #32 +
                  IntToStr(GetBValue(Color)));
    end;
