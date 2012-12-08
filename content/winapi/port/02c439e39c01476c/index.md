---
Title: Как узнать адрес LPT-порта?
Date: 01.01.2007
---


Как узнать адрес LPT-порта?
===========================

::: {.date}
01.01.2007
:::

Эта функция работает в Win95 и Win98.

    function GetPortAddress(PortNo: integer): word; assembler; stdcall; 
    asm 
      push es 
      push ebx 
      mov ebx, PortNo 
      shl ebx,1 
      mov ax,40h // Dos segment adress 
      mov es,ax 
      mov ax,ES:[ebx+6] // get port adress in 16Bit way :) 
      pop ebx 
      pop es 
    end;

Для NT можно заглянуть сюда:
<https://www.wideman-one.com/gw/tech/Delphi/iopm/index.htm>

Взято из <https://forum.sources.ru>
