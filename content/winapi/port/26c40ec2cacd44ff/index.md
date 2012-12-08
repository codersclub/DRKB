---
Title: Как узнать, есть ли в приемном буфере RS232 данные?
Date: 01.01.2007
---


Как узнать, есть ли в приемном буфере RS232 данные?
===================================================

::: {.date}
01.01.2007
:::

При помощи функции ClearCommError можно узнать, сколько байт данных
находится в буфере приёма (и буфере передачи) последовательного
интерфейса.

    procedure DataInBuffer(Handle: THandle; 
                           var InQueue, OutQueue: integer); 
    var ComStat: TComStat; 
        e: integer; 
    begin 
      if ClearCommError(Handle, e, @ComStat) then 
      begin 
        InQueue := ComStat.cbInQue; 
        OutQueue := ComStat.cbOutQue; 
      end 
      else 
      begin 
        InQueue := 0; 
        OutQueue := 0; 
      end; 
    end; 

Взято из <https://forum.sources.ru>
