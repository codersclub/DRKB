---
Title: Sending an image to the printer
Date: 01.01.2007
---

Sending an image to the printer
===============================

::: {.date}
01.01.2007
:::

Sending a bitmap based on the screen to the printer is an
invalid operation that will usually fail, unless the print
driver has been designed to detect this error condition and
compensate for the error. This means you should use the VCL
canvas methods Draw, StretchDraw,CopyRect, BrushCopy, and
the like to transfer a bitmap to the printer, since the
underlying bitmap is based on the screen, and is device
dependent. The only way to reliably print an image is to
use DIBs (Device Independent Bitmaps). Getting a valid DIB can
be difficult, as there are many Windows API functions that must
be used correctly. Further, many video drivers incorrectly fill
in the DIB structure in regards to the color table in the DIB.

The following example demonstrates an attempt to overcome
some of these problems and limitations. The example should
compile successfully under all versions of Delphi/C++ Builder.
The core function in the example, BltTBitmapAsDib(), accepts
a handle to a device to image to, the x and y coordinates you
wish the bitmap to be imaged at, the width and height you wish
the image to be (stretching and shrinking is acceptable), and
the TBitmap you wish to image.

    uses Printers;
     
    type
      PPalEntriesArray = ^TPalEntriesArray; {for palette re-construction}
      TPalEntriesArray = array[0..0] of TPaletteEntry;
     
    procedure BltTBitmapAsDib(DestDc : hdc;   {Handle of where to blt}
                              x : word;       {Bit at x}
                              y : word;       {Blt at y}
                              Width : word;   {Width to stretch}
                              Height : word;  {Height to stretch}
                              bm : TBitmap);  {the TBitmap to Blt}
    var
      OriginalWidth :LongInt;               {width of BM}
      dc : hdc;                             {screen dc}
      IsPaletteDevice : bool;               {if the device uses palettes}
      IsDestPaletteDevice : bool;           {if the device uses palettes}
      BitmapInfoSize : integer;             {sizeof the bitmapinfoheader}
      lpBitmapInfo : PBitmapInfo;           {the bitmap info header}
      hBm : hBitmap;                        {handle to the bitmap}
      hPal : hPalette;                      {handle to the palette}
      OldPal : hPalette;                    {temp palette}
      hBits : THandle;                      {handle to the DIB bits}
      pBits : pointer;                      {pointer to the DIB bits}
      lPPalEntriesArray : PPalEntriesArray; {palette entry array}
      NumPalEntries : integer;              {number of palette entries}
      i : integer;                          {looping variable}
    begin
    {If range checking is on - lets turn it off for now}
    {we will remember if range checking was on by defining}
    {a define called CKRANGE if range checking is on.}
    {We do this to access array members past the arrays}
    {defined index range without causing a range check}
    {error at runtime. To satisfy the compiler, we must}
    {also access the indexes with a variable. ie: if we}
    {have an array defined as a: array[0..0] of byte,}
    {and an integer i, we can now access a[3] by setting}
    {i := 3; and then accessing a[i] without error}
    {$IFOPT R+}
      {$DEFINE CKRANGE}
      {$R-}
    {$ENDIF}
     
     {Save the original width of the bitmap}
      OriginalWidth := bm.Width;
     
     {Get the screen's dc to use since memory dc's are not reliable}
      dc := GetDc(0);
     {Are we a palette device?}
      IsPaletteDevice :=
        GetDeviceCaps(dc, RASTERCAPS) and RC_PALETTE = RC_PALETTE;
     {Give back the screen dc}
      dc := ReleaseDc(0, dc);
     
     {Allocate the BitmapInfo structure}
      if IsPaletteDevice then
        BitmapInfoSize := sizeof(TBitmapInfo) + (sizeof(TRGBQUAD) * 255)
      else
        BitmapInfoSize := sizeof(TBitmapInfo);
      GetMem(lpBitmapInfo, BitmapInfoSize);
     
     {Zero out the BitmapInfo structure}
      FillChar(lpBitmapInfo^, BitmapInfoSize, #0);
     
     {Fill in the BitmapInfo structure}
      lpBitmapInfo^.bmiHeader.biSize := sizeof(TBitmapInfoHeader);
      lpBitmapInfo^.bmiHeader.biWidth := OriginalWidth;
      lpBitmapInfo^.bmiHeader.biHeight := bm.Height;
      lpBitmapInfo^.bmiHeader.biPlanes := 1;
      if IsPaletteDevice then
        lpBitmapInfo^.bmiHeader.biBitCount := 8
      else
        lpBitmapInfo^.bmiHeader.biBitCount := 24;
      lpBitmapInfo^.bmiHeader.biCompression := BI_RGB;
      lpBitmapInfo^.bmiHeader.biSizeImage :=
        ((lpBitmapInfo^.bmiHeader.biWidth *
          longint(lpBitmapInfo^.bmiHeader.biBitCount)) div 8) *
          lpBitmapInfo^.bmiHeader.biHeight;
      lpBitmapInfo^.bmiHeader.biXPelsPerMeter := 0;
      lpBitmapInfo^.bmiHeader.biYPelsPerMeter := 0;
      if IsPaletteDevice then begin
        lpBitmapInfo^.bmiHeader.biClrUsed := 256;
        lpBitmapInfo^.bmiHeader.biClrImportant := 256;
      end else begin
        lpBitmapInfo^.bmiHeader.biClrUsed := 0;
        lpBitmapInfo^.bmiHeader.biClrImportant := 0;
      end;
     
     {Take ownership of the bitmap handle and palette}
      hBm := bm.ReleaseHandle;
      hPal := bm.ReleasePalette;
     
     {Get the screen's dc to use since memory dc's are not reliable}
      dc := GetDc(0);
     
      if IsPaletteDevice then begin
       {If we are using a palette, it must be}
       {selected into the dc during the conversion}
        OldPal := SelectPalette(dc, hPal, TRUE);
       {Realize the palette}
        RealizePalette(dc);
      end;
     {Tell GetDiBits to fill in the rest of the bitmap info structure}
      GetDiBits(dc,
                hBm,
                0,
                lpBitmapInfo^.bmiHeader.biHeight,
                nil,
                TBitmapInfo(lpBitmapInfo^),
                DIB_RGB_COLORS);
     
     {Allocate memory for the Bits}
      hBits := GlobalAlloc(GMEM_MOVEABLE,
                           lpBitmapInfo^.bmiHeader.biSizeImage);
      pBits := GlobalLock(hBits);
     {Get the bits}
      GetDiBits(dc,
                hBm,
                0,
                lpBitmapInfo^.bmiHeader.biHeight,
                pBits,
                TBitmapInfo(lpBitmapInfo^),
                DIB_RGB_COLORS);
     
     
      if IsPaletteDevice then begin
       {Lets fix up the color table for buggy video drivers}
        GetMem(lPPalEntriesArray, sizeof(TPaletteEntry) * 256);
       {$IFDEF VER100}
          NumPalEntries := GetPaletteEntries(hPal,
                                             0,
                                             256,
                                             lPPalEntriesArray^);
       {$ELSE}
          NumPalEntries := GetSystemPaletteEntries(dc,
                                                   0,
                                                   256,
                                                   lPPalEntriesArray^);
       {$ENDIF}
        for i := 0 to (NumPalEntries - 1) do begin
          lpBitmapInfo^.bmiColors[i].rgbRed :=
            lPPalEntriesArray^[i].peRed;
          lpBitmapInfo^.bmiColors[i].rgbGreen :=
            lPPalEntriesArray^[i].peGreen;
          lpBitmapInfo^.bmiColors[i].rgbBlue :=
            lPPalEntriesArray^[i].peBlue;
        end;
        FreeMem(lPPalEntriesArray, sizeof(TPaletteEntry) * 256);
      end;
     
      if IsPaletteDevice then begin
       {Select the old palette back in}
        SelectPalette(dc, OldPal, TRUE);
       {Realize the old palette}
        RealizePalette(dc);
      end;
     
     {Give back the screen dc}
      dc := ReleaseDc(0, dc);
     
     {Is the Dest dc a palette device?}
      IsDestPaletteDevice :=
        GetDeviceCaps(DestDc, RASTERCAPS) and RC_PALETTE = RC_PALETTE;
     
     
      if IsPaletteDevice then begin
       {If we are using a palette, it must be}
       {selected into the dc during the conversion}
        OldPal := SelectPalette(DestDc, hPal, TRUE);
       {Realize the palette}
        RealizePalette(DestDc);
      end;
     
     {Do the blt}
      StretchDiBits(DestDc,
                    x,
                    y,
                    Width,
                    Height,
                    0,
                    0,
                    OriginalWidth,
                    lpBitmapInfo^.bmiHeader.biHeight,
                    pBits,
                    lpBitmapInfo^,
                    DIB_RGB_COLORS,
                    SrcCopy);
     
      if IsDestPaletteDevice then begin
       {Select the old palette back in}
        SelectPalette(DestDc, OldPal, TRUE);
       {Realize the old palette}
        RealizePalette(DestDc);
      end;
     
     {De-Allocate the Dib Bits}
      GlobalUnLock(hBits);
      GlobalFree(hBits);
     
     {De-Allocate the BitmapInfo}
      FreeMem(lpBitmapInfo, BitmapInfoSize);
     
     {Set the ownership of the bimap handles back to the bitmap}
      bm.Handle := hBm;
      bm.Palette := hPal;
     
      {Turn range checking back on if it was on when we started}
    {$IFDEF CKRANGE}
      {$UNDEF CKRANGE}
      {$R+}
    {$ENDIF}
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if PrintDialog1.Execute then begin
        Printer.BeginDoc;
        BltTBitmapAsDib(Printer.Canvas.Handle,
                        0,
                        0,
                        Image1.Picture.Bitmap.Width,
                        Image1.Picture.Bitmap.Height,
                        Image1.Picture.Bitmap);
        Printer.EndDoc;
      end;
    end;
