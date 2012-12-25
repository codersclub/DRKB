---
Title: BMP \> WMF
Date: 01.01.2007
---


BMP \> WMF
==========

::: {.date}
01.01.2007
:::

    procedure ConvertBMP2WMF
    (const BMPFileName, WMFFileName: TFileName); 
    var 
      MetaFile : TMetafile; 
      Bitmap : TBitmap; 
    begin 
      Metafile := TMetaFile.Create; 
      Bitmap := TBitmap.Create; 
      try 
        Bitmap.LoadFromFile(BMPFileName); 
        with MetaFile do 
        begin 
          Height := Bitmap.Height; 
          Width  := Bitmap.Width; 
          Canvas.Draw(0, 0, Bitmap); 
          SaveToFile(WMFFileName); 
        end; 
      finally
                    Bitmap.Free; 
        MetaFile.Free; 
      end; 
    end;

Использование:

    ConvertBMP2WMF('c:\mypic.bmp','c:\mypic.wmf')

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    procedure TForm1.Button1Click(Sender: TObject);
    var
      m : TmetaFile;
      mc : TmetaFileCanvas;
      b : tbitmap;
    begin
      m := TMetaFile.Create;
      b := TBitmap.create;
      b.LoadFromFile('C:.bmp');
      m.Height := b.Height;
      m.Width := b.Width;
      mc := TMetafileCanvas.Create(m, 0);
      mc.Draw(0, 0, b);
      mc.Free;
      b.Free;
      m.SaveToFile('C:.emf');
      m.Free;
      Image1.Picture.LoadFromFile('C:.emf');
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
