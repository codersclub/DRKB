---
Title: Пример работы с Flash
Date: 01.01.2007
---


Пример работы с Flash
=====================

::: {.date}
01.01.2007
:::

The example of a simple movie creating which shows rectangle moving and
circle transforming is below

    Procedure MakeSWF;
     var Movie: TFlashMovie;
         Shape1, Shape2: TFlashShape;
    begin
      Movie := TFlashMovie.Create(0, 0, 400 * twips, 400 * twips, 12);
      Movie.Compressed := true;
      Movie.SystemCoord := scPix;
      Shape1 := Movie.AddCircle(0, 0, 50);
      Shape1.SetRadialGragient(cswfWhite, SWFRGBA(clNavy), 35, 35);
      Shape2 := Movie.AddRectangle(0, 0, 150, 50);
      Shape2.SetSolidColor(SWFRGBA(clRed, $cc));
     
      For il := 0 to 20 do
        begin
         With Movie.PlaceObject(Shape1, 1) do
          begin
            SetScale(1+il / 10, 1+il / 20);
            SetTranslate(200, 200);
            if il>0 then RemoveDepth := true;
          end;
         With Movie.PlaceObject(Shape2, 2) do
           begin
             SetTranslate(20+il, il*6);
             if il>0 then RemoveDepth := true;
           end;
         Movie.ShowFrame;
        end;
      ...      
      Movie.MakeStream;
      Movie.SaveToFile('demo.swf');
      Movie.Free;
    end;
     

https://www.delphiflash.com
