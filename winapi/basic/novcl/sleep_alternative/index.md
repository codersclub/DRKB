---
Title: Альтернатива для Sleep(), но чтобы приложение не зависало
Author: jack128
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Альтернатива для Sleep(), но чтобы приложение не зависало
=========================================================

Часто требуется организовать задержку в выполнении кода, но чтобы при
этому приложение не зависало, могло реагировать на сообщения Windows, в
часности могло перерисовываться.

    procedure Delay(ATimeout: Integer);
     
    var
      t: Cardinal;
    begin
      while ATimeout > 0 do
      begin
        t := GetTickCount;
        if MsgWaitForMultipleObjects(0, nil^, False, ATimeOut, QS_ALLINPUT) = WAIT_TIMEOUT then
          Exit;
        Application.ProcessMessages;  // Пришли новые сообщения Windwos, обрабатываем их..
        dec(ATimeout, GetTickCount - t);
      end;
    end;

