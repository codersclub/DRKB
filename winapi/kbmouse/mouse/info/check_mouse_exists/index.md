---
Title: Как узнать, присутствует ли мышка?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как узнать, присутствует ли мышка?
==================================

    function MousePresent : Boolean; 
    begin 
    if GetSystemMetrics(SM_MOUSEPRESENT) <> 0 then 
      Result := true 
    else 
      Result := false; 
    end; 

