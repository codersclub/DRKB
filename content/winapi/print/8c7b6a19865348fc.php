<h1>Как распечатать PRN?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  Printers, Winspool; 
 
function SpoolFile(const FileName, PrinterName: string): Integer; 
var 
  Buffer: record 
    JobInfo: record // ADDJOB_INFO_1 
      Path: PChar; 
      JobID: DWORD; 
    end; 
    PathBuffer: array[0..255] of Char; 
  end; 
  SizeNeeded: DWORD; 
  Handle: THandle; 
  PrtName: string; 
  ok: Boolean; 
begin 
  // Flush job to printer 
  PrtName := PrinterName; 
  if PrtName = '' then 
    PrtName := Printer.Printers[Printer.PrinterIndex]; // Default printer name 
  ok := False; 
  if OpenPrinter(PChar(PrtName), Handle, nil) then 
    if AddJob(Handle, 1, @Buffer, SizeOf(Buffer), SizeNeeded) then 
      if CopyFile(PChar(FileName), Buffer.JobInfo.Path, True) then 
        if ScheduleJob(Handle, Buffer.JobInfo.JobID) then 
          ok := True; 
  if not ok then Result := GetLastError 
  else  
    Result := 0; 
end; 
 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  if SpoolFile('c:\test.prn', Printer.Printers[0]) = 0 then 
    ShowMessage('No error...'); 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
