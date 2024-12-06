---
Title: Проверить, запущена ли программа от System Account
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Проверить, запущена ли программа от System Account
==================================================

    function OnSystemAccount(): Boolean;
    const
      cnMaxNameLen = 254;
    var
      sName: string;
      dwNameLen: DWORD;
    begin
      dwNameLen := cnMaxNameLen - 1;
      SetLength(sName, cnMaxNameLen);
      GetUserName(PChar(sName), dwNameLen);
      SetLength(sName, dwNameLen);
      if UpperCase(Trim(sName)) = 'SYSTEM' then
        Result := True 
      else 
        Result := False;
    end;

