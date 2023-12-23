---
Title: Как очистить очередь печати принтера?
Author: Rouse\_
Date: 01.01.2007
---

Как очистить очередь печати принтера?
=====================================

::: {.date}
01.01.2007
:::

    uses ..., WinSpool;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      PrintersInfo, TmpPrintersInfo: PPrinterInfo1;
      pcbNeeded, pcReturned, jpcbNeeded, jpcReturned: DWORD;
      I, J: Integer;
      hPrinter: THandle;
      JobInfo, TmpJobInfo: PJobInfo3;
    begin
      EnumPrinters(PRINTER_ENUM_LOCAL, nil, 1, PrintersInfo, 0, pcbNeeded,  pcReturned);
      if GetLastError = ERROR_INSUFFICIENT_BUFFER then
      begin
        GetMem(PrintersInfo, pcbNeeded);
        try
          if EnumPrinters(PRINTER_ENUM_LOCAL, nil, 1,
            PrintersInfo, pcbNeeded, pcbNeeded,  pcReturned) then
          begin
            TmpPrintersInfo := PrintersInfo;
            for I := 0 to pcReturned - 1 do
            begin
              if OpenPrinter(TmpPrintersInfo^.pName, hPrinter, nil) then
              begin
                EnumJobs(hPrinter, 0, 100, 1, nil,
                  0, jpcbNeeded, jpcReturned);
                if GetLastError in [NO_ERROR, ERROR_INSUFFICIENT_BUFFER] then
                begin
                  GetMem(JobInfo, jpcbNeeded);
                  try
                    if EnumJobs(hPrinter, 0, 100, 3, JobInfo,
                      jpcbNeeded, jpcbNeeded, jpcReturned) then
                    begin
                      TmpJobInfo := JobInfo;
                      for J := 0 to jpcReturned - 1 do
                      begin
                        if not SetJob(hPrinter, TmpJobInfo^.JobId, 0,
                          nil, JOB_CONTROL_DELETE) then RaiseLastOSError;
                        Inc(TmpJobInfo);
                      end;
                    end
                    else
                      RaiseLastOSError;
                  finally
                    FreeMem(JobInfo);
                  end;
                end
                else
                  RaiseLastOSError;
              end
              else
                RaiseLastOSError;
              Inc(TmpPrintersInfo);
            end;
          end
          else
            RaiseLastOSError;
        finally
          FreeMem(PrintersInfo);
        end;
      end
      else
        RaiseLastOSError;
    end;

Взято из <https://forum.sources.ru>

Автор: Rouse\_

 
