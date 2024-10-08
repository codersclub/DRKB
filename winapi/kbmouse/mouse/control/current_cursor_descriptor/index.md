---
Title: Получить дескриптор текущего курсора
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Получить дескриптор текущего курсора
====================================

    { 
      The GetCursor() API is limited in that it does not, by default, return a handle to the current 
      cursor when that cursor is owned by another thread. This article demonstrates a way to retrieve 
      the current cursor regardless of what thread owns it. 
      For example, when you wish to include the image of the cursor in a screen capture. 
    }
     
     
    function GetCursorHandle: HCURSOR;
    var
      hWindow: HWND;
      pt: TPoint;
      pIconInfo: TIconInfo;
      dwThreadID, dwCurrentThreadID: DWORD;
    begin
      // Find out which window owns the cursor 
      // Das zum Mauszeiger zugehцrige Fenster finden 
      GetCursorPos(pt);
      hWindow := WindowFromPoint(pt);
     
      // Get the thread ID for the cursor owner. 
      // Thread ID des Fensters ermitteln 
      dwThreadID := GetWindowThreadProcessId(hWindow, nil);
     
      // Get the thread ID for the current thread 
      // Thread ID fьr den aktuellen Thread ermitteln 
      dwCurrentThreadID := GetCurrentThreadId;
     
      // If the cursor owner is not us then we must attach to 
      // the other thread in so that we can use GetCursor() to 
      // return the correct hCursor 
     
      // Wenn der Mauszeiger zu einem anderen Thread gehцrt, mьssen wir 
      // an den anderen Thread anhдngen. 
     
      if (dwCurrentThreadID <> dwThreadID) then
      begin
        if AttachThreadInput(dwCurrentThreadID, dwThreadID, True) then
        begin
          // Das Handle des Mauszeigers ermitteln 
          // Get the handle to the cursor 
          Result := GetCursor;
          AttachThreadInput(dwCurrentThreadID, dwThreadID, False);
        end;
      end else
      begin
        Result := GetCursor;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      CurPosX, CurPoxY: Integer;
      MyCursor: TIcon;
      pIconInfo: TIconInfo;
    begin
      MyCursor := TIcon.Create;
      try
        MyCursor.Handle := GetCursorHandle;
        // Retrieves information about the specified cursor. 
        // Informationen ьber den Mauszeiger auslesen 
        GetIconInfo(MyCursor.Handle, pIconInfo);
        CurPosX := pIconInfo.xHotspot;
        CurPoxY := pIconInfo.yHotspot;
        // Draw the Cursor on the form 
        // Den Mauszeiger auf die Form zeichnen 
        Canvas.Draw(CurPoxY, CurPoxY, MyCursor);
      finally
        MyCursor.ReleaseHandle;
        MyCursor.Free;
      end;
    end;
    
    // Another Solution: 
    // Andere Mцglichkeit: 
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      CI: TCursorInfo;
    begin
      CI.cbSize := SizeOf(CI);
      GetCursorInfo(CI);
      Image1.Picture.Icon.Handle := CI.hCursor;
    end;
