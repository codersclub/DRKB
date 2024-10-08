---
Title: Как распечатать BMP?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---

Как распечатать BMP?
====================

    procedure StretchPrint(R: TRect; ABitmap: Graphics.TBitmap);
    var
      dc: HDC;
      isDcPalDevice: Bool;
      hDibHeader: THandle;
      pDibHeader: pointer;
      hBits: THandle;
      pBits: pointer;
      ppal: PLOGPALETTE;
      pal: hPalette;
      Oldpal: hPalette;
      i: integer;
    begin
      pal := 0;
      OldPal := 0;
      {Get the screen dc}
      dc := GetDc(0);
      {Allocate memory for a DIB structure}
      hDibHeader := GlobalAlloc(GHND, sizeof(TBITMAPINFO) + (sizeof(TRGBQUAD) * 256));
      {get a pointer to the alloced memory}
      pDibHeader := GlobalLock(hDibHeader);
      {fill in the dib structure with info on the way we want the DIB}
      FillChar(pDibHeader^, sizeof(TBITMAPINFO) + (sizeof(TRGBQUAD) * 256), #0);
      PBITMAPINFOHEADER(pDibHeader)^.biSize := sizeof(TBITMAPINFOHEADER);
      PBITMAPINFOHEADER(pDibHeader)^.biPlanes := 1;
      PBITMAPINFOHEADER(pDibHeader)^.biBitCount := 8;
      PBITMAPINFOHEADER(pDibHeader)^.biWidth := ABitmap.width;
      PBITMAPINFOHEADER(pDibHeader)^.biHeight := ABitmap.height;
      PBITMAPINFOHEADER(pDibHeader)^.biCompression := BI_RGB;
      {find out how much memory for the bits}
      GetDIBits(dc, ABitmap.Handle, 0, ABitmap.height, nil, TBitmapInfo(pDibHeader^),
        DIB_RGB_COLORS);
      {Alloc memory for the bits}
      hBits := GlobalAlloc(GHND, PBitmapInfoHeader(pDibHeader)^.BiSizeImage);
      {Get a pointer to the bits}
      pBits := GlobalLock(hBits);
      {Call fn again, but this time give us the bits!}
      GetDIBits(dc, ABitmap.Handle, 0, ABitmap.height, pBits, PBitmapInfo(pDibHeader)^,
        DIB_RGB_COLORS);
      {Release the screen dc}
      ReleaseDc(0, dc);
      {Just incase the printer drver is a palette device}
      isDcPalDevice := false;
      if GetDeviceCaps(Printer.Canvas.Handle, RASTERCAPS) and RC_PALETTE = RC_PALETTE then
      begin
        {Create palette from dib}
        GetMem(pPal, sizeof(TLOGPALETTE) + (255 * sizeof(TPALETTEENTRY)));
        FillChar(pPal^, sizeof(TLOGPALETTE) + (255 * sizeof(TPALETTEENTRY)), #0);
        pPal^.palVersion := $300;
        pPal^.palNumEntries := 256;
        for i := 0 to (pPal^.PalNumEntries - 1) do
        begin
          pPal^.palPalEntry[i].peRed := PBitmapInfo(pDibHeader)^.bmiColors[i].rgbRed;
          pPal^.palPalEntry[i].peGreen := PBitmapInfo(pDibHeader)^.bmiColors[i].rgbGreen;
          pPal^.palPalEntry[i].peBlue := PBitmapInfo(pDibHeader)^.bmiColors[i].rgbBlue;
        end;
        pal := CreatePalette(pPal^);
        FreeMem(pPal, sizeof(TLOGPALETTE) + (255 * sizeof(TPALETTEENTRY)));
        oldPal := SelectPalette(Printer.Canvas.Handle, Pal, false);
        isDcPalDevice := true
      end;
      {send the bits to the printer}
      StretchDiBits(Printer.Canvas.Handle, R.Left, R.Top, R.Right - R.Left,
        R.Bottom - R.Top, 0, 0, ABitmap.Width, ABitmap.Height, pBits,
        PBitmapInfo(pDibHeader)^, DIB_RGB_COLORS, SRCCOPY);
      {Just incase you printer drver is a palette device}
      if isDcPalDevice = true then
      begin
        SelectPalette(Printer.Canvas.Handle, oldPal, false);
        DeleteObject(Pal);
      end;
      {Clean up allocated memory}
      GlobalUnlock(hBits);
      GlobalFree(hBits);
      GlobalUnlock(hDibHeader);
      GlobalFree(hDibHeader);
    end;

