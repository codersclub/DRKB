---
Title: Как определить, установлен ли ScreenSaver?
Date: 01.01.2007
---

Как определить, установлен ли ScreenSaver?
==========================================

::: {.date}
01.01.2007
:::

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

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
