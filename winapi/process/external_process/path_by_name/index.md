---
Title: Как узнать путь к программе, если известно её имя?
Author: Rouse\_, P.O.D.
Source: <https://forum.sources.ru>
Date: 01.01.2007
---

Как узнать путь к программе, если известно её имя?
==================================================

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    uses
      TlHelp32;
     
    function GetExeFilePath(ExeFileName: String): String;
    var
      hSnapshot, hSnapshot2: THandle;
      Proc: TProcessEntry32;
      m: TModuleEntry32;
    begin
      Result := '';
      hSnapshot := CreateToolhelp32Snapshot(TH32CS_SNAPPROCESS,0);
      try
        proc.dwSize := Sizeof(proc);
        if Process32First(hSnapshot, proc) then
        repeat
          if AnsiSameText(proc.szExeFile, ExeFileName) then
          begin
            hSnapshot2 := CreateToolhelp32Snapshot(TH32CS_SNAPMODULE,
              proc.th32ProcessID);
            try
              m.dwSize := SizeOf(TModuleEntry32);
              if Module32First(hSnapshot2, m) then
              begin
                Result := m.szExePath;
                Exit;
              end;
            finally
              CloseHandle(hSnapshot2);
            end;
          end;
        until not Process32Next(hSnapshot, proc);
      finally
        CloseHandle(hSnapshot);
      end;
    end;


