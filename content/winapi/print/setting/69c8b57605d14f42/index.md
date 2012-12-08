---
Title: Как получить разрешение принтера по умолчанию?
Date: 01.01.2007
---

Как получить разрешение принтера по умолчанию?
==============================================

::: {.date}
01.01.2007
:::

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

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
