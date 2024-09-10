---
Title: Печать изображения
Author: Alexey Torgashin
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---

Печать изображения
==================

    {
    Печать изображения. Использует модуль Printers.
    Должно работать со всеми типами графики: битмепами, метафайлами и иконками.
    (c) Alexey Torgashin, 2007
     
    Последняя версия функции всегда доступна в исходниках компонента ATViewer:
    http://atorg.net.ru/delphi/atviewer.htm
     
    Параметры:
    - AImage: TImage объект.
    - ACopies: число копий (можно задать 0 для одной копии).
    - AFitToPage: умещать картинку в страницу принтера.
      Если картинка меньше страницы и AFitOnlyLarger=False,
      то картинка будет растянута.
    - AFitOnlyLarger: разрешает умещать только картинки, бОльшие размера страницы.
    - ACenter: центрировать картинку по странице.
    - APixelsPerInch: число точек на дюйм на экране.
      Передавайте сюда значение свойства PixelsPerInch Вашей формы
      или объекта Screen.
    - ACaption: заголовок задания печати в Print Manager.
     
    -----------------------------------
     
    Image printing. Uses Printers unit.
    Should work with all graphics: bitmaps, metafiles and icons.
     
    Parameters:
    - AImage: TImage object.
    - ACopies: number of copies (you may set 0 for a single copy).
    - AFitToPage: fit image to a printer page. If image is smaller than a page and
      AFitOnlyLarger=False then image will be stretched up to a page.
    - AFitOnlyLarger: allows to stretch images smaller than a page.
    - ACenter: center image on a page.
    - APixelsPerInch: pass here value of PixelsPerInch property of your form or
      of a Screen object (Screen.PixelsPerInch).
    - ACaption: print job caption in Print Manager.
    }
     
    function ImagePrint(
      AImage: TImage;
      ACopies: word;
      AFitToPage,
      AFitOnlyLarger,
      ACenter: boolean;
      APixelsPerInch: integer;
      const ACaption: string): boolean;
    var
      bmp: TBitmap;
    begin
      bmp:= TBitmap.Create;
      try
        bmp.PixelFormat:= pf24bit;
     
        {$ifdef ADV_IMAGE_CONV}
        if not CorrectImageToBitmap(AImage, bmp, clWhite) then
        begin
          Result:= false;
          Exit
        end;
        {$else}
        with AImage.Picture do
        begin
          bmp.Width:= Graphic.Width;
          bmp.Height:= Graphic.Height;
          bmp.Canvas.Draw(0, 0, Graphic);
        end;
        {$endif}
     
        Result:= BitmapPrint( //Declared below
          bmp,
          ACopies,
          AFitToPage,
          AFitOnlyLarger,
          ACenter,
          APixelsPerInch,
          ACaption);
     
      finally
        bmp.Free;
      end;
    end;
     
     
    function BitmapPrint(
      ABitmap: TBitmap;
      ACopies: word;
      AFitToPage,
      AFitOnlyLarger,
      ACenter: boolean;
      APixelsPerInch: integer;
      const ACaption: string): boolean;
    var
      Scale, ScalePX, ScalePY, ScaleX, ScaleY: Double;
      SizeX, SizeY,
      RectSizeX, RectSizeY, RectOffsetX, RectOffsetY: integer;
      i: integer;
    Begin
      Result:= true;
     
      Assert(
        Assigned(ABitmap) and (ABitmap.Width>0) and (ABitmap.Height>0),
        'BitmapPrint: bitmap is empty.');
     
      if ACopies = 0 then
        Inc(ACopies);
     
      with Printer do
      begin
        SizeX:= PageWidth;
        SizeY:= PageHeight;
     
        ScalePX:= GetDeviceCaps(Handle, LOGPIXELSX) / APixelsPerInch;
        ScalePY:= GetDeviceCaps(Handle, LOGPIXELSY) / APixelsPerInch;
     
        ScaleX:= SizeX / ABitmap.Width / ScalePX;
        ScaleY:= SizeY / ABitmap.Height / ScalePY;
     
        if ScaleX < ScaleY then
          Scale:= ScaleX
        else
          Scale:= ScaleY;
     
        if (not AFitToPage) or (AFitOnlyLarger and (Scale > 1.0)) then
          Scale:= 1.0;
     
        RectSizeX:= Trunc(ABitmap.Width * Scale * ScalePX);
        RectSizeY:= Trunc(ABitmap.Height * Scale * ScalePY);
     
        if ACenter then
        begin
          RectOffsetX:= (SizeX - RectSizeX) div 2;
          RectOffsetY:= (SizeY - RectSizeY) div 2;
        end
        else
        begin
          RectOffsetX:= 0;
          RectOffsetY:= 0;
        end;
     
        Title:= ACaption;
     
        try
          BeginDoc;
          try
            for i:= 1 to ACopies do
            begin
              Canvas.StretchDraw(
                Rect(
                  RectOffsetX,
                  RectOffsetY,
                  RectOffsetX + RectSizeX,
                  RectOffsetY + RectSizeY),
                ABitmap
                );
              if i < ACopies then
                NewPage;
            end;
          finally
            EndDoc;
          end;
        except
          Result:= false;
        end;
      end;
    end;

