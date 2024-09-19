---
Title: Как определить, установлен ли ScreenSaver?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---

Как определить, установлен ли ScreenSaver?
==========================================

    function ScreenSaverEnabled: Boolean;
    var
      status: Bool;
    begin
      SystemParametersInfo(SPI_GETSCREENSAVEACTIVE, 0, @status, 0);
      Result := status = True;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if ScreenSaverEnabled then
        Caption := 'Screensaver is enabled.'
      else
        Caption := 'Screensaver is disabled.'
    end;

