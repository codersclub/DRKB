---
Title: Получение имени модуля по хендлу окна
Author: Krid
Date: 01.01.2007
---

Получение имени модуля по хендлу окна
=====================================

::: {.date}
01.01.2007
:::

    function GetModuleFileNameExW(hProcess:THandle; hModule:HMODULE; lpFilename:PWideChar; nSize:DWORD):DWORD; stdcall; external 'PSAPI.DLL';
     
    function WindowGetEXE(wnd:HWND):string;
    var
     wt:array[0..MAX_PATH-1] of WChar;
     r:integer;
     prc:THandle;
     prcID:cardinal;
    begin
     result:='';
     if GetWindowThreadProcessID(wnd,prcID)<>0 then
     begin
      prc:=OpenProcess(PROCESS_ALL_ACCESS,false,prcID);
      if prc<>0 then
      try
       r:=GetModuleFileNameExW(prc,GetWindowLong(wnd,GWL_HINSTANCE),wt,MAX_PATH*2);
       if r=0 then r:=GetModuleFileNameExW(prc,0,wt,MAX_PATH*2);
       if r<>0 then result:=wt;
      finally
       CloseHandle(prc)
      end
     end
    end;
     
    function SetProcessDebugPrivelege:boolean;
    var
     hToken:THandle;
     tp:TTokenPrivileges;
     rl:cardinal;
    begin
      result:=false;
      if not OpenProcessToken(GetCurrentProcess,TOKEN_ADJUST_PRIVILEGES,hToken) then exit;
      try
         if not LookupPrivilegeValue(nil,'SeDebugPrivilege', tp.Privileges[0].Luid) then exit;
          tp.Privileges[0].Attributes:=SE_PRIVILEGE_ENABLED;
          tp.PrivilegeCount:=1;
          result:=AdjustTokenPrivileges(hToken,false,tp,0,nil,rl) and (GetLastError=0)
      finally
         CloseHandle(hToken);
      end
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     SetProcessDebugPrivelege;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
        ShowMessage(WindowGetExe(hWnd))
    end;

©Drkb::02133


PS только для NT4 и выше. Для Win9x юзать GetWindowModuleFileName.


Автор: Krid

Взято из <https://forum.sources.ru>

 
