---
Title: Получить время задержки хранителя экрана
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Получить время задержки хранителя экрана
========================================

    function GetScreenSaverTimeout: Integer;
    begin
      SystemParametersInfo(SPI_GETSCREENSAVETIMEOUT, 0, @Result, 0);
    end;
    
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowMessage(IntToStr(GetScreenSaverTimeout) + ' Sec.');
    end;

