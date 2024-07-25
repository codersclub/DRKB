---
Title: Как сделать форму активной (форма находится в DLL)?
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как сделать форму активной (форма находится в DLL)?
===================================================

    procedure ShowMainForm;

    var
      hWnd, hCurWnd, dwThreadID, dwCurThreadID: THandle;
      OldTimeOut: DWORD;
      AResult: Boolean;
    begin
      ShowWindow(Application.Handle, SW_RESTORE);
      Application.MainForm.Visible := True;   // Показываем главную форму
     
      // Ставим нашу форму впереди всех окон
      hWnd := Application.Handle;
      SystemParametersInfo(SPI_GETFOREGROUNDLOCKTIMEOUT, 0, @OldTimeOut, 0);
      SystemParametersInfo(SPI_SETFOREGROUNDLOCKTIMEOUT, 0, Pointer(0), 0);
      SetWindowPos(hWnd, HWND_TOPMOST, 0, 0, 0, 0, SWP_NOMOVE or SWP_NOSIZE);
      hCurWnd := GetForegroundWindow;
      AResult := False;
      while not AResult do
      begin
        dwThreadID := GetCurrentThreadId;
        dwCurThreadID := GetWindowThreadProcessId(hCurWnd);
        AttachThreadInput(dwThreadID, dwCurThreadID, True);
        AResult := SetForegroundWindow(hWnd);
        AttachThreadInput(dwThreadID, dwCurThreadID, False);
      end;
      SetWindowPos(hWnd, HWND_NOTOPMOST, 0, 0, 0, 0, SWP_NOMOVE or SWP_NOSIZE);
      SystemParametersInfo(SPI_SETFOREGROUNDLOCKTIMEOUT, 0, Pointer(OldTimeOut), 0); 
    end;

