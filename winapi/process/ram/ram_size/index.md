---
Title: Как получить весь размер системной памяти?
Date: 01.01.2007
---

Как получить весь размер системной памяти?
==========================================

::: {.date}
01.01.2007
:::

    function GetMemoryTotalPhys : DWord; 
    var 
    memStatus: TMemoryStatus; 
    begin 
    memStatus.dwLength := sizeOf ( memStatus ); 
    GlobalMemoryStatus ( memStatus ); 
    Result := memStatus.dwTotalPhys; 
    end; 

Взято из <https://forum.sources.ru>
