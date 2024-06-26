---
Title: Изменение цветовой палитры изображения
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Изменение цветовой палитры изображения
======================================

> Мне необходимо изменить цветовую палитру изображения с помощью
> SetBitmapBits, но у меня, к сожалению, ничего не получается.

Использование SetBitmapBits - не очень хорошая идея, поскольку она имеет
дело с HBitmaps, в котором формат пикселя не определен. Несомненно, это
более безопасная операция, но никаких гарантий по ее выполнению дать
невозможно.

Взамен я предлагаю использовать функции DIB API. Вот некоторый код,
позволяющий вам изменять таблицу цветов. Просто напишите метод с такими
же параметрами, как у TFiddleProc и и изменяйте ColorTable, передаваемое
как параметр. Затем просто вызовите процедуру FiddleBitmap, передающую
TBitmap и ваш fiddle-метод, например так:

FiddleBitmap( MyBitmap, Fiddler ) ;

    type
      TFiddleProc = procedure(var ColorTable: TColorTable) of object;
     
    const
      LogPaletteSize = sizeof(TLogPalette) + sizeof(TPaletteEntry) * 255;
     
    function PaletteFromDIB(BitmapInfo: PBitmapInfo): HPalette;
    var
      LogPalette: PLogPalette;
      i: integer;
      Temp: byte;
    begin
      with BitmapInfo^, bmiHeader do
      begin
        GetMem(LogPalette, LogPaletteSize);
        try
          with LogPalette^ do
          begin
            palVersion := $300;
            palNumEntries := 256;
            Move(bmiColors, palPalEntry, sizeof(TRGBQuad) * 256);
            for i := 0 to 255 do
              with palPalEntry[i] do
              begin
                Temp := peBlue;
                peBlue := peRed;
                peRed := Temp;
                peFlags := PC_NOCOLLAPSE;
              end;
     
            { создаем палитру }
            Result := CreatePalette(LogPalette^);
          end;
        finally
          FreeMem(LogPalette, LogPaletteSize);
        end;
      end;
    end;
     
    { Следующая процедура на основе изображения создает DIB,
    изменяет ее таблицу цветов, создавая тем самым новую палитру,
    после чего передает ее обратно изображению. При этом
    используется метод косвенного вызова, с помощью которого
    изменяется палитра цветов - ей передается array[ 0..255 ] of TRGBQuad. }
     
    procedure FiddleBitmap(Bitmap: TBitmap; FiddleProc: TFiddleProc);
    const
      BitmapInfoSize = sizeof(TBitmapInfo) + sizeof(TRGBQuad) * 255;
    var
      BitmapInfo: PBitmapInfo;
      Pixels: pointer;
      InfoSize: integer;
      ADC: HDC;
      OldPalette: HPalette;
    begin
      { получаем DIB }
      GetMem(BitmapInfo, BitmapInfoSize);
      try
        { меняем таблицу цветов - ПРИМЕЧАНИЕ: она использует 256 цветов DIB }
        FillChar(BitmapInfo^, BitmapInfoSize, 0);
        with BitmapInfo^.bmiHeader do
        begin
          biSize := sizeof(TBitmapInfoHeader);
          biWidth := Bitmap.Width;
          biHeight := Bitmap.Height;
          biPlanes := 1;
          biBitCount := 8;
          biCompression := BI_RGB;
          biClrUsed := 256;
          biClrImportant := 256;
          GetDIBSizes(Bitmap.Handle, InfoSize, biSizeImage);
     
          { распределяем место для пикселей }
          Pixels := GlobalAllocPtr(GMEM_MOVEABLE, biSizeImage);
          try
            { получаем пиксели DIB }
            ADC := GetDC(0);
            try
              OldPalette := SelectPalette(ADC, Bitmap.Palette, false);
              try
                RealizePalette(ADC);
                GetDIBits(ADC, Bitmap.Handle, 0, biHeight, Pixels, BitmapInfo^,
                  DIB_RGB_COLORS);
              finally
                SelectPalette(ADC, OldPalette, true);
              end;
            finally
              ReleaseDC(0, ADC);
            end;
     
            { теперь изменяем таблицу цветов }
            FiddleProc(PColorTable(@BitmapInfo^.bmiColors)^);
     
            { создаем палитру на основе новой таблицы цветов }
            Bitmap.Palette := PaletteFromDIB(BitmapInfo);
            OldPalette := SelectPalette(Bitmap.Canvas.Handle, Bitmap.Palette,
              false);
            try
              RealizePalette(Bitmap.Canvas.Handle);
              StretchDIBits(Bitmap.Canvas.Handle, 0, 0, biWidth, biHeight, 0, 0,
                biWidth, biHeight,
                Pixels, BitmapInfo^, DIB_RGB_COLORS, SRCCOPY);
            finally
              SelectPalette(Bitmap.Canvas.Handle, OldPalette, true);
            end;
          finally
            GlobalFreePtr(Pixels);
          end;
        end;
      finally
        FreeMem(BitmapInfo, BitmapInfoSize);
      end;
    end;
     
    { Пример "fiddle"-метода }
     
    procedure TForm1.Fiddler(var ColorTable: TColorTable);
    var
      i: integer;
    begin
      for i := 0 to 255 do
        with ColorTable[i] do
        begin
          rgbRed := rgbRed * 9 div 10;
          rgbGreen := rgbGreen * 9 div 10;
          rgbBlue := rgbBlue * 9 div 10;
        end;
    end;

