---
Title: Создать процесс с правами админа
Author: win\_nt
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Создать процесс с правами админа
================================

    unit Main; 
     
    interface 
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ShellApi; 
     
    type 
      TForm1 = class(TForm) 
        Button1: TButton; 
        procedure Button1Click(Sender: TObject); 
      end; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    function CreateProcessWithLogonW(
      lpUsername: PWideChar; 
      lpDomain: PWideChar; 
      lpPassword: PWideChar; 
      dwLogonFlags: DWORD; 
      lpApplicationName: PWideChar; 
      lpCommandLine: PWideChar; 
      dwCreationFlags: DWORD; 
      lpEnvironment: Pointer; 
      lpCurrentDirectory: PWideChar; 
      const lpStartupInfo: _STARTUPINFOA; 
      var lpProcessInfo: PROCESS_INFORMATION): BOOL;
      stdcall; external 'advapi32.dll' name 'CreateProcessWithLogonW'; 
     
     
    {$R *.dfm} 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      hLib:THandle; 
      si: _STARTUPINFOA; 
      pi: Process_Information; 
    begin 
      ZeroMemory(@Si, Sizeof(si));
      si.cb := SizeOf(si); 
      CreateProcessWithLogonw('administrator', nil, 'master', 1, nil, 'notepad', 0, nil, nil, si, pi); 
    end; 
     
    end.

Должно работать, только лучше указывать полный путь до папки
запускаемого приложения... без этого у меня некоторые приложения не
запускались(один из параметров после \'notepad\').

