---
Title: Как определить, включено ли автоскрытие у панели задач?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как определить, включено ли автоскрытие у панели задач?
=======================================================

    uses ShellAPI; 
     
    ... 
     
    function IsTaskbarAutoHideOn : boolean; 
    var ABData : TAppBarData; 
    begin 
      ABData.cbSize := sizeof(ABData); 
      Result :=(SHAppBarMessage(ABM_GETSTATE, ABData) and ABS_AUTOHIDE) > 0; 
    end; 

