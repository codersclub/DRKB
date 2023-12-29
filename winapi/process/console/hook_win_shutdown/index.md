---
Title: Как консольное приложение может узнать, что Винды завершаются?
Author: Nomadic 
Date: 01.01.2007
---

Как консольное приложение может узнать, что Винды завершаются?
==============================================================

::: {.date}
01.01.2007
:::

Автор: Nomadic 

Все процессы получают сигналы CTRL\_CLOSE\_EVENT, CTRL\_LOGOFF\_EVENT и
CTRL\_SHUTDOWN\_EVENT. А делается это (грубо говоря :) так:

     
    BOOL Ctrl_Handler( DWORD Ctrl )
    {
      if( (Ctrl == CTRL_SHUTDOWN_EVENT) || (Ctrl == CTRL_LOGOFF_EVENT) )
      {
        // Вау! Юзер обламывает!
      }
      else
      {
        // Тут что-от другое можно творить. А можно и не творить :-)
      }
      return TRUE;
    }

    function Ctrl_Handler(Ctrl: Longint): LongBool;
    begin
      if Ctrl in [CTRL_SHUTDOWN_EVENT, CTRL_LOGOFF_EVENT] then
      begin
        // Вау, вау
      end
      else
      begin
        // Am I creator?
      end;
      Result := true;
    end;

А где-то в программе:

SetConsoleCtrlHandler( Ctrl\_Handler, TRUE );

Таких обработчиков можно навесить кучу. Если при обработке какого-то из
сообщений обработчик возвращает FALSE, то вызывается следующий
обработчик. Можно настроить таких этажерок, что ого-го :-)))

Короче, смотри описание SetConsoleCtrlHandler -- там всё есть.

Взято с <https://delphiworld.narod.ru>
