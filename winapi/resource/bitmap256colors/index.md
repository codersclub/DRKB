---
Title: 256-цветное изображение из RES-файла
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

256-цветное изображение из RES-файла
====================================

    function LoadBitmap256(hInstance: HWND; lpBitmapName: PChar): HBITMAP;
    var
      hPal, hRes, hResInfo: THandle;
      pBitmap: PBitmapInfo;
      nColorData: Integer;
      pPalette: PLogPalette;
      X: Integer;
      hPalette: THandle;
    begin
     
      hResInfo := FindResource(hInstance, lpBitmapName, RT_BITMAP);
      hRes := LoadResource(hInstance, hResInfo);
      pBitmap := Lockresource(hRes);
      nColorData := pBitmap^.bmiHeader.biClrUsed;
     
      hPal := GlobalAlloc(GMEM_MOVEABLE, (16 * nColorData));
     
      { hPal := GlobalAlloc( GMEM_MOVEABLE, ( SizeOf( LOGPALETTE ) +
                (nColorData * SizeOf( PALETTEENTRY )));}
      pPalette := GlobalLock(hPal);
      pPalette^.palVersion := $300;
      pPalette^.palNumEntries := nColorData;
     
      for x := 0 to nColorData do
      begin
        pPalette^.palPalentry[X].peRed := pBitmap^.bmiColors[X].rgbRed;
        pPalette^.palPalentry[X].peGreen := pBitmap^.bmiColors[X].rgbGreen;
        pPalette^.palPalentry[X].peBlue := pBitmap^.bmiColors[X].rgbBlue;
      end;
     
      hPalette := CreatePalette(pPalette^);
      GlobalUnlock(hRes);
      GlobalUnlock(hPal);
      GlobalFree(hPal);
     
    end;
     
    end.

