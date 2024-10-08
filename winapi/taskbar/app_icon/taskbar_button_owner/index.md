---
Title: Получить дескриптор окна, которое владеет кнопками запущенных программ на панели задач
Date: 12.12.1999
Author: Ashot Oganesyan, ashot@aha.ru
Source: <https://www.swissdelphicenter.ch>
---

Получить дескриптор окна, которое владеет кнопками запущенных программ на панели задач
======================================================================================

    { 
      In this article, I wish to describe the useful undocumented function 
      GetTaskmanWindow. The GetTaskmanWindow function returns a handle to 
      the window that ownes the taskbar buttons. 
      Here is the quoting about taskbar from Microsoft MSDN: 
      "The Microsoft® Windows® interface includes a special application desktop 
      toolbar called the taskbar. 
      The taskbar can be used for such tasks as switching between open 
      windows and starting new applications..." 
      and "The taskbar includes the Start menu, taskbar buttons, 
      a shortcut menu, and a status area...". 
      Unfortunately, Win32 API doesn't contain documented 
      function that can be used for accessing to the 
      taskbar so we should again use an undocumented way. 
     
      Here is the prototype for GetTaskmanWindow: 
     
       function GetTaskmanWindow (): HWND; 
     
      As always, Microsoft doesn't provide us with the exports symbols 
      in the User32.lib for this function, so we should load them dynamically using the 
      GetProcAddress and GetModuleHandle functions: 
    }
     
    // getaskmanwnd.cpp (Windows NT/2000) 
    // 
    // This example will show you how you can obtain a handle to the 
    // Windows Taskbar window. 
    // Translated from C to Delphi by Thomas Stutz 
    // Original Code: 
    // (c)1999 Ashot Oganesyan K, SmartLine, Inc 
    // mailto:ashot@aha.ru, http://www.protect-me.com, http://www.codepile.com 
     
     
    function TaskmanWindow: HWND;
    type
      TGetTaskmanWindow = function(): HWND; stdcall;
    var
      hUser32: THandle;
      GetTaskmanWindow: TGetTaskmanWindow;
    begin
      Result := 0;
      hUser32 := GetModuleHandle('user32.dll');
      if (hUser32 > 0) then
      begin
        @GetTaskmanWindow := GetProcAddress(hUser32, 'GetTaskmanWindow');
        if Assigned(GetTaskmanWindow) then
        begin
          Result := GetTaskmanWindow;
        end;
      end;
    end;
    
    procedure ShowTaskmanWindow(bValue: Boolean);
    var
      hTaskmanWindow: Hwnd;
    begin
      hTaskmanWindow := TaskmanWindow;
      if hTaskmanWindow <> 0 then
      begin
        ShowWindow(GetParent(hTaskmanWindow), Ord(bValue));
      end;
    end;
    
    // Example to Hide the Taskman Window 
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowTaskmanWindow(False);
    end;

