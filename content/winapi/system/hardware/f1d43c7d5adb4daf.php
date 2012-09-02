<h1>Как получить информацию о системе?</h1>
<div class="date">01.01.2007</div>


<pre>
{
  The SYSTEM_INFO structure contains information about the current computer
  system. This includes the architecture and type of the processor, the number of
  processors in the system, the page size, and other such information.
}
 
procedure TForm1.Button1Click(Sender: TObject);
var
  SysInfo: TSystemInfo;
begin
  GetSystemInfo(SysInfo);
  with ListBox1.Items, SysInfo do
  begin
    Add('ProcessorArchitecture:' + IntToStr(wProcessorArchitecture));
    Add(FloatToStr(dwPageSize) + ' Kb page size');
    Add(Format('Lowest memory address accessible to applications and DLL - %p',
      [lpMinimumApplicationAddress]));
    Add(Format('Highest memory address accessible to applications and DLL - %p',
      [lpMaximumApplicationAddress]));
    Add('OEMID:' + IntToStr(dwOemId));
    Add('ActiveProcessorMask:' + IntToStr(dwActiveProcessorMask));
    Add(IntToStr(dwNumberOfProcessors) + ' - number of processors');
    Add('ProcessorType:' + IntToStr(dwProcessorType));
    case wProcessorLevel of
      3: Add('Intel 80386 processor level');
      4: Add('Intel 80486 processor level');
      5: Add('Intel Pentium processor level');
    end;
    Add(FloatToStr(dwAllocationGranularity / 1024) +
      ' Kb - granularity with which virtual memory is allocated');
    Add('ProcessorRevision:' + IntToStr(wProcessorRevision));
  end;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
