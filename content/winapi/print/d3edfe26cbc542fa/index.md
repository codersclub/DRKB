---
Title: Печать в порт принтера
Date: 01.01.2007
---

Печать в порт принтера
======================

::: {.date}
01.01.2007
:::

{1.}

    procedure TForm1.Button1Click(Sender: TObject);
    var
      port, prnfile: file;
      buffer: array [1..128] of Char;
      Read: Integer;
    begin
      // Specify a file to print
      AssignFile(prnfile, 'filetoprint');
      Reset(prnfile, 1);
      // specify printer port
      AssignFile(port, 'LPT1');
      Rewrite(port, 1);
      repeat
        BlockRead(prnfile, buffer, SizeOf(buffer), Read);
        BlockWrite(port, buffer, Read);
        // Application.ProcessMessages;
      until EOF(prnfile) or (Read <> SizeOf(buffer));
      CloseFile(prnfile);
      CloseFile(port);
    end;

{2.}

    {
      Question:
      How do I write a raw string of a data to the printer?
     
      The following unit "PrtRaw.pas" demonstrates a 16/32 bit
      raw printing unit for Delphi and Borland C Builder.
     
      Following the unit, is an exmaple on using the
      PrtRaw unit.
     
      Notes:
     
      1) You are responsible for embedding all necessary
      control codes that the printer may require (including
      form feed codes).
     
      2) You must specify a valid printer and port name.
     
    }
     
    unit PrtRaw;
     
    {Copyright (c) 1998 by Joe C. Hecht - All rights Reserved}
    {joehecht@gte.net You may use and share this unit}
    {providing my name and the copyright notice stays intact.}
     
    interface
     
    uses
      WinTypes;
     
    {$IFDEF WIN32}
     type SpoolInt = DWORD;
    {$ELSE}
     type SpoolInt = integer;
    {$ENDIF}
     
    function StartRawPrintJob(PrinterName : pChar;
                              Port : pChar;
                              DocName : pChar) : THandle;
     
    function StartRawPrintPage(hPrn : THandle) : integer;
     
    function PrintRawData(hPrn : THandle;
                          Buffer : pointer;
                          NumBytes : SpoolInt) : integer;
     
    function EndRawPrintPage(hPrn : THandle) : integer;
     
    function EndRawPrintJob(hPrn : THandle) : integer;
     
     
    implementation
     uses
       WinProcs,
    {$IFDEF WIN32}
     WinSpool;
    {$ELSE}
     Print;
    {$ENDIF}
     
     
    function StartRawPrintJob(PrinterName : pChar;
                              Port : pChar;
                              DocName : pChar) : THandle;
    {$IFDEF WIN32}
     var
       hPrn : THandle;
       DocInfo1 : TDocInfo1;
    {$ENDIF}
    begin
     {$IFDEF WIN32}
       if (OpenPrinter(PChar(PrinterName),
                       hPrn,
                       nil) = FALSE)  then
       begin
         Result := THandle(-1);
         Exit;
       end;
       DocInfo1.pDocName := DocName;
       DocInfo1.pOutputFile := Port;
       DocInfo1.pDataType := 'RAW';
       if (StartDocPrinter(hPrn,
                           1,
                           @DocInfo1) = 0) then
       begin
         Result := THandle(-1);
         Exit;
       end;
       Result := hPrn;
     {$ELSE}
      result := OpenJob(Port,
                        DocName,
                        0);
     {$ENDIF}
    end;
     
    function StartRawPrintPage(hPrn : THandle) : integer;
    begin
     {$IFDEF WIN32}
       if (StartPagePrinter(hPrn) = FALSE) then
       begin
         Result := -1;
         Exit;
       end;
       result := 1;
     {$ELSE}
      result := StartSpoolPage(hPrn);
     {$ENDIF}
    end;
     
     
    function PrintRawData(hPrn : THandle;
                          Buffer : pointer;
                          NumBytes : SpoolInt) : integer;
    {$IFDEF WIN32}
    var
      BytesWritten : DWORD;
     {$ENDIF}
    begin
      if (NumBytes = 0) then
      begin
        Result := 1;
        Exit;
      end;
     {$IFDEF WIN32}
       if (WritePrinter(hPrn,
                        Buffer,
                        NumBytes,
                        BytesWritten) = FALSE) then
       begin
         Result := -1;
         Exit;
       end;
       if (NumBytes <> BytesWritten) then
       begin
         Result := -1;
         Exit;
       end;
       Result := 1;
     {$ELSE}
      result := WriteSpool(hPrn,
                           Buffer,
                           NumBytes);
     {$ENDIF}
    end;
     
     
    function EndRawPrintPage(hPrn : THandle) : integer;
    begin
     {$IFDEF WIN32}
       if (EndPagePrinter(hPrn) = FALSE) then
       begin
         Result := -1;
         Exit;
       end;
       Result := 1;
     {$ELSE}
      result := EndSpoolPage(hPrn);
     {$ENDIF}
    end;
     
     
    function EndRawPrintJob(hPrn : THandle) : integer;
    begin
     {$IFDEF WIN32}
       if (EndDocPrinter(hPrn) = FALSE) then
       begin
         Result := -1;
         Exit;
       end;
       if (ClosePrinter(hPrn) = FALSE) then
       begin
         Result := -1;
         Exit;
       end;
       Result := 1;
     {$ELSE}
      result := CloseJob(hPrn);
     {$ENDIF}
    end;
     
     
    end.

// Example of use:

    uses
      PrtRaw;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      hPrn : THandle;
      Data : array[0..31] of char;
    begin
     
      hPrn := StartRawPrintJob('Generic / Text Only',
                               'LPT1:',
                               'My Document');
      if (integer(hPrn) < 0) then
      begin
        ShowMessage('StartRawPrintJob Failed');
        Exit;
      end;
     
      if (StartRawPrintPage(hPrn) < 0) then
      begin
        ShowMessage('StartRawPrintPage Failed');
        EndRawPrintJob(hPrn);
        Exit;
      end;
     
      Data[0] := 'P';
      Data[1] := 'a';
      Data[2] := 'g';
      Data[3] := 'e';
      Data[4] := #32;
      Data[5] := '1';
      Data[6] := #13;
      Data[7] := #10;
     
      if (PrintRawData(hPrn,
                       @data,
                       8) < 0) then
      begin
        ShowMessage('PrintRawData Failed');
        EndRawPrintPage(hPrn);
        EndRawPrintJob(hPrn);
        Exit;
      end;
     
      if (EndRawPrintPage(hPrn) < 0) then
      begin
        ShowMessage('EndRawPrintPage Failed');
        EndRawPrintJob(hPrn);
        Exit;
      end;
     
      if (StartRawPrintPage(hPrn) < 0) then
      begin
        ShowMessage('StartRawPrintPage Failed');
        EndRawPrintJob(hPrn);
        Exit;
      end;
      Data[0] := 'P';
      Data[1] := 'a';
      Data[2] := 'g';
      Data[3] := 'e';
      Data[4] := #32;
      Data[5] := '2';
      Data[6] := #13;
      Data[7] := #10;
     
      if (PrintRawData(hPrn,
                       @data,
                       8) < 0) then
                       begin
        ShowMessage('PrintRawData Failed');
        EndRawPrintPage(hPrn);
        EndRawPrintJob(hPrn);
        Exit;
      end;
     
      if (EndRawPrintPage(hPrn) < 0) then
      begin
        ShowMessage('EndRawPrintPage Failed');
        EndRawPrintJob(hPrn);
        Exit;
      end;
     
      if (EndRawPrintJob(hPrn) < 0) then
      begin
        ShowMessage('EndRawPrintJob Failed');
        Exit;
      end;
     
    end;
     
    end.

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
