---
Title: Получение SID пользователя, под которым запущен процесс
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Получение SID пользователя, под которым запущен процесс
=======================================================

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      end;
     
      PTokenUser = ^TTokenUser;
      TTokenUser = record
        User: array[0..0] of TSIDAndAttributes;
      end;
     
      procedure ConvertSidToStringSid(SID: PSID; var StringSid: LPSTR); stdcall;
        external advapi32 name 'ConvertSidToStringSidA';
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    function GetCurrentUserSID: String;
    var
      TokenHandle: THandle;
      TokenInformationClass: TTokenInformationClass;
      TokenInformation: PTokenUser;
      ReturnLength: DWORD;
      StringSid: LPSTR;
    begin
      Result := '';
      if OpenProcessToken(GetCurrentProcess, TOKEN_QUERY, TokenHandle) then
      try
        TokenInformationClass := TokenUser;
        GetTokenInformation(TokenHandle, TokenInformationClass, nil, 0, ReturnLength);
        if GetLastError = ERROR_INSUFFICIENT_BUFFER then
        begin
          TokenInformation := GetMemory(ReturnLength);
          if TokenInformation <> nil then
          try
            if GetTokenInformation(TokenHandle, TokenInformationClass,
              TokenInformation, ReturnLength, ReturnLength) then
            begin
              ConvertSidToStringSid(TokenInformation^.User[0].Sid, StringSid);
              Result := StringSid;
            end;
          finally
            FreeMemory(TokenInformation);
          end;
        end;
      finally
        CloseHandle(TokenHandle);
      end;
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowMessage(GetCurrentUserSID);
    end;
     
    end.

