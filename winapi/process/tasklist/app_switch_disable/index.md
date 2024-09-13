---
Title: Как разрешить / запретить переключение между задачами?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Как разрешить / запретить переключение между задачами?
======================================================

только для ALT+TAB и CTRL+ESC)

Это не совсем профессиональный способ, но он работает! Мы просто
эмулируем запуск и остановку скринсейвера.

    Procedure TaskSwitchingStatus( State : Boolean ); 
    Var 
        OldSysParam : LongInt; 
    Begin 
        SystemParametersInfo( SPI_SCREENSAVERRUNNING, Word( State ), @OldSysParam, 0 ); 
    End;

