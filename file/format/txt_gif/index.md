---
Title: Конвертирование TXT -> GIF
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Конвертирование TXT -> GIF
==========

    procedure TxtToGif(txt, FileName: string);
    var
      temp: TBitmap;
      GIF: TGIFImage;
    begin
     
      temp := TBitmap.Create;
      try
        temp.Height := 400;
        temp.Width := 60;
        temp.Transparent := True;
        temp.Canvas.Brush.Color := colFondo.ColorValue;
        temp.Canvas.Font.Name := Fuente.FontName;
        temp.Canvas.Font.Color := colFuente.ColorValue;
        temp.Canvas.TextOut(10, 10, txt);
        Imagen.Picture.Assign(nil);
     
        GIF := TGIFImage.Create;
        try
          // Convert the bitmap to a GIF
          GIF.Assign(Temp);
          // Save the GIF
          GIF.SaveToFile(FileName);
          // Display the GIF
          Imagen.Picture.Assign(GIF);
        finally
          GIF.Free;
        end;
     
      finally
     
        temp.Destroy;
      end;
    end;

