---
Title: Как определить, насколько долго система находится в Idle?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Как определить, насколько долго система находится в Idle?
=========================================================

    function LastInput: DWord;
    var
      LInput: TLastInputInfo;
    begin
      LInput.cbSize := SizeOf(TLastInputInfo);
      GetLastInputInfo(LInput);
      Result := GetTickCount - LInput.dwTime;
    end;
     
     
    //Example:
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      Label1.Caption := Format('System Idle since %d ms', [LastInput]);
    end;
     
     
    // The GetLastInputInfo function retrieves the time
    // of the last input event.
    // Minimum operating systems: Windows 2000

