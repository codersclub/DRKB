---
Title: Как изменить порт для принтера?
Date: 01.01.2007
---

Как изменить порт для принтера?
===============================

::: {.date}
01.01.2007
:::

    uses
      WinSpool;
     
    { Function SetPrinterToPort
      Parameters :
        hPrinter: handle of printer to change, obtained from OpenPrinter
        port: port name to use, e.g. LPT1:, COM1:, FILE:
      Returns:
        The name of the previous port the printer was attached to.
      Description:
        Changes the port a printer is attached to using Win32 API functions.
                    The changes made are NOT local to this process, they will affect all 
                    other processes that try to use this printer! It is recommended to set the 
                    port back to the old port returned by this function after 
                    the end of the print job.
      Error Conditions:
       Will raise EWin32Error exceptions if SetPrinter or GetPrinter fail.
      Created:
        21.10.99 by P. Below}
     
    function SetPrinterToPort(hPrinter: THandle; const port: string): string;
    var
      pInfo: PPrinterInfo2;
      bytesNeeded: DWORD;
    begin
      {Figure out how much memory we need for the data buffer. Note that GetPrinter is
      supposed to fail with a specific error code here. The amount of memory will 
            be larger than Sizeof(TPrinterInfo2) since variable amounts of data are appended 
            to the record}
      SetLastError(NO_ERROR);
      GetPrinter(hPrinter, 2, nil, 0, @bytesNeeded);
      if GetLastError <> ERROR_INSUFFICIENT_BUFFER then
        RaiseLastWin32Error;
      pInfo := AllocMem(bytesNeeded);
      try
        if not GetPrinter(hPrinter, 2, pInfo, bytesNeeded, @bytesNeeded) then
          RaiseLastWin32Error;
        with pInfo^ do
        begin
          Result := pPortname;
          pPortname := @port[1];
        end;
        if not SetPrinter(hPrinter, 2, pInfo, 0) then
          RaiseLastWin32Error;
      finally
        FreeMem(pInfo);
      end;
    end;
     
    function GetCurrentPrinterHandle: THandle;
    var
      Device, Driver, Port: array[0..255] of char;
      hDeviceMode: THandle;
    begin
      Printer.GetPrinter(Device, Driver, Port, hDeviceMode);
      if not OpenPrinter(@Device, Result, nil) then
        RaiseLastWin32Error;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------

     
    uses Printers;
     
    {$IFNDEF WIN32}
    const MAX_PATH = 144;
    {$ENDIF}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      pDevice: pChar;
      pDriver: pChar;
      pPort: pChar;
      hDMode: THandle;
      PDMode: PDEVMODE;
    begin
      if PrintDialog1.Execute then
      begin
        GetMem(pDevice, cchDeviceName);
        GetMem(pDriver, MAX_PATH);
        GetMem(pPort, MAX_PATH);
        Printer.GetPrinter(pDevice, pDriver, pPort, hDMode);
        Printer.SetPrinter(pDevice, PDriver, 'FILE:', hDMode);
        FreeMem(pDevice, cchDeviceName);
        FreeMem(pDriver, MAX_PATH);
        FreeMem(pPort, MAX_PATH);
        Printer.BeginDoc;
        Printer.Canvas.TextOut(100, 100, 'Delphi World Is Wonderful!');
        Printer.EndDoc;
      end;
    end;

Взято с <https://delphiworld.narod.ru>
