---
Title: Как распечатать TImage?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Как распечатать TImage?
=======================

Вариант 1:

    uses 
      Printers; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      ScaleX, ScaleY: Integer; 
      RR: TRect; 
    begin 
      with Printer do 
      begin 
        BeginDoc; 
        // The StartDoc function starts a print job. 
        try 
          ScaleX := GetDeviceCaps(Handle, logPixelsX) div PixelsPerInch; 
          ScaleY := GetDeviceCaps(Handle, logPixelsY) div PixelsPerInch; 
          // Retrieves information about the Pixels per Inch of the Printer. 
          RR := Rect(0, 0, Image1.picture.Width * scaleX, Image1.Picture.Height * ScaleY); 
          Canvas.StretchDraw(RR, Image1.Picture.Graphic); 
          // Stretch to fit 
     
        finally 
          EndDoc;   
        end; 
      end; 
    end; 

------------------------------------------------------------------------
Вариант 2:

    // Based on posting to borland.public.delphi.winapi by Rodney E Geraghty, 8/8/97. 
     
    procedure PrintBitmap(Canvas: TCanvas; DestRect: TRect; Bitmap: TBitmap); 
    var 
      BitmapHeader: pBitmapInfo; 
      BitmapImage: Pointer; 
      HeaderSize: DWORD; 
      ImageSize: DWORD; 
    begin 
      GetDIBSizes(Bitmap.Handle, HeaderSize, ImageSize); 
      GetMem(BitmapHeader, HeaderSize); 
      GetMem(BitmapImage, ImageSize); 
      try 
        GetDIB(Bitmap.Handle, Bitmap.Palette, BitmapHeader^, BitmapImage^); 
        StretchDIBits(Canvas.Handle, 
          DestRect.Left, DestRect.Top,    // Destination Origin 
          DestRect.Right - DestRect.Left, // Destination Width 
          DestRect.Bottom - DestRect.Top, // Destination Height 
          0, 0,                           // Source Origin 
          Bitmap.Width, Bitmap.Height,    // Source Width & Height 
          BitmapImage, 
          TBitmapInfo(BitmapHeader^), 
          DIB_RGB_COLORS, 
          SRCCOPY) 
      finally 
        FreeMem(BitmapHeader); 
        FreeMem(BitmapImage) 
      end 
    end {PrintBitmap}; 

------------------------------------------------------------------------
Вариант 3:

    // from www.experts-exchange.com 
     
    uses 
      printers; 
     
    procedure DrawImage(Canvas: TCanvas; DestRect: TRect; ABitmap: TBitmap); 
    var 
      Header, Bits: Pointer; 
      HeaderSize: DWORD; 
      BitsSize: DWORD; 
    begin 
      GetDIBSizes(ABitmap.Handle, HeaderSize, BitsSize); 
      Header := AllocMem(HeaderSize); 
      Bits := AllocMem(BitsSize); 
      try 
        GetDIB(ABitmap.Handle, ABitmap.Palette, Header^, Bits^); 
        StretchDIBits(Canvas.Handle, DestRect.Left, DestRect.Top, 
          DestRect.Right, DestRect.Bottom, 
          0, 0, ABitmap.Width, ABitmap.Height, Bits, TBitmapInfo(Header^), 
          DIB_RGB_COLORS, SRCCOPY); 
      finally 
        FreeMem(Header, HeaderSize); 
        FreeMem(Bits, BitsSize); 
      end; 
    end; 
     
    procedure PrintImage(Image: TImage; ZoomPercent: Integer); 
      // if ZoomPercent=100, Image will be printed across the whole page 
    var  
      relHeight, relWidth: integer; 
    begin 
      Screen.Cursor := crHourglass; 
      Printer.BeginDoc; 
      with Image.Picture.Bitmap do  
      begin 
        if ((Width / Height) > (Printer.PageWidth / Printer.PageHeight)) then 
        begin 
          // Stretch Bitmap to width of PrinterPage 
          relWidth := Printer.PageWidth; 
          relHeight := MulDiv(Height, Printer.PageWidth, Width); 
        end  
        else 
        begin 
          // Stretch Bitmap to height of PrinterPage 
          relWidth  := MulDiv(Width, Printer.PageHeight, Height); 
          relHeight := Printer.PageHeight; 
        end; 
        relWidth := Round(relWidth * ZoomPercent / 100); 
        relHeight := Round(relHeight * ZoomPercent / 100); 
        DrawImage(Printer.Canvas, Rect(0, 0, relWidth, relHeight), Image.Picture.Bitmap); 
      end; 
      Printer.EndDoc; 
      Screen.cursor := crDefault; 
    end; 
     
    // Example Call: 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      // Print image at 40% zoom: 
      PrintImage(Image1, 40); 
    end; 

