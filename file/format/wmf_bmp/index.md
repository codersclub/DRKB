---
Title: WMF -> BMP
Date: 01.01.2007
---


WMF -> BMP
==========

::: {.date}
01.01.2007
:::

    procedure ConvertWMF2BMP
    (const WMFFileName, BMPFileName: TFileName); 
    var 
      MetaFile : TMetafile; 
      Bitmap : TBitmap; 
    begin 
      Metafile := TMetaFile.Create; 
      Bitmap := TBitmap.Create; 
      try 
        MetaFile.LoadFromFile(WMFFileName); 
        with Bitmap do 
        begin 
          Height := Metafile.Height; 
          Width  := Metafile.Width; 
          Canvas.Draw(0, 0, MetaFile); 
          SaveToFile(BMPFileName); 
        end; 
      finally
                    Bitmap.Free; 
        MetaFile.Free; 
      end; 
    end;

Использование:

    ConvertWMF2BMP('c:\mypic.wmf','c:\mypic.bmp')

Взято из <https://forum.sources.ru>
