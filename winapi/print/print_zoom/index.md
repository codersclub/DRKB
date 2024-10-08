---
Title: Растягивание изображения при печати
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---

Растягивание изображения при печати
===================================

> Я пишу программу, которая печатает изображение на принтере с помощью
> объекта TPrinter. Проблема происходит когда я пытаюсь "растянуть"
> изображение до требуемого размера на бумаге. Мой метод растяжения
> (bitblts и принтерном DC) приводит к белым кляксам, а само изображение
> получается практически серым. Конечно это не то, что мне хотелось.  
> Кто-нибудь может мне помочь?

Попробуй это:

    procedure DrawImage(Canvas: TCanvas; DestRect: TRect; ABitmap:
      TBitmap);
    var
     
      Header, Bits: Pointer;
      HeaderSize: Integer;
      BitsSize: Longint;
    begin
      GetDIBSizes(ABitmap.Handle, HeaderSize, BitsSize);
      Header := MemAlloc(HeaderSize);
      Bits := MemAlloc(BitsSize);
      try
        GetDIB(ABitmap.Handle, ABitmap.Palette, Header^, Bits^);
        StretchDIBits(Canvas.Handle, DestRect.Left, DestRect.Top,
          DestRect.Right, DestRect.Bottom,
          0, 0, ABitmap.Width, ABitmap.Height, Bits, TBitmapInfo(Header^),
          DIB_RGB_COLORS, SRCCOPY);
    { вам может понадобиться цветовой стандарт DIB_PAL_COLORS,
    но это уже выходит за рамки моих знаний. }
      finally
        MemFree(Header, HeaderSize);
        MemFree(Bits, BitsSize);
      end;
    end;
     
    { Печатаем изображение, растягивая его до целого листа }
     
    procedure PrintBitmap(ABitmap: TBitmap);
    var
      relheight, relwidth: integer;
    begin
      screen.cursor := crHourglass;
      Printer.BeginDoc;
      if ((ABitmap.width / ABitmap.height) > l(printer.pagewidth / printer.pageheight)) then
        begin
    { Растягиваем ширину изображения до ширины бумаги }
          relwidth := printer.pagewidth;
          relheight := MulDiv(ABitmap.height, printer.pagewidth, ABitmap.width);
        end
      else
        begin
    { Растягиваем высоту изображения до высоты бумаги }
          relwidth := MulDiv(ABitmap.width, printer.pageheight, ABitmap.height);
          relheight := printer.pageheight;
        end;
      DrawImage(Printer.Canvas, Rect(0, 0, relWidth, relHeight), ABitmap);
      Printer.EndDoc;
      screen.cursor := crDefault;
    end;

