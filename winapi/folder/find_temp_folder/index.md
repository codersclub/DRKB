---
Title: Как найти директорию Temp в Windows?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как найти директорию Temp в Windows?
====================================

    function c_GetTempPath: String; 
    var 
      Buffer: array[0..1023] of Char; 
    begin 
      SetString(Result, Buffer, GetTempPath(Sizeof(Buffer)-1,Buffer)); 
    end; 

этот код так же можно использовать для:

- GetCurrentDirectory
- GetSystemDirectory
- GetWindowsDirectory

