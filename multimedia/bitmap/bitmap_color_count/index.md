---
Title: Количество уникальных цветов Bitmap
Author: Николай федоровских (Fenik), chook_nu@uraltc.ru
Date: 01.06.2002
---


Количество уникальных цветов Bitmap
===================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Функция возвращает колличество уникальных цветов Bitmap
     
    Зависимости: Graphics
    Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
    Copyright:   Собственное написание (Николай федоровских)
    Дата:        1 июня 2002 г.
    ***************************************************** }
     
    function HowManyColors(Bitmap: TBitmap): Integer;
    type
      TRGB = record
        B, G, R: Byte;
      end;
      pRGB = ^TRGB;
     
    var
      i: Byte;
      x, y: Integer;
      Dest: pRGB;
      RGBArray: array[0..255, 0..255] of array of Byte;
    begin
      Bitmap.PixelFormat := pf24Bit;
      Result := 0;
      for y := 0 to Bitmap.Height - 1 do
      begin
        Dest := Bitmap.ScanLine[y];
        for x := 0 to Bitmap.Width - 1 do
        begin
          with Dest^ do
            if RGBArray[r, g] <> nil then
              for i := 0 to High(RGBArray[r, g]) do
              begin
                //если такой цвет уже есть, то выходим из цыкла
                if RGBArray[r, g][i] = b then
                  Break;
                //если это последний круг цикла, то такого цвета нет
                if i = High(RGBArray[r, g]) then
                begin
                  Inc(Result); //прибавляем один цвет
                  SetLength(RGBArray[r, g], Length(RGBArray[r, g]) + 1);
                  RGBArray[r, g][High(RGBArray[r, g])] := b;
                end;
              end
            else
            begin
              Inc(Result);
              SetLength(RGBArray[r, g], 1);
              RGBArray[r, g][0] := b;
            end;
          Inc(Dest);
        end;
      end;
    end;

Пример использования:

    procedure TForm1.MMHowManyColorsClick(Sender: TObject);
    var
      str: string;
    begin
      Screen.Cursor := crHourGlass;
      try
        str := Format('Изображение содержит %d цветов.', [HowManyColors(FBitmap)]);
      finally
        Screen.Cursor := crDefault;
      end;
      Application.MessageBox(PChar(str), PChar(Application.Title), MB_OK);
    end;
