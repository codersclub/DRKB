---
Title: How immediately start a service after it\'s installation?
Date: 01.01.2007
---

How immediately start a service after it\'s installation?
=========================================================

::: {.date}
01.01.2007
:::

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

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
