---
Title: Как создать регион (HRNG) по маске?
Date: 01.01.2007
---


Как создать регион (HRNG) по маске?
===================================

::: {.date}
01.01.2007
:::

Ниже приведена функция, которая создаёт HRGN из чёрно-белого битмапа.
Все чёрные пиксели становятся регионом, а белые становятся прозрачными.
Так же не составит труда сделать преобразования для поддержки всех
цветов и чтобы один из них был прозрачным.

По окончании необходимо освободить регион при помощи функции
DeleteObject.

    function BitmapToRgn(Image: TBitmap): HRGN; 
    var 
      TmpRgn: HRGN; 
      x, y: integer; 
      ConsecutivePixels: integer; 
      CurrentPixel: TColor; 
      CreatedRgns: integer; 
      CurrentColor: TColor; 
    begin 
      CreatedRgns := 0; 
      Result := CreateRectRgn(0, 0, Image.Width, Image.Height); 
      inc(CreatedRgns); 
     
      if (Image.Width = 0) or (Image.Height = 0) then exit; 
     
      for y := 0 to Image.Height - 1 do 
        begin 
        CurrentColor := Image.Canvas.Pixels[0,y]; 
        ConsecutivePixels := 1; 
        for x := 0 to Image.Width - 1 do 
          begin 
          CurrentPixel := Image.Canvas.Pixels[x,y]; 
     
          if CurrentColor = CurrentPixel 
            then inc(ConsecutivePixels) 
            else begin 
                 // Входим в новую зону
                 if CurrentColor = clWhite then 
                   begin 
                   TmpRgn := CreateRectRgn(x-ConsecutivePixels, y, x, y+1); 
                   CombineRgn(Result, Result, TmpRgn, RGN_DIFF); 
                   inc(CreatedRgns); 
                   DeleteObject(TmpRgn); 
                   end; 
                 CurrentColor := CurrentPixel; 
                 ConsecutivePixels := 1; 
                 end; 
          end; 
     
       if (CurrentColor = clWhite) and (ConsecutivePixels > 0) then 
          begin 
          TmpRgn := CreateRectRgn(x-ConsecutivePixels, y, x, y+1); 
          CombineRgn(Result, Result, TmpRgn, RGN_DIFF); 
          inc(CreatedRgns); 
          DeleteObject(TmpRgn); 
          end; 
        end; 
    end;

Взято из <https://forum.sources.ru>
