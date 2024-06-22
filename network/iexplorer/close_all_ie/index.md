---
Title: Закрытие всех окон IE
Author: bizar
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Закрытие всех окон IE
=====================

    Procedure CloseAllIE_1;
    var
       ie:HWND;
      begine
        //Ищем окно IE
        ie:=FindWindow(`IEFrame`, nil);
        //пока найдено окно IE...
        while ie<>0 do
          begin
            //... закрываем его
            postmessage (ie, WM_CLOSE, 0, 0);
            //ищем следующее
            ie:=FindWindow (`IEFrame`, nil);
          end;
    end;

