---
Title: Растягивание изображения
Date: 01.01.2007
---


Растягивание изображения
========================

Вариант 1:

    // This function stretches a bitmap with specified number of pixels 
    // in horizontal, vertical dimension 
    // Example Call : ResizeBmp(Image1.Picture.Bitmap, 200, 200); 
     
    function TForm1.ResizeBmp(bitmp: TBitmap; wid, hei: Integer): Boolean;
    var
      TmpBmp: TBitmap;
      ARect: TRect;
    begin
      Result := False;
      try
        TmpBmp := TBitmap.Create;
        try
          TmpBmp.Width  := wid;
          TmpBmp.Height := hei;
          ARect := Rect(0,0, wid, hei);
          TmpBmp.Canvas.StretchDraw(ARect, Bitmp);
          bitmp.Assign(TmpBmp);
        finally
          TmpBmp.Free;
        end;
        Result := True;
      except
        Result := False;
      end;
    end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    unit DeleteScans;
    //Renate Schaaf 
    //renates@xmission.com 
     
    interface
     
    uses Windows, Graphics;
     
    procedure DeleteScansRect(Src, Dest: TBitmap; rs, rd: TRect);
    //scanline implementation of Stretchblt/Delete_Scans 
    //about twice as fast 
    //Stretches Src to Dest, rs is source rect, rd is dest. rect 
    //The stretch is centered, i.e the center of rs is mapped to the center of rd. 
    //Src, Dest are assumed to be bottom up 
     
    implementation
     
    uses Classes, math;
     
    type
      TRGBArray = array[0..64000] of TRGBTriple;
      PRGBArray = ^TRGBArray;
    
      TQuadArray = array[0..64000] of TRGBQuad;
      PQuadArray = ^TQuadArray;
     
    procedure DeleteScansRect(Src, Dest: TBitmap; rs, rd: TRect);
    var
      xsteps, ysteps: array of Integer;
      intscale: Integer;
      i, x, y, x1, x2, bitspp, bytespp: Integer;
      ts, td: PByte;
      bs, bd, WS, hs, w, h: Integer;
      Rows, rowd: PByte;
      j, c: Integer;
      pf: TPixelFormat;
      xshift, yshift: Integer;
    begin
      WS := rs.Right - rs.Left;
      hs := rs.Bottom - rs.Top;
      w  := rd.Right - rd.Left;
      h  := rd.Bottom - rd.Top;
      pf := Src.PixelFormat;
      if (pf <> pf32Bit) and (pf <> pf24bit) then
      begin
        pf := pf24bit;
        Src.PixelFormat := pf;
      end;
      Dest.PixelFormat := pf;
      if not (((w <= WS) and (h <= hs)) or ((w >= WS) and (h >= hs))) then
      //we do not handle a mix of up-and downscaling, 
      //using threadsafe StretchBlt instead. 
      begin
        Src.Canvas.Lock;
        Dest.Canvas.Lock;
        try
          SetStretchBltMode(Dest.Canvas.Handle, STRETCH_DELETESCANS);
          StretchBlt(Dest.Canvas.Handle, rd.Left, rd.Top, w, h,
            Src.Canvas.Handle, rs.Left, rs.Top, WS, hs, SRCCopy);
        finally
          Dest.Canvas.Unlock;
          Src.Canvas.Unlock;
        end;
        Exit;
      end;
    
      if pf = pf24bit then
      begin
        bitspp  := 24;
        bytespp := 3;
      end
      else
      begin
        bitspp  := 32;
        bytespp := 4;
      end;
      bs := (Src.Width * bitspp + 31) and not 31;
      bs := bs div 8; //BytesPerScanline Source 
      bd := (Dest.Width * bitspp + 31) and not 31;
      bd := bd div 8; //BytesPerScanline Dest 
      if w < WS then //downsample 
      begin
        //first make arrays of the skipsteps 
        SetLength(xsteps, w);
        SetLength(ysteps, h);
        intscale := round(WS / w * $10000);
        x1       := 0;
        x2       := (intscale + $7FFF) shr 16;
        c  := 0;
        for i := 0 to w - 1 do
        begin
          xsteps[i] := (x2 - x1) * bytespp;
          x1        := x2;
          x2        := ((i + 2) * intscale + $7FFF) shr 16;
          if i = w - 2 then
            c := x1;
        end;
        xshift   := min(max((WS - c) div 2, - rs.Left), Src.Width - rs.Right);
        intscale := round(hs / h * $10000);
        x1       := 0;
        x2       := (intscale + $7FFF) shr 16;
        c        := 0;
        for i := 0 to h - 1 do
        begin
          ysteps[i] := (x2 - x1) * bs;
          x1        := x2;
          x2        := ((i + 2) * intscale + $7FFF) shr 16;
          if i = h - 2 then
            c := x1;
        end;
        yshift := min(max((hs - c) div 2, - rs.Top), Src.Height - rs.Bottom);
        if pf = pf24bit then
        begin
          Rows := @PRGBArray(Src.Scanline[rs.Top + yshift])^[rs.Left + xshift];
          rowd := @PRGBArray(Dest.Scanline[rd.Top])^[rd.Left];
          for y := 0 to h - 1 do
          begin
            ts := Rows;
            td := rowd;
            for x := 0 to w - 1 do
            begin
              pRGBTriple(td)^ := pRGBTriple(ts)^;
              Inc(td, bytespp);
              Inc(ts, xsteps[x]);
            end;
            Dec(rowd, bd);
            Dec(Rows, ysteps[y]);
          end;
        end
        else
        begin
          Rows := @PQuadArray(Src.Scanline[rs.Top + yshift])^[rs.Left + xshift];
          rowd := @PQuadArray(Dest.Scanline[rd.Top])^[rd.Left];
          for y := 0 to h - 1 do
          begin
            ts := Rows;
            td := rowd;
            for x := 0 to w - 1 do
            begin
              pRGBQuad(td)^ := pRGBQuad(ts)^;
              Inc(td, bytespp);
              Inc(ts, xsteps[x]);
            end;
            Dec(rowd, bd);
            Dec(Rows, ysteps[y]);
          end;
        end;
      end
      else
      begin
        //first make arrays of the steps of uniform pixels 
        SetLength(xsteps, WS);
        SetLength(ysteps, hs);
        intscale := round(w / WS * $10000);
        x1       := 0;
        x2       := (intscale + $7FFF) shr 16;
        c        := 0;
        for i := 0 to WS - 1 do
        begin
          xsteps[i] := x2 - x1;
          x1        := x2;
          x2        := ((i + 2) * intscale + $7FFF) shr 16;
          if x2 > w then
            x2 := w;
          if i = WS - 1 then
            c := x1;
        end;
        if c < w then //>is now not possible 
        begin
          xshift         := (w - c) div 2;
          yshift         := w - c - xshift;
          xsteps[WS - 1] := xsteps[WS - 1] + xshift;
          xsteps[0]      := xsteps[0] + yshift;
        end;
        intscale := round(h / hs * $10000);
        x1       := 0;
        x2       := (intscale + $7FFF) shr 16;
        c        := 0;
        for i := 0 to hs - 1 do
        begin
          ysteps[i] := (x2 - x1);
          x1        := x2;
          x2        := ((i + 2) * intscale + $7FFF) shr 16;
          if x2 > h then
            x2 := h;
          if i = hs - 1 then
            c := x1;
        end;
        if c < h then
        begin
          yshift         := (h - c) div 2;
          ysteps[hs - 1] := ysteps[hs - 1] + yshift;
          yshift         := h - c - yshift;
          ysteps[0]      := ysteps[0] + yshift;
        end;
        if pf = pf24bit then
        begin
          Rows := @PRGBArray(Src.Scanline[rs.Top])^[rs.Left];
          rowd := @PRGBArray(Dest.Scanline[rd.Top])^[rd.Left];
          for y := 0 to hs - 1 do
          begin
            for j := 1 to ysteps[y] do
            begin
              ts := Rows;
              td := rowd;
              for x := 0 to WS - 1 do
              begin
                for i := 1 to xsteps[x] do
                begin
                  pRGBTriple(td)^ := pRGBTriple(ts)^;
                  Inc(td, bytespp);
                end;
                Inc(ts, bytespp);
              end;
              Dec(rowd, bd);
            end;
            Dec(Rows, bs);
          end;
        end
        else
        begin
          Rows := @PQuadArray(Src.Scanline[rs.Top])^[rs.Left];
          rowd := @PQuadArray(Dest.Scanline[rd.Top])^[rd.Left];
          for y := 0 to hs - 1 do
          begin
            for j := 1 to ysteps[y] do
            begin
              ts := Rows;
              td := rowd;
              for x := 0 to WS - 1 do
              begin
                for i := 1 to xsteps[x] do
                begin
                  pRGBQuad(td)^ := pRGBQuad(ts)^;
                  Inc(td, bytespp);
                end;
                Inc(ts, bytespp);
              end;
              Dec(rowd, bd);
            end;
            Dec(Rows, bs);
          end;
        end;
      end;
    end;
    
    
    end.

