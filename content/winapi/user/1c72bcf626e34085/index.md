---
Title: Как узнать имя пользователя?
Date: 01.01.2007
---

Как узнать имя пользователя?
============================

::: {.date}
01.01.2007
:::

    function GetUserFromWindows: string;
    var
      UserName : string;
      UserNameLen : Dword;
    begin
      UserNameLen := 255;
      SetLength(userName, UserNameLen);
      if GetUserName(PChar(UserName), UserNameLen) then
        Result := Copy(UserName,1,UserNameLen - 1)
      else
        Result := '';
    end;
     

------------------------------------------------------------------------

    function GetCurrentUserName: string;
     const
       cnMaxUserNameLen = 254;
     var
       sUserName: string;
       dwUserNameLen: DWORD;
     begin
       dwUserNameLen := cnMaxUserNameLen - 1;
       SetLength(sUserName, cnMaxUserNameLen);
       GetUserName(PChar(sUserName), dwUserNameLen);
       SetLength(sUserName, dwUserNameLen);
       Result := sUserName;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       ShowMessage(GetCurrentUserName);
     end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

    function GetCurrentUserName(var CurrentUserName: string): Boolean;
     var
       BufferSize: DWORD;
       pUser: PChar;
     begin
       BufferSize := 0;
       GetUserName(nil, BufferSize);
       pUser := StrAlloc(BufferSize);
       try
         Result := GetUserName(pUser, BufferSize);
         CurrentUserName := StrPas(pUser);
       finally
         StrDispose(pUser);
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       CurrentUserName: string;
     begin
       GetCurrentUserName(CurrentUserName);
       Label1.Caption :=  CurrentUserName;
     end;
     
     {*********************************************}
     
     { 
      Windows NT/2000/XP: 
     
      The GetUserNameEx function retrieves the name of the user or other 
      security principal associated with the calling thread. 
      You can specify the format of the returned name. 
      If the thread is impersonating a client, GetUserNameEx 
      returns the name of the client. 
    }
     
     const
       NameUnknown = 0; // Unknown name type. 
      NameFullyQualifiedDN = 1;  // Fully qualified distinguished name 
      NameSamCompatible = 2; // Windows NT® 4.0 account name 
      NameDisplay = 3;  // A "friendly" display name 
      NameUniqueId = 6; // GUID string that the IIDFromString function returns 
      NameCanonical = 7;  // Complete canonical name 
      NameUserPrincipal = 8; // User principal name 
      NameCanonicalEx = 9;
       NameServicePrincipal = 10;  // Generalized service principal name 
      DNSDomainName = 11;  // DNS domain name, plus the user name 
     
     
    procedure GetUserNameEx(NameFormat: DWORD;
       lpNameBuffer: LPSTR; nSize: PULONG); stdcall;
       external 'secur32.dll' Name 'GetUserNameExA';
     
     
     function LoggedOnUserNameEx(fFormat: DWORD): string;
     var
       UserName: array[0..250] of char;
       Size: DWORD;
     begin
       Size := 250;
       GetUserNameEx(fFormat, @UserName, @Size);
       Result := UserName;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       Edit1.Text := LoggedOnUserNameEx(NameSamCompatible);
     end;
     

Взято с сайта: <https://www.swissdelphicenter.ch>
