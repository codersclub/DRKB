---
Title: Запущен ли сервер удаленного доступа (RAS)
Date: 01.01.2007
---


Запущен ли сервер удаленного доступа (RAS)
==========================================

::: {.date}
01.01.2007
:::

Запущен ли сервер удаленного доступа (RAS)

    function checkras: boolean;
    const maxentries = 100;
    var
    bufsize : integer;
    numentries: integer;
    entries : array[1..maxentries] of trasconn;
    begin
    entries[1].dwsize := sizeof(trasconn);
    bufsize:=sizeof(trasconn)*maxentries;
    fillchar(stat, sizeof(trasconnstatus), 0);
    rasenumconnections(@entries[1], bufsize, numentries);
    if numentries > 0 then result:=true 
    else result:=false;
    end;

 \

Источник: vlata.com
