---
Title: Как проверить, не запущена ли Terminal Client Session?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Как проверить, не запущена ли Terminal Client Session?
======================================================

    function IsRemoteSession: Boolean;
    const
      sm_RemoteSession = $1000; { from WinUser.h }
    begin
      Result := GetSystemMetrics(sm_RemoteSession) <> 0;
    end;

