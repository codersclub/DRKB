---
Title: Как работать с Fade для TImage?
Date: 01.01.2007
Author: Yucel Karapinar, ykarapinar@hotmail.com
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как работать с Fade для TImage?
===============================

    type 
      PRGBTripleArray = ^TRGBTripleArray; 
      TRGBTripleArray = array[0..32767] of TRGBTriple; 
     
    ///////////////////////////////////////////////// 
    //                  Fade In                    // 
    ///////////////////////////////////////////////// 
     
     
    procedure FadeIn(ImageFileName: TFileName); 
    var 
      Bitmap, BaseBitmap: TBitmap; 
      Row, BaseRow: PRGBTripleArray; 
      x, y, step: integer; 
    begin 
      // Bitmaps vorbereiten / Preparing the Bitmap // 
      Bitmap := TBitmap.Create; 
      try 
        Bitmap.PixelFormat := pf32bit;  // oder pf24bit / or pf24bit // 
        Bitmap.LoadFromFile(ImageFileName); 
        BaseBitmap := TBitmap.Create; 
        try 
          BaseBitmap.PixelFormat := pf32bit; 
          BaseBitmap.Assign(Bitmap); 
          // Fading // 
          for step := 0 to 32 do 
          begin 
            for y := 0 to (Bitmap.Height - 1) do 
            begin 
              BaseRow := BaseBitmap.Scanline[y]; 
              // Farben vom Endbild holen / Getting colors from final image // 
              Row := Bitmap.Scanline[y]; 
              // Farben vom aktuellen Bild / Colors from the image as it is now // 
              for x := 0 to (Bitmap.Width - 1) do 
              begin 
                Row[x].rgbtRed := (step * BaseRow[x].rgbtRed) shr 5; 
                Row[x].rgbtGreen := (step * BaseRow[x].rgbtGreen) shr 5; // Fading // 
                Row[x].rgbtBlue := (step * BaseRow[x].rgbtBlue) shr 5; 
              end; 
            end; 
            Form1.Canvas.Draw(0, 0, Bitmap);   // neues Bild ausgeben / Output new image // 
            InvalidateRect(Form1.Handle, nil, False); 
            // Fenster neu zeichnen / Redraw window // 
            RedrawWindow(Form1.Handle, nil, 0, RDW_UPDATENOW); 
          end; 
        finally 
          BaseBitmap.Free; 
        end; 
      finally 
        Bitmap.Free; 
      end; 
    end; 
     
    ///////////////////////////////////////////////// 
    //                  Fade Out                   // 
    ///////////////////////////////////////////////// 
     
     
    procedure FadeOut(ImageFileName: TFileName); 
    var 
      Bitmap, BaseBitmap: TBitmap; 
      Row, BaseRow: PRGBTripleArray; 
      x, y, step: integer; 
    begin 
      // Bitmaps vorbereiten / Preparing the Bitmap // 
      Bitmap := TBitmap.Create; 
      try 
        Bitmap.PixelFormat := pf32bit;  // oder pf24bit / or pf24bit // 
        Bitmap.LoadFromFile(ImageFileName); 
        BaseBitmap := TBitmap.Create; 
        try 
          BaseBitmap.PixelFormat := pf32bit; 
          BaseBitmap.Assign(Bitmap); 
          // Fading // 
         for step := 32 downto 0 do 
          begin 
            for y := 0 to (Bitmap.Height - 1) do 
            begin 
              BaseRow := BaseBitmap.Scanline[y]; 
              // Farben vom Endbild holen / Getting colors from final image // 
              Row := Bitmap.Scanline[y]; 
              // Farben vom aktuellen Bild / Colors from the image as it is now // 
              for x := 0 to (Bitmap.Width - 1) do 
              begin 
                Row[x].rgbtRed := (step * BaseRow[x].rgbtRed) shr 5; 
                Row[x].rgbtGreen := (step * BaseRow[x].rgbtGreen) shr 5; // Fading // 
                Row[x].rgbtBlue := (step * BaseRow[x].rgbtBlue) shr 5; 
              end; 
            end; 
            Form1.Canvas.Draw(0, 0, Bitmap);   // neues Bild ausgeben / Output new image // 
            InvalidateRect(Form1.Handle, nil, False); 
            // Fenster neu zeichnen / Redraw window // 
            RedrawWindow(Form1.Handle, nil, 0, RDW_UPDATENOW); 
          end; 
        finally 
          BaseBitmap.Free; 
        end; 
      finally 
        Bitmap.Free; 
      end; 
    end; 
     
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      FadeIn('C:\TestImage.bmp') 
    end; 
     
     
    {*****************************} 
    {by Yucel Karapinar, ykarapinar@hotmail.com } 
     
    { Only for 24 ve 32 bits bitmaps } 
     
    procedure FadeOut(const Bmp: TImage; Pause: Integer); 
    var 
      BytesPorScan, counter, w, h: Integer; 
      p: pByteArray; 
    begin 
      if not (Bmp.Picture.Bitmap.PixelFormat in [pf24Bit, pf32Bit]) then 
        raise Exception.Create('Error, bitmap format is not supporting.'); 
      try 
        BytesPorScan := Abs(Integer(Bmp.Picture.Bitmap.ScanLine[1]) - 
          Integer(Bmp.Picture.Bitmap.ScanLine[0])); 
      except 
        raise Exception.Create('Error!!'); 
      end; 
     
      for counter := 1 to 256 do 
      begin 
        for h := 0 to Bmp.Picture.Bitmap.Height - 1 do 
        begin 
          P := Bmp.Picture.Bitmap.ScanLine[h]; 
          for w := 0 to BytesPorScan - 1 do 
            if P^[w] > 0 then P^[w] := P^[w] - 1; 
        end; 
        Sleep(Pause); 
        Bmp.Refresh; 
      end; 
    end; 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      FadeOut(Image1, 1); 
    end; 

