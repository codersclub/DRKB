---
Title: Отображаем текст в System Tray
Author: Ruslan Abu Zant
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Отображаем текст в System Tray
==============================

Данный код сперва конвертирует Ваш текст в DIB, а затем DIB в иконку и
далее в ресурс. После этого изображение иконки отображается в System
Tray.

Вызов просходит следующим образом....

    StringToIcon('This Is Made By Ruslan K. Abu Zant');

**N.B**: Не забудьте удалить объект HIcon, после вызова функции...

    unit MainForm;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Image1: TImage;
        Timer1: TTimer;
        procedure Button1Click(Sender: TObject);
        procedure Timer1Timer(Sender: TObject);
      private
        function StringToIcon(const st: string): HIcon;
      public
       { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    type
      ICONIMAGE = record
        Width, Height, Colors: DWORD; // Ширина, Высота и кол-во цветов
        lpBits: PChar; // указатель на DIB биты
        dwNumBytes: DWORD; // Сколько байт?
        lpbi: PBitmapInfoHeader; // указатель на заголовок
        lpXOR: PChar; // указатель на XOR биты изображения
        lpAND: PChar; // указатель на AND биты изображения
      end;
     
    function CopyColorTable(var lpTarget: BITMAPINFO; const lpSource:
      BITMAPINFO): boolean;
    var
      dc: HDC;
      hPal: HPALETTE;
      pe: array[0..255] of PALETTEENTRY;
      i: Integer;
    begin
      result := False;
      case (lpTarget.bmiHeader.biBitCount) of
        8:
          if lpSource.bmiHeader.biBitCount = 8 then
            begin
              Move(lpSource.bmiColors, lpTarget.bmiColors, 256 * sizeof(RGBQUAD));
              result := True
            end
          else
            begin
              dc := GetDC(0);
              if dc <> 0 then
              try
                hPal := CreateHalftonePalette(dc);
                if hPal <> 0 then
                try
                  if GetPaletteEntries(hPal, 0, 256, pe) <> 0 then
                    begin
                      for i := 0 to 255 do
                        begin
                          lpTarget.bmiColors[i].rgbRed := pe[i].peRed;
                          lpTarget.bmiColors[i].rgbGreen := pe[i].peGreen;
                          lpTarget.bmiColors[i].rgbBlue := pe[i].peBlue;
                          lpTarget.bmiColors[i].rgbReserved := pe[i].peFlags
                        end;
                      result := True
                    end
                finally
                  DeleteObject(hPal)
                end
              finally
                ReleaseDC(0, dc)
              end
            end;
     
        4:
          if lpSource.bmiHeader.biBitCount = 4 then
            begin
              Move(lpSource.bmiColors, lpTarget.bmiColors, 16 * sizeof(RGBQUAD));
              result := True
            end
          else
            begin
              hPal := GetStockObject(DEFAULT_PALETTE);
              if (hPal <> 0) and (GetPaletteEntries(hPal, 0, 16, pe) <> 0) then
                begin
                  for i := 0 to 15 do
                    begin
                      lpTarget.bmiColors[i].rgbRed := pe[i].peRed;
                      lpTarget.bmiColors[i].rgbGreen := pe[i].peGreen;
                      lpTarget.bmiColors[i].rgbBlue := pe[i].peBlue;
                      lpTarget.bmiColors[i].rgbReserved := pe[i].peFlags
                    end;
                  result := True
                end
            end;
        1:
          begin
            i := 0;
            lpTarget.bmiColors[i].rgbRed := 0;
            lpTarget.bmiColors[i].rgbGreen := 0;
            lpTarget.bmiColors[i].rgbBlue := 0;
            lpTarget.bmiColors[i].rgbReserved := 0;
            i := 1;
            lpTarget.bmiColors[i].rgbRed := 255;
            lpTarget.bmiColors[i].rgbGreen := 255;
            lpTarget.bmiColors[i].rgbBlue := 255;
            lpTarget.bmiColors[i].rgbReserved := 0;
            result := True
          end;
      else
        result := True
      end
    end;
     
    function WidthBytes(bits: DWORD): DWORD;
    begin
      result := ((bits + 31) shr 5) shl 2
    end;
     
    function BytesPerLine(const bmih: BITMAPINFOHEADER): DWORD;
    begin
      result := WidthBytes(bmih.biWidth * bmih.biPlanes * bmih.biBitCount)
    end;
     
    function DIBNumColors(const lpbi: BitmapInfoHeader): word;
    var
      dwClrUsed: DWORD;
    begin
      dwClrUsed := lpbi.biClrUsed;
      if dwClrUsed <> 0 then
        result := Word(dwClrUsed)
      else
        case lpbi.biBitCount of
          1: result := 2;
          4: result := 16;
          8: result := 256
        else
          result := 0
        end
    end;
     
    function PaletteSize(const lpbi: BitmapInfoHeader): word;
    begin
      result := DIBNumColors(lpbi) * sizeof(RGBQUAD)
    end;
     
    function FindDIBBits(const lpbi: BitmapInfo): PChar;
    begin
      result := @lpbi;
      result := result + lpbi.bmiHeader.biSize + PaletteSize(lpbi.bmiHeader)
    end;
     
    function ConvertDIBFormat(var lpSrcDIB: BITMAPINFO; nWidth, nHeight, nbpp: DWORD; bStretch: boolean):
      PBitmapInfo;
    var
      lpbmi: PBITMAPINFO;
      lpSourceBits, lpTargetBits: Pointer;
      DC, hSourceDC, hTargetDC: HDC;
      hSourceBitmap, hTargetBitmap, hOldTargetBitmap, hOldSourceBitmap:
      HBITMAP;
      dwSourceBitsSize, dwTargetBitsSize, dwTargetHeaderSize: DWORD;
    begin
      result := nil;
       // Располагаем и заполняем структуру BITMAPINFO для нового DIB
       // Обеспечиваем достаточно места для 256-цветной таблицы
      dwTargetHeaderSize := sizeof(BITMAPINFO) + (256 * sizeof(RGBQUAD));
      GetMem(lpbmi, dwTargetHeaderSize);
      try
        lpbmi^.bmiHeader.biSize := sizeof(BITMAPINFOHEADER);
        lpbmi^.bmiHeader.biWidth := nWidth;
        lpbmi^.bmiHeader.biHeight := nHeight;
        lpbmi^.bmiHeader.biPlanes := 1;
        lpbmi^.bmiHeader.biBitCount := nbpp;
        lpbmi^.bmiHeader.biCompression := BI_RGB;
        lpbmi^.bmiHeader.biSizeImage := 0;
        lpbmi^.bmiHeader.biXPelsPerMeter := 0;
        lpbmi^.bmiHeader.biYPelsPerMeter := 0;
        lpbmi^.bmiHeader.biClrUsed := 0;
        lpbmi^.bmiHeader.biClrImportant := 0; // Заполняем в таблице цветов
        if CopyColorTable(lpbmi^, lpSrcDIB) then
          begin
            DC := GetDC(0);
            hTargetBitmap := CreateDIBSection(DC, lpbmi^, DIB_RGB_COLORS,
              lpTargetBits, 0, 0);
            hSourceBitmap := CreateDIBSection(DC, lpSrcDIB, DIB_RGB_COLORS,
              lpSourceBits, 0, 0);
     
            try
              if (dc <> 0) and (hTargetBitmap <> 0) and (hSourceBitmap <> 0) then
                begin
                  hSourceDC := CreateCompatibleDC(DC);
                  hTargetDC := CreateCompatibleDC(DC);
                  try
                    if (hSourceDC <> 0) and (hTargetDC <> 0) then
                      begin
                 // Flip the bits on the source DIBSection to match the source DIB
                        dwSourceBitsSize := DWORD(lpSrcDIB.bmiHeader.biHeight) * BytesPerLine(lpSrcDIB.bmiHeader);
                        dwTargetBitsSize := DWORD(lpbmi^.bmiHeader.biHeight) *
                          BytesPerLine(lpbmi^.bmiHeader);
                        Move(FindDIBBits(lpSrcDIB)^, lpSourceBits^, dwSourceBitsSize);
     
                 // Select DIBSections into DCs
                        hOldSourceBitmap := SelectObject(hSourceDC, hSourceBitmap);
                        hOldTargetBitmap := SelectObject(hTargetDC, hTargetBitmap);
     
                        try
                          if (hOldSourceBitmap <> 0) and (hOldTargetBitmap <> 0) then
                            begin
               // Устанавливаем таблицу цветов для DIBSections
                              if lpSrcDIB.bmiHeader.biBitCount <= 8 then
                                SetDIBColorTable(hSourceDC, 0, 1 shl lpSrcDIB.bmiHeader.biBitCount, lpSrcDIB.bmiColors);
     
                              if lpbmi^.bmiHeader.biBitCount <= 8 then
                                SetDIBColorTable(hTargetDC, 0, 1 shl
                                  lpbmi^.bmiHeader.biBitCount, lpbmi^.bmiColors);
     
                      // If we are asking for a straight copy, do it
                              if (lpSrcDIB.bmiHeader.biWidth = lpbmi^.bmiHeader.biWidth) and (lpSrcDIB.bmiHeader.biHeight = lpbmi^.bmiHeader.biHeight) then
                                BitBlt(hTargetDC, 0, 0, lpbmi^.bmiHeader.biWidth, lpbmi^.bmiHeader.biHeight, hSourceDC, 0, 0, SRCCOPY)
                              else if bStretch then
                                begin
                                  SetStretchBltMode(hTargetDC, COLORONCOLOR);
                                  StretchBlt(hTargetDC, 0, 0, lpbmi^.bmiHeader.biWidth,
                                    lpbmi^.bmiHeader.biHeight,
                                    hSourceDC, 0, 0, lpSrcDIB.bmiHeader.biWidth, lpSrcDIB.bmiHeader.biHeight,
                                    SRCCOPY)
                                end
                              else
                                BitBlt(hTargetDC, 0, 0, lpbmi^.bmiHeader.biWidth, lpbmi^.bmiHeader.biHeight, hSourceDC, 0, 0, SRCCOPY);
     
                              GDIFlush;
                              GetMem(result, Integer(dwTargetHeaderSize + dwTargetBitsSize));
     
                              Move(lpbmi^, result^, dwTargetHeaderSize);
                              Move(lpTargetBits^, FindDIBBits(result^)^, dwTargetBitsSize)
                            end
                        finally
                          if hOldSourceBitmap <> 0 then SelectObject(hSourceDC, hOldSourceBitmap);
                          if hOldTargetBitmap <> 0 then SelectObject(hTargetDC, hOldTargetBitmap);
                        end
                      end
                  finally
                    if hSourceDC <> 0 then DeleteDC(hSourceDC);
                    if hTargetDC <> 0 then
                      DeleteDC(hTargetDC)
                  end
                end;
            finally
              if hTargetBitmap <> 0 then DeleteObject(hTargetBitmap);
              if hSourceBitmap <> 0 then DeleteObject(hSourceBitmap);
              if dc <> 0 then
                ReleaseDC(0, dc)
            end
          end
      finally
        FreeMem(lpbmi)
      end
    end;
     
    function DIBToIconImage(var lpii: ICONIMAGE; var lpDIB: BitmapInfo;
      bStretch: boolean): boolean;
    var
      lpNewDIB: PBitmapInfo;
    begin
      result := False;
      lpNewDIB := ConvertDIBFormat(lpDIB, lpii.Width, lpii.Height, lpii.Colors,
        bStretch);
      if Assigned(lpNewDIB) then
      try
     
        lpii.dwNumBytes := sizeof(BITMAPINFOHEADER) // Заголовок
          + PaletteSize(lpNewDIB^.bmiHeader) // Палитра
          + lpii.Height * BytesPerLine(lpNewDIB^.bmiHeader) // XOR маска
          + lpii.Height * WIDTHBYTES(lpii.Width); // AND маска
          // Если здесь уже картинка, то освобождаем её
        if lpii.lpBits <> nil then
          FreeMem(lpii.lpBits);
     
        GetMem(lpii.lpBits, lpii.dwNumBytes);
        Move(lpNewDib^, lpii.lpBits^, sizeof(BITMAPINFOHEADER) + PaletteSize
          (lpNewDIB^.bmiHeader));
         // Выравниваем внутренние указатели/переменные для новой картинки
        lpii.lpbi := PBITMAPINFOHEADER(lpii.lpBits);
        lpii.lpbi^.biHeight := lpii.lpbi^.biHeight * 2;
     
        lpii.lpXOR := FindDIBBits(PBitmapInfo(lpii.lpbi)^);
        Move(FindDIBBits(lpNewDIB^)^, lpii.lpXOR^, lpii.Height * BytesPerLine
          (lpNewDIB^.bmiHeader));
     
        lpii.lpAND := lpii.lpXOR + lpii.Height * BytesPerLine
          (lpNewDIB^.bmiHeader);
        Fillchar(lpii.lpAnd^, lpii.Height * WIDTHBYTES(lpii.Width), $00);
     
        result := True
      finally
        FreeMem(lpNewDIB)
      end
    end;
     
    function TForm1.StringToIcon(const st: string): HIcon;
    var
      memDC: HDC;
      bmp: HBITMAP;
      oldObj: HGDIOBJ;
      rect: TRect;
      size: TSize;
      infoHeaderSize: DWORD;
      imageSize: DWORD;
      infoHeader: PBitmapInfo;
      icon: IconImage;
      oldFont: HFONT;
     
    begin
      result := 0;
      memDC := CreateCompatibleDC(0);
      if memDC <> 0 then
      try
        bmp := CreateCompatibleBitmap(Canvas.Handle, 16, 16);
        if bmp <> 0 then
        try
          oldObj := SelectObject(memDC, bmp);
          if oldObj <> 0 then
          try
            rect.Left := 0;
            rect.top := 0;
            rect.Right := 16;
            rect.Bottom := 16;
            SetTextColor(memDC, RGB(255, 0, 0));
            SetBkColor(memDC, RGB(128, 128, 128));
            oldFont := SelectObject(memDC, font.Handle);
            GetTextExtentPoint32(memDC, PChar(st), Length(st), size);
            ExtTextOut(memDC, (rect.Right - size.cx) div 2, (rect.Bottom - size.cy) div 2, ETO_OPAQUE, @rect, PChar(st), Length(st), nil);
            SelectObject(memDC, oldFont);
            GDIFlush;
     
            GetDibSizes(bmp, infoHeaderSize, imageSize);
            GetMem(infoHeader, infoHeaderSize + ImageSize);
            try
              GetDib(bmp, SystemPalette16, infoHeader^, PChar(DWORD(infoHeader) + infoHeaderSize)^);
     
              icon.Colors := 4;
              icon.Width := 32;
              icon.Height := 32;
              icon.lpBits := nil;
              if DibToIconImage(icon, infoHeader^, True) then
              try
                result := CreateIconFromResource(PByte(icon.lpBits), icon.dwNumBytes, True, $00030000);
              finally
                FreeMem(icon.lpBits)
              end
            finally
              FreeMem(infoHeader)
            end
     
          finally
            SelectObject(memDC, oldOBJ)
          end
        finally
          DeleteObject(bmp)
        end
      finally
        DeleteDC(memDC)
      end
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Application.Icon.Handle := StringToIcon('0');
      Timer1.Enabled := True;
      Button1.Enabled := False;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject); {Код исправлен by Alex (http://forum.vingrad.ru)}
    {$WRITEABLECONST ON}
    const
      i: Integer = 0;
    begin
      Inc(i);
      if i = 100 then i := 1;
      Application.Icon.Handle := StringToIcon(IntToStr(i));
    {$WRITEABLECONST OFF}
    end;
    end.

