---
Title: Конвертирование BMP -> EMF (Enhanced Metafile)
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Конвертирование BMP -> EMF (Enhanced Metafile)
==============================

    function bmp2emf(const SourceFileName: TFileName): Boolean;
    // Converts a Bitmap to a Enhanced Metafile (*.emf)
    var
      Metafile: TMetafile;
      MetaCanvas: TMetafileCanvas;
      Bitmap: TBitmap;
    begin
      Metafile := TMetaFile.Create;
      try
        Bitmap := TBitmap.Create;
        try
          Bitmap.LoadFromFile(SourceFileName);
          Metafile.Height := Bitmap.Height;
          Metafile.Width := Bitmap.Width;
          MetaCanvas := TMetafileCanvas.Create(Metafile, 0);
          try
            MetaCanvas.Draw(0, 0, Bitmap);
          finally
            MetaCanvas.Free;
          end;
        finally
          Bitmap.Free;
        end;
        Metafile.SaveToFile(ChangeFileExt(SourceFileName, '.emf'));
      finally
        Metafile.Free;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      bmp2emf('C:\TestBitmap.bmp');
    end;

