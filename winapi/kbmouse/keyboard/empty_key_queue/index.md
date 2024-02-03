---
Title: Как очистить буфер клавиатуры?
Date: 01.01.2007
---


Как очистить буфер клавиатуры?
==============================

::: {.date}
01.01.2007
:::

    procedure EmptyKeyQueue;
    var
      msg: TMsg;
    begin
      while PeekMessage(msg, 0, WM_KEYFIRST, WM_KEYLAST, PM_REMOVE or PM_NOYIELD) do
        ;
    end;
     
    begin
      EmptyKeyQueue;
    end.

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
