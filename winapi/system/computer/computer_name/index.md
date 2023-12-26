---
Title: Как узнать имя компьютера?
Author: Vit
Date: 01.01.2007
---

Как узнать имя компьютера?
==========================

::: {.date}
01.01.2007
:::

    Function ReadComputerName:string;

     
    var
    i:DWORD; 
    p:PChar;
    begin
    i:=255;
    GetMem(p, i);
    GetComputerName(p, i);
    Result:=String(p);
    FreeMem(p);
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Получение локального имени компьютера
     
    Зависимости: Winsock
    Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
    Copyright:   Gua
    Дата:        23 июля 2002 г.
    ***************************************************** }
     
    function GetLocalName: string;
    var
      WSAData: TWSAData;
      Namebuf: array[0..255] of char;
    begin
      WSAStartup($101, WSAData);
      GetHostname(namebuf, sizeof(namebuf));
      Result := NameBuf;
      WSACleanup;
    end;
     

Взято с сайта: <https://www.swissdelphicenter.ch>
