---
Title: Как получить screen shot экран вместе с указателем мыша?
Date: 01.01.2007
---


Как получить screen shot экран вместе с указателем мыша?
========================================================

Вариант 1:

Author: P.O.D

Source: <https://forum.sources.ru>

надо его вручную дорисовать

    procedure GetScreenImage(bmp: TBitmap);
    var
      CI: TCursorInfo;
      Icon: TIcon;
      II: TIconInfo;
      r: TRect;
    begin
    bmp.Width:= Screen.Width;
    bmp.Height:= Screen.Height;
    BitBlt(bmp.Canvas.Handle,0,0,Screen.Width,Screen.Height,
    GetDC(GetDesktopWindow),0,0,SRCCopy);
    //дорисуем курсор
    Icon:=TIcon.Create;
    r:=Rect(0,0,GetSystemMetrics(SM_CXSCREEN),
                GetSystemMetrics(SM_CYSCREEN));
    CI.cbSize:=SizeOf(CI);
    if (GetCursorInfo(CI)) and (CI.flags=CURSOR_SHOWING) then
     begin
      Icon.Handle:=CopyIcon(CI.hCursor);
      if GetIconInfo(Icon.Handle,II) then
      bmp.Canvas.Draw(ci.ptScreenPos.x - Integer(II.xHotspot) - r.Left,
                      ci.ptScreenPos.y - Integer(II.yHotspot) - r.Top,
                      Icon);
     end;
    end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

    // 1. Get the handle to the current mouse-cursor and its position 
    function GetCursorInfo2: TCursorInfo;
    var
      hWindow: HWND;
      pt: TPoint;
      pIconInfo: TIconInfo;
      dwThreadID, dwCurrentThreadID: DWORD;
    begin
      Result.hCursor := 0;
      ZeroMemory(@Result, SizeOf(Result));
      // Find out which window owns the cursor 
      if GetCursorPos(pt) then
      begin
        Result.ptScreenPos := pt;
        hWindow := WindowFromPoint(pt);
        if IsWindow(hWindow) then
        begin
          // Get the thread ID for the cursor owner. 
          dwThreadID := GetWindowThreadProcessId(hWindow, nil);
     
          // Get the thread ID for the current thread 
          dwCurrentThreadID := GetCurrentThreadId;
     
          // If the cursor owner is not us then we must attach to 
          // the other thread in so that we can use GetCursor() to 
          // return the correct hCursor 
          if (dwCurrentThreadID <> dwThreadID) then
          begin
            if AttachThreadInput(dwCurrentThreadID, dwThreadID, True) then
            begin
              // Get the handle to the cursor 
              Result.hCursor := GetCursor;
              AttachThreadInput(dwCurrentThreadID, dwThreadID, False);
            end;
          end
          else
          begin
            Result.hCursor := GetCursor;
          end;
        end;
      end;
    end;
     
    // 2. Capture the screen 
    function CaptureScreen: TBitmap;
    var
      DC: HDC;
      ABitmap: TBitmap;
      MyCursor: TIcon;
      CursorInfo: TCursorInfo;
      IconInfo: TIconInfo;
    begin
      // Capture the Desktop screen 
      DC := GetDC(GetDesktopWindow);
      ABitmap := TBitmap.Create;
      try
        ABitmap.Width  := GetDeviceCaps(DC, HORZRES);
        ABitmap.Height := GetDeviceCaps(DC, VERTRES);
        // BitBlt on our bitmap 
        BitBlt(ABitmap.Canvas.Handle,
          0,
          0,
          ABitmap.Width,
          ABitmap.Height,
          DC,
          0,
          0,
          SRCCOPY);
        // Create temp. Icon 
        MyCursor := TIcon.Create;
        try
          // Retrieve Cursor info 
          CursorInfo := GetCursorInfo2;
          if CursorInfo.hCursor <> 0 then
          begin
            MyCursor.Handle := CursorInfo.hCursor;
            // Get Hotspot information 
            GetIconInfo(CursorInfo.hCursor, IconInfo);
            // Draw the Cursor on our bitmap 
            ABitmap.Canvas.Draw(CursorInfo.ptScreenPos.X - IconInfo.xHotspot,
                                CursorInfo.ptScreenPos.Y - IconInfo.yHotspot,
                                MyCursor);
          end;
        finally
          // Clean up 
          MyCursor.ReleaseHandle;
          MyCursor.Free;
        end;
      finally
        ReleaseDC(GetDesktopWindow, DC);
      end;
      Result := ABitmap;
    end;
     
    // Example: Capture the screen and include the cursor. 
    // Show the Screenshot in Image1 
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Image1.Picture.Assign(CaptureScreen);
    end;

