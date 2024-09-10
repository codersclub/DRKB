---
Title: Получить статус питания
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Получить статус питания
=======================

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
        ShowMessage(Format('Battery power left: %d percent.',
                           [SysPowerStatus.BatteryLifePercent]));
      end;
    end;

