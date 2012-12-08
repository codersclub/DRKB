---
Title: Проверить, запущена ли программа от System Account
Date: 01.01.2007
---

Проверить, запущена ли программа от System Account
==================================================

::: {.date}
01.01.2007
:::

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
      if UpperCase(Trim(sName)) = 'SYSTEM' then Result := True 
      else 
        Result := False;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
