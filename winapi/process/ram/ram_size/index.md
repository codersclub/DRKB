---
Title: Как получить весь размер системной памяти?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как получить весь размер системной памяти?
==========================================

    function GetMemoryTotalPhys : DWord; 
    var 
      memStatus: TMemoryStatus; 
    begin 
      memStatus.dwLength := sizeOf ( memStatus ); 
      GlobalMemoryStatus ( memStatus ); 
      Result := memStatus.dwTotalPhys; 
    end; 

