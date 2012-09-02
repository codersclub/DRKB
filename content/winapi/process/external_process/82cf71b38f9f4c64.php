<h1>How to patch a process?</h1>
<div class="date">01.01.2007</div>


<pre>
{....}
 
var
  WindowName: Integer;
  ProcessId: Integer;
  ThreadId: Integer;
  buf: PChar;
  HandleWindow: Integer;
  Write: Cardinal;
 
{....}
 
const
  WindowTitle = 'a program name';
  Address = $A662D6;
  PokeValue = $4A;
  NumberOfBytes = 2;
 
{....}
 
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  WindowName := FindWindow(nil, WindowTitle);
 
  if WindowName = 0 then
  begin
    MessageDlg('Program not running.', mtWarning, [mbOK], 0);
  end;
 
  ThreadId := GetWindowThreadProcessId(WindowName, @ProcessId);
  HandleWindow := OpenProcess(PROCESS_ALL_ACCESS, False, ProcessId);
 
  GetMem(buf, 1);
  buf^ := Chr(PokeValue);
  WriteProcessMemory(HandleWindow, ptr(Address), buf, NumberOfBytes, Write);
  FreeMem(buf);
  CloseHandle(HandleWindow);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
