---
Title: Проверить приложение на зависание
Author: Thomas Stutz
Date: 01.01.2000
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Проверить приложение на зависание
=================================

    // 1. The Documented way
     
    {
      An application can check if a window is responding to messages by
      sending the WM_NULL message with the SendMessageTimeout function.
    }
     
    function AppIsResponding(ClassName: string): Boolean;
    const
      { Specifies the duration, in milliseconds, of the time-out period }
      TIMEOUT = 50;
    var
      Res: DWORD;
      h: HWND;
    begin
      h := FindWindow(PChar(ClassName), nil);
      if h <> 0 then
        Result := SendMessageTimeOut(H,
          WM_NULL,
          0,
          0,
          SMTO_NORMAL or SMTO_ABORTIFHUNG,
          TIMEOUT,
          Res) <> 0
      else
        ShowMessage(Format('%s not found!', [ClassName]));
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if AppIsResponding('OpusApp') then
        { OpusApp is the Class Name of WINWORD }
        ShowMessage('App. responding');
    end;

    // 2. The Undocumented way
     
    {
      // Translated form C to Delphi by Thomas Stutz
      // Original Code:
      // (c)1999 Ashot Oganesyan K, SmartLine, Inc
      // mailto:ashot@aha.ru, http://www.protect-me.com, http://www.codepile.com
     
     The code doesn't use the Win32 API SendMessageTimout function to
     determine if the target application is responding but calls
     undocumented functions from the User32.dll.
     
     --> For NT/2000/XP the IsHungAppWindow() API:
     
     The function IsHungAppWindow retrieves the status (running or not responding)
     of the specified application
     
     IsHungAppWindow(Wnd: HWND): // handle to main app's window
     BOOL;
     
     --> For Windows 95/98/ME we call the IsHungThread() API
     
     The function IsHungThread retrieves the status (running or not responding) of
     the specified thread
     
     IsHungThread(DWORD dwThreadId): // The thread's identifier of the main app's window
     BOOL;
     
     Unfortunately, Microsoft doesn't provide us with the exports symbols in the
     User32.lib for these functions, so we should load them dynamically using the
     GetModuleHandle and GetProcAddress functions:
    }
     
    // For Win9X/ME
    function IsAppRespondig9X(dwThreadId: DWORD): Boolean;
    type
      TIsHungThread = function(dwThreadId: DWORD): BOOL; stdcall;
    var
      hUser32: THandle;
      IsHungThread: TIsHungThread;
    begin
      Result := True;
      hUser32 := GetModuleHandle('user32.dll');
      if (hUser32 > 0) then
      begin
        @IsHungThread := GetProcAddress(hUser32, 'IsHungThread');
        if Assigned(IsHungThread) then
        begin
          Result := not IsHungThread(dwThreadId);
        end;
      end;
    end;
     
    // For Win NT/2000/XP
    function IsAppRespondigNT(wnd: HWND): Boolean;
    type
      TIsHungAppWindow = function(wnd:hWnd): BOOL; stdcall;
    var
      hUser32: THandle;
      IsHungAppWindow: TIsHungAppWindow;
    begin
      Result := True;
      hUser32 := GetModuleHandle('user32.dll');
      if (hUser32 > 0) then
      begin
        @IsHungAppWindow := GetProcAddress(hUser32, 'IsHungAppWindow');
        if Assigned(IsHungAppWindow) then
        begin
          Result := not IsHungAppWindow(wnd);
        end;
      end;
    end;
     
    function IsAppRespondig(Wnd: HWND): Boolean;
    begin
     if not IsWindow(Wnd) then
     begin
       ShowMessage('Incorrect window handle!');
       Exit;
     end;
     if Win32Platform = VER_PLATFORM_WIN32_NT then
       Result := IsAppRespondigNT(wnd)
     else
       Result := IsAppRespondig9X(GetWindowThreadProcessId(Wnd,nil));
    end;
     
    // Example: Check if Word is hung/responding
     
    procedure TForm1.Button3Click(Sender: TObject);
    var
      Res: DWORD;
      h: HWND;
    begin
      // Find Winword by classname
      h := FindWindow(PChar('OpusApp'), nil);
      if h <> 0 then
      begin
        if IsAppRespondig(h) then
          ShowMessage('Word is responding!')
        else
          ShowMessage('Word is not responding!');
      end
      else
        ShowMessage('Word is not open!');
    end;

