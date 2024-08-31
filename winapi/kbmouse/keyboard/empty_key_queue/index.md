---
Title: Как очистить буфер клавиатуры?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как очистить буфер клавиатуры?
==============================

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

