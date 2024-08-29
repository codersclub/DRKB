---
Title: Вывести Bitmap на рабочем столе
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Вывести Bitmap на рабочем столе
===============================

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Picture: TPicture;
      Desktop: TCanvas;
      X, Y: Integer;
    begin
      // Objekte erstellen 
      // create objects 
      Picture := TPicture.Create;
      Desktop := TCanvas.Create;
     
      // Bild laden 
      // load bitmap 
      Picture.LoadFromFile('bitmap1.bmp');
     
      // Geratekontex vom Desktop ermitteln 
      // get DC of desktop 
      Desktop.Handle := GetWindowDC(0);
     
      // Position des Bildes 
      // position of bitmap 
      X := 100;
      Y := 100;
     
      // Bild zeichnen 
      // draw bitmap 
      Desktop.Draw(X, Y, Picture.Graphic);
     
      // Geratekontex freigeben 
      ReleaseDC(0, Desktop.Handle);
     
      // Objekte freigeben 
      // release objects 
      Picture.Free;
      Desktop.Free;
    end;
     


