---
Title: Как прочитать название порта принтера?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---

Как прочитать название порта принтера?
======================================

    { ... }
     
    uses
      printers, winspool;
     
    function GetCurrentPrinterHandle: THandle;
    const
      Defaults: TPrinterDefaults = (pDatatype: nil; pDevMode: nil; DesiredAccess:
        PRINTER_ACCESS_USE or PRINTER_ACCESS_ADMINISTER);
    var
      Device, Driver, Port: array[0..255] of char;
      hDeviceMode: THandle;
    begin
      Printer.GetPrinter(Device, Driver, Port, hDeviceMode);
      if not OpenPrinter(@Device, Result, @Defaults) then
        RaiseLastWin32Error;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
     
      procedure Display(const prefix: string; S: PChar);
      begin
        memo1.lines.add(prefix + string(S));
      end;
     
    var
      pInfo: PPrinterInfo2;
      bytesNeeded: DWORD;
      hPrinter: THandle;
      i: Integer;
    begin
      for i := 0 to printer.Printers.Count - 1 do
      begin
        Printer.PrinterIndex := i;
        hPrinter := GetCurrentPrinterHandle;
        try
          GetPrinter(hPrinter, 2, nil, 0, @bytesNeeded);
          pInfo := AllocMem(bytesNeeded);
          try
            GetPrinter(hPrinter, 2, pInfo, bytesNeeded, @bytesNeeded);
            Display('ServerName: ', pInfo^.pServerName);
            Display('PrinterName: ', pInfo^.pPrinterName);
            Display('ShareName: ', pInfo^.pShareName);
            Display('PortName: ', pInfo^.pPortName);
          finally
            FreeMem(pInfo);
          end;
        finally
          ClosePrinter(hPrinter);
        end;
      end;
    end;

