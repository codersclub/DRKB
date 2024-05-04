---
Title: Конвертирование BMP -> WMF
Date: 01.01.2007
---


Конвертирование BMP -> WMF
==========

Вариант 1:

Source: <https://forum.sources.ru>

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


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

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

