---
Title: Sharpen a bitmap
Date: 01.01.2007
---


Sharpen a bitmap
================

::: {.date}
01.01.2007
:::

    procedure Sharpen(sbm, tbm: TBitmap; alpha: Single);
    //to sharpen, alpha must be >1.
    //pixelformat pf24bit
    //sharpens sbm to tbm
    var
      i, j, k: integer;
      sr: array[0..2] of PByte;
      st: array[0..4] of pRGBTriple;
      tr: PByte;
      tt, p: pRGBTriple;
      beta: Single;
      inta, intb: integer;
      bmh, bmw: integer;
      re, gr, bl: integer;
      BytesPerScanline: integer;
     
    begin
      //sharpening is blending of the current pixel
      //with the average of the surrounding ones,
      //but with a negative weight for the average
      Assert((sbm.Width > 2) and (sbm.Height > 2), 'Bitmap must be at least 3x3');
      Assert((alpha > 1) and (alpha < 6), 'Alpha must be >1 and <6');
      beta := (alpha - 1) / 5; //we assume alpha>1 and beta<1
      intb := round(beta * $10000);
      inta := round(alpha * $10000); //integer scaled alpha and beta
      sbm.PixelFormat := pf24bit;
      tbm.PixelFormat := pf24bit;
      tbm.Width := sbm.Width;
      tbm.Height := sbm.Height;
      bmw := sbm.Width - 2;
      bmh := sbm.Height - 2;
      BytesPerScanline := (((bmw + 2) * 24 + 31) and not 31) div 8;
     
      tr := tbm.Scanline[0];
      tt := pRGBTriple(tr);
     
      sr[0] := sbm.Scanline[0];
      st[0] := pRGBTriple(sr[0]);
      for j := 0 to bmw + 1 do
      begin
        tt^ := st[0]^;
        inc(tt); inc(st[0]); //first row unchanged
      end;
     
      sr[1] := PByte(integer(sr[0]) - BytesPerScanline);
      sr[2] := PByte(integer(sr[1]) - BytesPerScanline);
      for i := 1 to bmh do
      begin
        Dec(tr, BytesPerScanline);
        tt := pRGBTriple(tr);
        st[0] := pRGBTriple(integer(sr[0]) + 3); //top
        st[1] := pRGBTriple(sr[1]); //left
        st[2] := pRGBTriple(integer(sr[1]) + 3); //center
        st[3] := pRGBTriple(integer(sr[1]) + 6); //right
        st[4] := pRGBTriple(integer(sr[2]) + 3); //bottom
        tt^ := st[1]^; //1st col unchanged
        for j := 1 to bmw do
        begin
        //calcutate average weighted by -beta
          re := 0; gr := 0; bl := 0;
          for k := 0 to 4 do
          begin
            re := re + st[k]^.rgbtRed;
            gr := gr + st[k]^.rgbtGreen;
            bl := bl + st[k]^.rgbtBlue;
            inc(st[k]);
          end;
          re := (intb * re + $7FFF) shr 16;
          gr := (intb * gr + $7FFF) shr 16;
          bl := (intb * bl + $7FFF) shr 16;
     
        //add center pixel weighted by alpha
          p := pRGBTriple(st[1]); //after inc, st[1] is at center
          re := (inta * p^.rgbtRed + $7FFF) shr 16 - re;
          gr := (inta * p^.rgbtGreen + $7FFF) shr 16 - gr;
          bl := (inta * p^.rgbtBlue + $7FFF) shr 16 - bl;
     
        //clamp and move into target pixel
          inc(tt);
          if re < 0 then
            re := 0
          else
            if re > 255 then
              re := 255;
          if gr < 0 then
            gr := 0
          else
            if gr > 255 then
              gr := 255;
          if bl < 0 then
            bl := 0
          else
            if bl > 255 then
              bl := 255;
          //this looks stupid, but avoids function calls
     
          tt^.rgbtRed := re;
          tt^.rgbtGreen := gr;
          tt^.rgbtBlue := bl;
        end;
        inc(tt);
        inc(st[1]);
        tt^ := st[1]^; //Last col unchanged
        sr[0] := sr[1];
        sr[1] := sr[2];
        Dec(sr[2], BytesPerScanline);
      end;
      // copy last row
      Dec(tr, BytesPerScanline);
      tt := pRGBTriple(tr);
      st[1] := pRGBTriple(sr[1]);
      for j := 0 to bmw + 1 do
      begin
        tt^ := st[1]^;
        inc(tt); inc(st[1]);
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
