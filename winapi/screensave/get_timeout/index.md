---
Title: Получить время задержки хранителя экрана
Date: 01.01.2007
---

Получить время задержки хранителя экрана
========================================

::: {.date}
01.01.2007
:::

    function GetScreenSaverTimeout: Integer;
     begin
       SystemParametersInfo(SPI_GETSCREENSAVETIMEOUT, 0, @Result, 0);
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       ShowMessage(IntToStr(GetScreenSaverTimeout) + ' Sec.');
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
