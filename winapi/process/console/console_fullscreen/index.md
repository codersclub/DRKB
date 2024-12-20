---
Title: Переключение консольного приложения в полный экран
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Переключение консольного приложения в полный экран
==================================================

    { 
       There is no documented way to make a console application fullscreen. 
       The following code works for both NT and Win9x. 
       For win NT I used the undocumented SetConsoleDisplayMode and 
       GetConsoleDisplayMode functions. 
    } 
     
    { 
     function GetConsoleDisplayMode(var lpdwMode: DWORD): BOOL; stdcall; 
       external 'kernel32.dll'; 
      // lpdwMode: address of variable for current value of display mode 
    } 
     
    function NT_GetConsoleDisplayMode(var lpdwMode: DWORD): Boolean; 
    type 
      TGetConsoleDisplayMode = function(var lpdwMode: DWORD): BOOL; 
      stdcall; 
    var 
      hKernel: THandle; 
      GetConsoleDisplayMode: TGetConsoleDisplayMode; 
    begin 
      Result := False; 
      hKernel := GetModuleHandle('kernel32.dll'); 
      if (hKernel > 0) then 
      begin @GetConsoleDisplayMode := 
          GetProcAddress(hKernel, 'GetConsoleDisplayMode'); 
        if Assigned(GetConsoleDisplayMode) then 
        begin 
          Result := GetConsoleDisplayMode(lpdwMode); 
        end; 
      end; 
    end; 
     
    { 
      function SetConsoleDisplayMode(hOut: THandle; // standard output handle 
      dwNewMode: DWORD;         // specifies the display mode 
      var lpdwOldMode: DWORD    // address of variable for previous value of display mode 
      ): BOOL; stdcall; external 'kernel32.dll'; 
    } 
     
    function NT_SetConsoleDisplayMode(hOut: THandle; dwNewMode: DWORD; 
      var lpdwOldMode: DWORD): Boolean; 
    type 
      TSetConsoleDisplayMode = function(hOut: THandle; dwNewMode: DWORD; 
      var lpdwOldMode: DWORD): BOOL; 
      stdcall; 
    var 
      hKernel: THandle; 
      SetConsoleDisplayMode: TSetConsoleDisplayMode; 
    begin 
      Result := False; 
      hKernel := GetModuleHandle('kernel32.dll'); 
      if (hKernel > 0) then 
      begin
        @SetConsoleDisplayMode := GetProcAddress(hKernel, 'SetConsoleDisplayMode'); 
        if Assigned(SetConsoleDisplayMode) then 
        begin 
          Result := SetConsoleDisplayMode(hOut, dwNewMode, lpdwOldMode); 
        end; 
      end; 
    end; 
     
    function GetConsoleWindow: THandle; 
    var 
      S: AnsiString; 
      C: Char; 
    begin 
      Result := 0; 
      Setlength(S, MAX_PATH + 1); 
      if GetConsoleTitle(PChar(S), MAX_PATH) <> 0 then 
      begin 
        C := S[1]; 
        S[1] := '$'; 
        SetConsoleTitle(PChar(S)); 
        Result := FindWindow(nil, PChar(S)); 
        S[1] := C; 
        SetConsoleTitle(PChar(S)); 
      end; 
    end; 
     
    function SetConsoleFullScreen(bFullScreen: Boolean): Boolean; 
    const 
      MAGIC_CONSOLE_TOGGLE = 57359; 
    var 
      dwOldMode: DWORD; 
      dwNewMode: DWORD; 
      hOut: THandle; 
      hConsole: THandle; 
    begin 
      if Win32Platform = VER_PLATFORM_WIN32_NT then 
      begin 
        dwNewMode := Ord(bFullScreen); 
        NT_GetConsoleDisplayMode(dwOldMode); 
        hOut := GetStdHandle(STD_OUTPUT_HANDLE); 
        Result := NT_SetConsoleDisplayMode(hOut, dwNewMode, dwOldMode); 
      end 
      else 
      begin 
        hConsole := GetConsoleWindow; 
        Result := hConsole <> 0; 
        if Result then 
        begin 
          if bFullScreen then 
          begin 
            SendMessage(GetConsoleWindow, WM_COMMAND, MAGIC_CONSOLE_TOGGLE, 0); 
          end 
          else 
          begin 
            // Better solution than keybd_event under Win9X ? 
            keybd_event(VK_MENU, MapVirtualKey(VK_MENU, 0), 0, 0); 
            keybd_event(VK_RETURN, MapVirtualKey(VK_RETURN, 0), 0, 0); 
            keybd_event(VK_RETURN, MapVirtualKey(VK_RETURN, 0), KEYEVENTF_KEYUP, 0); 
            keybd_event(VK_MENU, MapVirtualKey(VK_MENU, 0), KEYEVENTF_KEYUP, 0); 
          end; 
        end; 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      s: string; 
    begin 
      AllocConsole; 
      try 
        SetConsoleFullScreen(True); 
        Write('Hi, you are in full screen mode now. Type something [Return]: '); 
        Readln(s); 
        SetConsoleFullScreen(False); 
        // ShowMessage(Format('You typed: "%s"', [s])); 
      finally 
        FreeConsole; 
      end; 
    end;

