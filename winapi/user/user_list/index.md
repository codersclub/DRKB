---
Title: Получить список пользователей
Date: 01.01.2007
---

Получить список пользователей
=============================

Author: [Кондратюк Виталий](mailto:vit@mo.msk.ru)

Source: <https://delphiworld.narod.ru>

GetLocalUserList - возвращает список пользователей (Windows NT, Windows
2000)

    unit Func;
     
    interface
     
    uses Sysutils, Classes, Stdctrls, Comctrls, Graphics, Windows;
     
    ////////////////////////////////////////////////////////////////////////////////
    {$EXTERNALSYM NetUserEnum}
    function NetUserEnum(servername: LPWSTR;
                         level,
                         filter: DWORD;
                         bufptr: Pointer;
                         prefmaxlen: DWORD;
                         entriesread,
                         totalentries,
                         resume_handle: LPDWORD): DWORD; stdcall;
             external 'NetApi32.dll' Name 'NetUserEnum';
     
    function NetApiBufferFree(Buffer: Pointer {LPVOID}): DWORD; stdcall;
             external 'NetApi32.dll' Name 'NetApiBufferFree';
    ////////////////////////////////////////////////////////////////////////////////
     
    procedure GetLocalUserList(ulist: TStringList);
     
    implementation
     
    //------------------------------------------------------------------------------
    // возвращает список пользователей локального хоста
    //------------------------------------------------------------------------------
     
    procedure GetLocalUserList(ulist: TStringList);
    const
     
      NERR_SUCCESS = 0;
      FILTER_TEMP_DUPLICATE_ACCOUNT = $0001;
      FILTER_NORMAL_ACCOUNT = $0002;
      FILTER_PROXY_ACCOUNT = $0004;
      FILTER_INTERDOMAIN_TRUST_ACCOUNT = $0008;
      FILTER_WORKSTATION_TRUST_ACCOUNT = $0010;
      FILTER_SERVER_TRUST_ACCOUNT = $0020;
     
    type
     
      TUSER_INFO_10 = record
        usri10_name,
        usri10_comment,
        usri10_usr_comment,
        usri10_full_name: PWideChar;
      end;
      PUSER_INFO_10 = ^TUSER_INFO_10;
     
    var
     
      dwERead, dwETotal, dwRes, res: DWORD;
      inf: PUSER_INFO_10;
      info: Pointer;
      p: PChar;
      i: Integer;
    begin
     
      if ulist = nil then
        Exit;
      ulist.Clear;
     
      info := nil;
      dwRes := 0;
      res := NetUserEnum(nil,
                         10,
                         FILTER_NORMAL_ACCOUNT,
                         @info,
                         65536,
                         @dwERead,
                         @dwETotal,
                         @dwRes);
      if (res <> NERR_SUCCESS) or (info = nil) then
        Exit;
      p := PChar(info);
      for i := 0 to dwERead - 1 do
      begin
        inf := PUSER_INFO_10(p + i * SizeOf(TUSER_INFO_10));
        ulist.Add(WideCharToString(PWideChar((inf^).usri10_name)));
      end;
     
      NetApiBufferFree(info);
    end;
     
    end.

------------------------------------------------------------------------

Вариант 2:

Author: Manfred Ruzicka

Source: <https://www.swissdelphicenter.ch>

    {------------------------------------------
      unit Name: GetUser
      Author: Manfred Ruzicka
      History:   Diese unit ermittelt den aktuell angemeldeten User
                 einer NT / 2000 Worstation / Servers.Sie wurde
                 aus dem Programm "loggedon2" von Assarbad
                 ubernommen und fur an die VCL angepasst.
                 Diese unit enthalt zwar noch einige kleine Fehler,
                 funktioniert aber ohne Probleme.
    ------------------------------------------}
     
     unit GetUser;
     
     interface
     
     uses
       Windows
       , Messages
       , SysUtils
       , Dialogs;
     
     type
       TServerBrowseDialogA0 = function(hwnd: HWND;
                                        pchBuffer: Pointer;
                                        cchBufSize: DWORD): bool;
                               stdcall;
       ATStrings = array of string;
     
     
     procedure Server(const ServerName: string);
     function ShowServerDialog(AHandle: THandle): string;
     
     
     implementation
     
     uses Client, ClientSkin;
     
     procedure Server(const ServerName: string);
     const
       MAX_NAME_STRING = 1024;
     var
       userName, domainName: array[0..MAX_NAME_STRING] of Char;
       subKeyName: array[0..MAX_PATH] of Char;
       NIL_HANDLE: Integer absolute 0;
       Result: ATStrings;
       subKeyNameSize: DWORD;
       Index: DWORD;
       userNameSize: DWORD;
       domainNameSize: DWORD;
       lastWriteTime: FILETIME;
       usersKey: HKEY;
       sid: PSID;
       sidType: SID_NAME_USE;
       authority: SID_IDENTIFIER_AUTHORITY;
       subAuthorityCount: BYTE;
       authorityVal: DWORD;
       revision: DWORD;
       subAuthorityVal: array[0..7] of DWORD;
     
     
       function getvals(s: string): Integer;
       var
         i, j, k, l: integer;
         tmp: string;
       begin
         Delete(s, 1, 2);
         j   := Pos('-', s);
         tmp := Copy(s, 1, j - 1);
         val(tmp, revision, k);
         Delete(s, 1, j);
         j := Pos('-', s);
         tmp := Copy(s, 1, j - 1);
         val('$' + tmp, authorityVal, k);
         Delete(s, 1, j);
         i := 2;
         s := s + '-';
         for l := 0 to 7 do
         begin
           j := Pos('-', s);
           if j > 0 then
           begin
             tmp := Copy(s, 1, j - 1);
             val(tmp, subAuthorityVal[l], k);
             Delete(s, 1, j);
             Inc(i);
           end
           else
             break;
         end;
         Result := i;
       end;
     begin
       setlength(Result, 0);
       revision     := 0;
       authorityVal := 0;
       FillChar(subAuthorityVal, SizeOf(subAuthorityVal), #0);
       FillChar(userName, SizeOf(userName), #0);
       FillChar(domainName, SizeOf(domainName), #0);
       FillChar(subKeyName, SizeOf(subKeyName), #0);
       if ServerName <> '' then
       begin
         usersKey := 0;
         if (RegConnectRegistry(PChar(ServerName), HKEY_USERS, usersKey) <> 0) then
           Exit;
       end
       else
       begin
        if (RegOpenKey(HKEY_USERS, nil, usersKey) <> ERROR_SUCCESS) then
          Exit;
       end;
       Index          := 0;
       subKeyNameSize := SizeOf(subKeyName);
       while (RegEnumKeyEx(usersKey, Index, subKeyName, subKeyNameSize,
         nil, nil, nil, @lastWriteTime) = ERROR_SUCCESS) do
       begin
         if (lstrcmpi(subKeyName, '.default') <> 0) and (Pos('Classes', string(subKeyName)) = 0) then
         begin
           subAuthorityCount := getvals(subKeyName);
           if (subAuthorityCount >= 3) then
           begin
             subAuthorityCount := subAuthorityCount - 2;
             if (subAuthorityCount < 2) then subAuthorityCount := 2;
             authority.Value[5] := PByte(@authorityVal)^;
             authority.Value[4] := PByte(DWORD(@authorityVal) + 1)^;
             authority.Value[3] := PByte(DWORD(@authorityVal) + 2)^;
             authority.Value[2] := PByte(DWORD(@authorityVal) + 3)^;
             authority.Value[1] := 0;
             authority.Value[0] := 0;
             sid := nil;
             userNameSize := MAX_NAME_STRING;
             domainNameSize := MAX_NAME_STRING;
             if AllocateAndInitializeSid(authority, subAuthorityCount,
               subAuthorityVal[0], subAuthorityVal[1], subAuthorityVal[2],
               subAuthorityVal[3], subAuthorityVal[4], subAuthorityVal[5],
               subAuthorityVal[6], subAuthorityVal[7], sid) then
             begin
               if LookupAccountSid(PChar(ServerName), sid, userName, userNameSize,
                 domainName, domainNameSize, sidType) then
               begin
                 setlength(Result, Length(Result) + 1);
                 Result[Length(Result) - 1] := string(domainName) + '\' + string(userName);
     
                 // Hier kann das Ziel eingetragen werden 
                 Form1.label2.Caption := string(userName);
                 form2.label1.Caption := string(userName);
               end;
             end;
             if Assigned(sid) then FreeSid(sid);
           end;
         end;
         subKeyNameSize := SizeOf(subKeyName);
         Inc(Index);
       end;
       RegCloseKey(usersKey);
     end;
     
     function ShowServerDialog(AHandle: THandle): string;
     var
       ServerBrowseDialogA0: TServerBrowseDialogA0;
       LANMAN_DLL: DWORD;
       buffer: array[0..1024] of char;
       bLoadLib: Boolean;
     begin
       bLoadLib := False;
       LANMAN_DLL := GetModuleHandle('NTLANMAN.DLL');
       if LANMAN_DLL = 0 then
       begin
         LANMAN_DLL := LoadLibrary('NTLANMAN.DLL');
         bLoadLib := True;
       end;
       if LANMAN_DLL <> 0 then
       begin @ServerBrowseDialogA0 := GetProcAddress(LANMAN_DLL, 'ServerBrowseDialogA0');
         DialogBox(HInstance, MAKEINTRESOURCE(101), AHandle, nil);
         ServerBrowseDialogA0(AHandle, @buffer, 1024);
         if buffer[0] = '\' then
         begin
           Result := buffer;
         end;
         if bLoadLib = True then
           FreeLibrary(LANMAN_DLL);
       end;
     end;
     
     
     end.

------------------------------------------------------------------------

Вариант 3:

Source: <https://www.swissdelphicenter.ch>

    // The NetUserEnum function provides information about all user accounts on a server. 
     
    type
       USER_INFO_1 = record
         usri1_name: LPWSTR;
         usri1_password: LPWSTR;
         usri1_password_age: DWORD;
         usri1_priv: DWORD;
         usri1_home_dir: LPWSTR;
         usri1_comment: LPWSTR;
         usri1_flags: DWORD;
         usri1_script_path: LPWSTR;
       end;
       lpUSER_INFO_1 = ^USER_INFO_1;
     
     function NetUserEnum(ServerName: PWideChar;
                          Level,
                          Filter: DWORD;
                          var Buffer: Pointer;
                          PrefMaxLen: DWORD;
                          var EntriesRead,
                          TotalEntries,
                          ResumeHandle: DWORD): Longword;
              stdcall; external 'netapi32.dll';
     
     function NetApiBufferFree(pBuffer: PByte): Longint;
              stdcall; external 'netapi32.dll';
     
     {...}
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       EntiesRead: DWORD;
       TotalEntries: DWORD;
       UserInfo: lpUSER_INFO_1;
       lpBuffer: Pointer;
       ResumeHandle: DWORD;
       Counter: Integer;
       NetApiStatus: LongWord;
     begin
       ResumeHandle := 0;
       repeat
         // NetApiStatus := 
         // NetUserEnum(PChar('\\NT-Domain'), 1, 0, lpBuffer, 0,EntiesRead, TotalEntries, ResumeHandle); 
         NetApiStatus := NetUserEnum(nil, 1, 0, lpBuffer, 0, EntiesRead,
           TotalEntries, ResumeHandle);
         UserInfo     := lpBuffer;
     
         for Counter := 0 to EntiesRead - 1 do
         begin
           listbox1.Items.Add(WideCharToString(UserInfo^.usri1_name) + ' --> ' +
             WideCharToString(UserInfo^.usri1_comment));
           Inc(UserInfo);
         end;
     
         NetApiBufferFree(lpBuffer);
       until (NetApiStatus <> ERROR_MORE_DATA);
     end;

