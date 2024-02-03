---
Title: Как прочитать очередь печати?
Date: 01.01.2007
---

Как прочитать очередь печати?
=============================

::: {.date}
01.01.2007
:::

    uses 
      Winspool, Printers; 
     
    function GetCurrentPrinterHandle: THandle; 
    var 
      Device, Driver, Port: array[0..255] of Char; 
      hDeviceMode: THandle; 
    begin 
      Printer.GetPrinter(Device, Driver, Port, hDeviceMode); 
      if not OpenPrinter(@Device, Result, nil) then 
        RaiseLastWin32Error; 
    end; 
     
    function SavePChar(p: PChar): PChar; 
    const 
      error: PChar = 'Nil'; 
    begin 
      if not Assigned(p) then 
        Result := error 
      else 
        Result := p; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    type 
      TJobs  = array [0..1000] of JOB_INFO_1; 
      PJobs = ^TJobs; 
    var 
      hPrinter: THandle; 
      bytesNeeded, numJobs, i: Cardinal; 
      pJ: PJobs; 
    begin 
      hPrinter := GetCurrentPrinterHandle; 
      try 
        EnumJobs(hPrinter, 0, 1000, 1, nil, 0, bytesNeeded, 
          numJobs); 
        pJ := AllocMem(bytesNeeded); 
        if not EnumJobs(hPrinter, 0, 1000, 1, pJ, bytesNeeded, 
          bytesNeeded, numJobs) then 
          RaiseLastWin32Error; 
     
        memo1.Clear; 
        if numJobs = 0 then 
          memo1.Lines.Add('No jobs in queue') 
        else 
          for i := 0 to Pred(numJobs) do 
            memo1.Lines.Add(Format('Printer %s, Job %s, Status (%d): %s', 
              [SavePChar(pJ^[i].pPrinterName), SavePChar(pJ^[i].pDocument), 
              pJ^[i].Status, SavePChar(pJ^[i].pStatus)])); 
      finally 
        ClosePrinter(hPrinter); 
      end; 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
