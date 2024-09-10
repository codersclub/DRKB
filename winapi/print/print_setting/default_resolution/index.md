---
Title: Как получить разрешение принтера по умолчанию?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Как получить разрешение принтера по умолчанию?
==============================================

    uses 
      Printers; 
     
    function GetPixelsPerInchX: Integer; 
    begin 
      Result := GetDeviceCaps(Printer.Handle, LOGPIXELSX) 
    end; 
     
    function GetPixelsPerInchY: Integer; 
    begin 
      Result := GetDeviceCaps(Printer.Handle, LOGPIXELSY) 
    end; 
     
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Caption := Format('x: %d y: %d DPI (dots per inch)', 
                       [GetPixelsPerInchX, GetPixelsPerInchY]); 
    end; 

