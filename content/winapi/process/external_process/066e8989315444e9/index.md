---
Title: How to get the NT Domain and Username of a process?
Date: 01.01.2007
---

How to get the NT Domain and Username of a process?
===================================================

::: {.date}
01.01.2007
:::

    uses
      TlHelp32;
     
    type
      PTOKEN_USER = ^TOKEN_USER;
      _TOKEN_USER = record
        User: TSidAndAttributes;
      end;
      TOKEN_USER = _TOKEN_USER;
     
    function GetUserAndDomainFromPID(ProcessId: DWORD;
      var User, Domain: string): Boolean;
    var
      hToken: THandle;
      cbBuf: Cardinal;
      ptiUser: PTOKEN_USER;
      snu: SID_NAME_USE;
      ProcessHandle: THandle;
      UserSize, DomainSize: DWORD;
      bSuccess: Boolean;
    begin
      Result := False;
      ProcessHandle := OpenProcess(PROCESS_QUERY_INFORMATION, False, ProcessId);
      if ProcessHandle <> 0 then
      begin
      //  EnableProcessPrivilege(ProcessHandle, 'SeSecurityPrivilege', True);
        if OpenProcessToken(ProcessHandle, TOKEN_QUERY, hToken) then
        begin
          bSuccess := GetTokenInformation(hToken, TokenUser, nil, 0, cbBuf);
          ptiUser  := nil;
          while (not bSuccess) and (GetLastError = ERROR_INSUFFICIENT_BUFFER) do
          begin
            ReallocMem(ptiUser, cbBuf);
            bSuccess := GetTokenInformation(hToken, TokenUser, ptiUser, cbBuf, cbBuf);
          end;
          CloseHandle(hToken);
     
          if not bSuccess then
          begin
            Exit;
          end;
     
          UserSize := 0;
          DomainSize := 0;
          LookupAccountSid(nil, ptiUser.User.Sid, nil, UserSize, nil, DomainSize, snu);
          if (UserSize <> 0) and (DomainSize <> 0) then
          begin
            SetLength(User, UserSize);
            SetLength(Domain, DomainSize);
            if LookupAccountSid(nil, ptiUser.User.Sid, PChar(User), UserSize,
              PChar(Domain), DomainSize, snu) then
            begin
              Result := True;
              User := StrPas(PChar(User));
              Domain := StrPas(PChar(Domain));
            end;
          end;
     
          if bSuccess then
          begin
            FreeMem(ptiUser);
          end;
        end;
        CloseHandle(ProcessHandle);
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      hProcSnap: THandle;
      pe32: TProcessEntry32;
      Domain, User: string;
      s: string;
    begin
     
      hProcSnap := CreateToolHelp32SnapShot(TH32CS_SNAPALL, 0);
      if hProcSnap = INVALID_HANDLE_VALUE then Exit;
     
      pe32.dwSize := SizeOf(ProcessEntry32);
     
      if Process32First(hProcSnap, pe32) = True then
        while Process32Next(hProcSnap, pe32) = True do
        begin
     
          if GetUserAndDomainFromPID(pe32.th32ProcessID, User, Domain) then
          begin
            s := Format('%s User: %s ; Domain: %s',[StrPas(pe32.szExeFile), User, Domain]);
            Listbox1.Items.Add(s);
          end else
            Listbox1.Items.Add(StrPas(pe32.szExeFile));
        end;
      CloseHandle(hProcSnap);
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
