---
Title: Проверка блокировки рабочего стола компьютера
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Проверка блокировки рабочего стола компьютера
==========================================

    function IsWorkstationLocked: Boolean;
    var
      hDesktop: HDESK;
    begin
      Result := False;
      hDesktop := OpenDesktop('default',
        0, False,
        DESKTOP_SWITCHDESKTOP);
      if hDesktop <> 0 then
      begin
        Result := not SwitchDesktop(hDesktop);
        CloseDesktop(hDesktop);
      end;
    end;

