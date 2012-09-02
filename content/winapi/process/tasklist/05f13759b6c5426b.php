<h1>Как узнать количество памяти, используемое процессом?</h1>
<div class="date">01.01.2007</div>


<pre>
// Works only on Windows NT systems (WinNT, Win2000, WinXP)
uses psAPI;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  pmc: PPROCESS_MEMORY_COUNTERS;
  cb: Integer;
begin
  cb := SizeOf(_PROCESS_MEMORY_COUNTERS);
  GetMem(pmc, cb);
  pmc^.cb := cb;
  if GetProcessMemoryInfo(GetCurrentProcess(), pmc, cb) then
    Label1.Caption := IntToStr(pmc^.WorkingSetSize) + ' Bytes'
  else
    Label1.Caption := 'Unable to retrieve memory usage structure';
 
  FreeMem(pmc);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
