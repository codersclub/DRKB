---
Title: Зеркальное преобразование
Date: 01.01.2007
---


Зеркальное преобразование
=========================

Вариант 1:

Source: <https://www.swissdelphicenter.ch>

    procedure flip_horizontal(Quelle, Ziel: TBitMap);
     begin
       Ziel.Assign(nil);
       Ziel.Width  := Quelle.Width;
       Ziel.Height := Quelle.Height;
       StretchBlt(Ziel.Canvas.Handle, 0, 0, Ziel.Width, Ziel.Height, Quelle.Canvas.Handle,
         0, Quelle.Height, Quelle.Width, Quelle.Height, srccopy);
     end;
     
     procedure flip_vertikal(Quelle, Ziel: TBitMap);
     begin
       Ziel.Assign(nil);
       Ziel.Width  := Quelle.Width;
       Ziel.Height := Quelle.Height;
       StretchBlt(Ziel.Canvas.Handle, 0, 0, Ziel.Width, Ziel.Height, Quelle.Canvas.Handle,
         Quelle.Width, 0, Quelle.Width, Quelle.Height, srccopy);
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       temp: TBitMap;
     begin
       temp := TBitMap.Create;
       try
         temp.Assign(Image1.Picture.BitMap);
         flip_vertikal(Temp, Image1.Picture.Bitmap);
       finally
         Temp.Free;
       end;
     end;


------------------------------------------------------------------------

Вариант 2:

Author: Федоровских Николай (Fenik), chook_nu@uraltc.ru

Date: 16.07.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Зеркальное отражение изображения
     
    Зависимости: Windows, Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Автор: Федоровских Николай
    Дата:        16 июля 2002 г.
    ***************************************************** }
     
    procedure FlipBitmap(Bitmap: TBitmap; FlipHor: Boolean);
    {Зеркальное отражение изображения.
     Если FlipHor = True, то отражение по горизонтали,
     иначе по вертикали.}
    var
      x, y, W, H: Integer;
      Pixel_1, Pixel_2: PRGBTriple;
      MemPixel: TRGBTriple;
    begin
      Bitmap.PixelFormat := pf24Bit;
      W := Bitmap.Width - 1;
      H := Bitmap.Height - 1;
      if FlipHor then {отражение по горизонтали}
        for y := 0 to H do
        begin
          {помещаем оба указателя на строку H:}
          Pixel_1 := Bitmap.ScanLine[y];
          Pixel_2 := Bitmap.ScanLine[y];
          {помещаем второй указатель в конец строки:}
          Inc(Pixel_2, W);
          {цикл идёт только до середины строки:}
          for x := 0 to W div 2 do
          begin
            {симметричные точки обмениваются цветами:}
            MemPixel := Pixel_1^;
            Pixel_1^ := Pixel_2^;
            Pixel_2^ := MemPixel;
            Inc(Pixel_1); {смещаем указатель вправо}
            Dec(Pixel_2); {смещаем указатель влево}
          end;
        end
      else {отражение по вертикали}
        {цикл идёт только до средней строки:}
        for y := 0 to H div 2 do
        begin
          {помещаем первый указатель на строку H,
           а второй на строку симметричную H:}
          Pixel_1 := Bitmap.ScanLine[y];
          Pixel_2 := Bitmap.ScanLine[H - y];
          for x := 0 to W do
          begin
            {симметричные точки обмениваются цветами:}
            MemPixel := Pixel_1^;
            Pixel_1^ := Pixel_2^;
            Pixel_2^ := MemPixel;
            Inc(Pixel_1); {смещаем указатель вправо}
            Inc(Pixel_2); {смещаем указатель вправо}
          end;
        end;
    end;
