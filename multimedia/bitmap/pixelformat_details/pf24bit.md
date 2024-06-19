---
Title: Bitmap.PixelFormat := pf24bit;
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Bitmap.PixelFormat := pf24bit;
==============================

Для pf24bit-изображений необходимо определить:

    CONST
    PixelCountMax = 32768;
     
    TYPE
    pRGBArray = ^TRGBArray;
    TRGBArray = ARRAY[0..PixelCountMax-1] OF TRGBTriple;

Примечание: TRGBTriple определен в модуле Windows.PAS.

Для того, чтобы к существующему 24-битному изображению иметь доступ как
к изображению, созданному с разрешением 3 байта на пиксел, сделайте
следующее:

    ...
    VAR
    i           :  INTEGER;
    j           :  INTEGER;
    RowOriginal :  pRGBArray;
    RowProcessed:  pRGBArray;
    BEGIN
      IF   OriginalBitmap.PixelFormat <> pf24bit THEN 
        RAISE EImageProcessingError.Create('GetImageSpace: ' +
          'Изображение должно быть 24-х битным.');
      {Шаг через каждую строчку изображения.}
      FOR j := OriginalBitmap.Height-1 DOWNTO 0 DO
      BEGIN
        RowOriginal  := pRGBArray(OriginalBitmap.Scanline[j]);
        RowProcessed := pRGBArray(ProcessedBitmap.Scanline[j]);
        FOR i := OriginalBitmap.Width-1 DOWNTO 0 DO
        BEGIN
          // Доступ к RGB-цветам отдельных пикселей
          // должен осуществляться следующим образом:
          // RowProcessed[i].rgbtRed     := RowOriginal[i].rgbtRed;
          // RowProcessed[i].rgbtGreen   := RowOriginal[i].rgbtGreen;
          // RowProcessed[i].rgbtBlue    := RowOriginal[i].rgbtBlue;
        END
      END
    END
    ...

