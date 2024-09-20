---
Title: How immediately start a service after it\'s installation?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

How immediately start a service after it\'s installation?
=========================================================

    { To automatically start a service after its installation use this code }
     
    procedure TMyService.ServiceAfterInstall(Sender: TService);
    var
      sm: TServiceManager;
    begin
      sm := TServiceManager.Create;
      try
        if sm.Connect then
          if sm.OpenServiceConnection(self.name) then
            sm.StartService;
      finally
        sm.Free;
      end;
    end;

