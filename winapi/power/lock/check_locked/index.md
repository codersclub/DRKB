---
Title: How to check if the Workstation is locked?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


How to check if the Workstation is locked?
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

