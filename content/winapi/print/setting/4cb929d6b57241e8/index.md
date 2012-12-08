---
Title: Как узнать минимальные поля для принтера?
Date: 01.01.2007
---

Как узнать минимальные поля для принтера?
=========================================

::: {.date}
01.01.2007
:::

    uses 
      Printers; 
     
    type 
      TMargins = record 
        Left, 
        Top, 
        Right, 
        Bottom: Double 
    end; 
     
    procedure GetPrinterMargins(var Margins: TMargins); 
    var 
      PixelsPerInch: TPoint; 
      PhysPageSize: TPoint; 
      OffsetStart: TPoint; 
      PageRes: TPoint; 
    begin 
      PixelsPerInch.y := GetDeviceCaps(Printer.Handle, LOGPIXELSY); 
      PixelsPerInch.x := GetDeviceCaps(Printer.Handle, LOGPIXELSX); 
      Escape(Printer.Handle, GETPHYSPAGESIZE, 0, nil, @PhysPageSize); 
      Escape(Printer.Handle, GETPRINTINGOFFSET, 0, nil, @OffsetStart); 
      PageRes.y := GetDeviceCaps(Printer.Handle, VERTRES); 
      PageRes.x := GetDeviceCaps(Printer.Handle, HORZRES); 
      // Top Margin 
      Margins.Top := OffsetStart.y / PixelsPerInch.y; 
      // Left Margin 
      Margins.Left := OffsetStart.x / PixelsPerInch.x; 
      // Bottom Margin 
      Margins.Bottom := ((PhysPageSize.y - PageRes.y) / PixelsPerInch.y) - 
        (OffsetStart.y / PixelsPerInch.y); 
      // Right Margin 
      Margins.Right := ((PhysPageSize.x - PageRes.x) / PixelsPerInch.x) - 
        (OffsetStart.x / PixelsPerInch.x); 
    end; 
     
    function InchToCm(Pixel: Single): Single; 
    // Convert inch to Centimeter 
    begin 
      Result := Pixel * 2.54 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      Margins: TMargins; 
    begin 
     GetPrinterMargins(Margins); 
     ShowMessage(Format('Margins: (Left: %1.3f, Top: %1.3f, Right: %1.3f, Bottom: %1.3f)', 
      [InchToCm(Margins.Left), 
       InchToCm(Margins.Top), 
       InchToCm(Margins.Right), 
       InchToCm(Margins.Bottom)])); 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
