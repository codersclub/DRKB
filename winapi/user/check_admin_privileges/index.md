---
Title: Как проверить, имеем ли мы административные привилегии в системе?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Как проверить, имеем ли мы административные привилегии в системе?
=================================================================

    type
      PTOKEN_GROUPS = TOKEN_GROUPS^;
     
    function RunningAsAdministrator(): Boolean;
    var
      SystemSidAuthority: SID_IDENTIFIER_AUTHORITY = SECURITY_NT_AUTHORITY;
      psidAdmin: PSID;
      ptg: PTOKEN_GROUPS = nil;
      htkThread: Integer; { HANDLE }
      cbTokenGroups: Longint; { DWORD }
      iGroup: Longint; { DWORD }
      bAdmin: Boolean;
    begin
      Result := false;
      if not OpenThreadToken(GetCurrentThread(), // get security token
        TOKEN_QUERY, FALSE, htkThread) then
        if GetLastError() = ERROR_NO_TOKEN then
        begin
          if not OpenProcessToken(GetCurrentProcess(),
            TOKEN_QUERY, htkThread) then
            Exit;
        end
        else
          Exit;
     
      if GetTokenInformation(htkThread, // get #of groups
        TokenGroups, nil, 0, cbTokenGroups) then
        Exit;
     
      if GetLastError() <> ERROR_INSUFFICIENT_BUFFER then
        Exit;
     
      ptg := PTOKEN_GROUPS(getmem(cbTokenGroups));
      if not Assigned(ptg) then
        Exit;
     
      if not GetTokenInformation(htkThread, // get groups
        TokenGroups, ptg, cbTokenGroups, cbTokenGroups) then
        Exit;
     
      if not AllocateAndInitializeSid(SystemSidAuthority,
        2, SECURITY_BUILTIN_DOMAIN_RID, DOMAIN_ALIAS_RID_ADMINS,
        0, 0, 0, 0, 0, 0, psidAdmin) then
        Exit;
     
      iGroup := 0;
      while iGroup < ptg^.GroupCount do // check administrator group
      begin
        if EqualSid(ptg^.Groups[iGroup].Sid, psidAdmin) then
        begin
          Result := TRUE;
          break;
        end;
        Inc(iGroup);
      end;
      FreeSid(psidAdmin);
    end;

