---
Title: Как проверить, не запущена ли Terminal Client Session?
Date: 01.01.2007
---

Как проверить, не запущена ли Terminal Client Session?
======================================================

::: {.date}
01.01.2007
:::

    function IsRemoteSession: Boolean;
    const
      sm_RemoteSession = $1000; { from WinUser.h }
    begin
      Result := GetSystemMetrics(sm_RemoteSession) <> 0;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
