---
Title: Как отследить потерю памяти
Author: http://sunsb.dax.ru
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
Date: 01.01.2007
---


Как отследить потерю памяти
=============

Если Ваша программа после завершенмя "съест" некоторое количество
памяти, Windows тактично об этом умолчит, и ошибка останется не
найденной. Поэтому я рекомендую на этапе разработки, в файл проекта
вставлять модуль `checkMem`, который отследит некорректную работу с
памятью. Вставлять его нужно первым, для обеспечения чистоты
эксперимента.

Текст модуля:

    unit checkMem;                     
    interface
    implementation
     
    uses sysUtils, dialogs;
    var HPs : THeapStatus;
    var HPe : THeapStatus;
    var lost: integer;
    initialization
       HPs := getHeapStatus;
    finalization
       HPe := getHeapStatus;
       Lost:= HPe.TotalAllocated - HPs.TotalAllocated;
       if lost >  0 then begin
          beep;
          ShowMessage( format('lostMem: %d',[ lost ]) );
       end;
    end.

