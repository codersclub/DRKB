---
Title: Does Delphi have an equivalent for the Visual Basic SendKeys function?
Date: 01.01.2007
---


Does Delphi have an equivalent for the Visual Basic SendKeys function?
======================================================================

The following example demonstrates procedures that provide the
capibility of sending keystrokes to any window control capable of
receiving keyboard input. You may use this technique to toggle the num
lock, caps lock, and scroll lock keys under Windows NT. This same
technique works for toggling caps lock and scroll lock keys under
Windows 95, but it will not work for num lock.

Note that there are four procedures provided: `SimulateKeyDown()`,
`SimulateKeyUp()`, `SimulateKeystroke()`, and `SendKeys()`, to allow greater
control in your ability to send keystrokes.

The SimulateKeyDown(), SimulateKeyUp(), and SimulateKeystroke()
procedures expect a virtural key code (like VK\_F1). The
SimulateKeystroke() procedure accepts an extra parameter that is useful
when simulating the PrintScreen key. When extra is set to zero, the
entire screen will be captured to the windows clipboard. When extra is
set to one, only the active window will be captured.

The four button click methods demonstrate the use of these functions:

- ButtonClick1 - Toggles the cap lock.
- ButtonClick2 - Captures the entire screen to the clipboard.
- ButtonClick3 - Capture the active window to the clipboard.
- ButtonClick4 - Set the focus to an edit control and sends it a string.

Example:

    procedure SimulateKeyDown(Key : byte);
    begin
      keybd_event(Key, 0, 0, 0);
    end;
     
    procedure SimulateKeyUp(Key : byte);
    begin
      keybd_event(Key, 0, KEYEVENTF_KEYUP, 0);
    end;
     
    procedure SimulateKeystroke(Key : byte; extra : DWORD);
    begin
      keybd_event(Key, extra, 0, 0);
      keybd_event(Key, extra, KEYEVENTF_KEYUP, 0);
    end;
     
    procedure SendKeys(s : string);
    var
      i : integer;
      flag : bool;
      w : word;
    begin
      {Get the state of the caps lock key}
      flag := not GetKeyState(VK_CAPITAL) and 1 = 0;
      {If the caps lock key is on then turn it off}
      if flag then
        SimulateKeystroke(VK_CAPITAL, 0);
      for i := 1 to Length(s) do begin
        w := VkKeyScan(s[i]);
        {If there is not an error in the key translation}
        if ((HiByte(w)  $FF) and
           (LoByte(w)  $FF)) then begin
          {If the key requires the shift key down - hold it down}
          if HiByte(w) and 1 = 1 then
            SimulateKeyDown(VK_SHIFT);
          {Send the VK_KEY}
          SimulateKeystroke(LoByte(w), 0);
          {If the key required the shift key down - release it}
          if HiByte(w) and 1 = 1 then
            SimulateKeyUp(VK_SHIFT);
        end;
      end;
      {if the caps lock key was on at start, turn it back on}
      if flag then
        SimulateKeystroke(VK_CAPITAL, 0);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      {Toggle the cap lock}
      SimulateKeystroke(VK_CAPITAL, 0);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      {Capture the entire screen to the clipboard}
      {by simulating pressing the PrintScreen key}
      SimulateKeystroke(VK_SNAPSHOT, 0);
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      {Capture the active window to the clipboard}
      {by simulating pressing the PrintScreen key}
      SimulateKeystroke(VK_SNAPSHOT, 1);
    end;
     
    procedure TForm1.Button4Click(Sender: TObject);
    begin
      {Set the focus to a window (edit control) and send it a string}
      Application.ProcessMessages;
      Edit1.SetFocus;
      SendKeys('Delphi Is RAD!');
    end;
