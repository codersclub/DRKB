---
Title: Информация о BMP-файлах
Date: 01.01.2007
---


Информация о BMP-файлах
=======================

    {
      This tip show, how to get the filesize, width, height, bitcount and color used 
      from a bitmap. 
     
      Dieses Beispiel zeigt, wie man Dateigrosse, breite, hohe, Farbtiefe und Farbanzahl 
      von einem Bitmap ausliest. 
    }
     
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       fileheader: TBitmapfileheader;
       infoheader: TBitmapinfoheader;
       s: TFilestream;
     begin
       s := TFileStream.Create('c:\YourBitmap.bmp', fmOpenRead);
       try
         s.Read(fileheader, SizeOf(fileheader));
         s.Read(infoheader, SizeOf(infoheader));
       finally
         s.Free;
       end;
       listbox1.Items.Clear;
       listbox1.Items.Add('Filesize:    ' + IntToStr(fileheader.bfSize));
       listbox1.Items.Add('Width:       ' + IntToStr(infoheader.biWidth));
       listbox1.Items.Add('Height:      ' + IntToStr(infoheader.biHeight));
       listbox1.Items.Add('BitCount:    ' + IntToStr(infoheader.biBitCount));
       listbox1.Items.Add('Used:        ' + IntToStr(infoheader.biClrUsed));
     end;
     
     { 
      BitCount: 
      1 = black/white 
      4 = 16 colors 
      8 = 256 colors 
    }
