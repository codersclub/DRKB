---
Title: Как узнать заряженность батарей?
Date: 01.01.2007
---


Как узнать заряженность батарей?
================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
      SysPowerStatus: TSystemPowerStatus;
    begin
      GetSystemPowerStatus(SysPowerStatus);
      if Boolean(SysPowerStatus.ACLineStatus) then
      begin
        ShowMessage('System running on AC.');
      end
      else
      begin
        ShowMessage('System running on battery.');
        ShowMessage(Format('Battery power left: %d percent.', [SysPowerStatus.BatteryLifePercent]));
      end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
