---
Title: How to patch a process?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

How to patch a process?
=======================

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

