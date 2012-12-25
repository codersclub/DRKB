---
Title: Как разрешить / запретить переключение между задачами?
Date: 01.01.2007
---

Как разрешить / запретить переключение между задачами?
======================================================

::: {.date}
01.01.2007
:::

только для ALT+TAB и CTRL+ESC)

Это не совсем профессиональный способ, но он работает! Мы просто
эмулируем запуск и остановку скринсейвера.

    Procedure TaskSwitchingStatus( State : Boolean ); 
    Var 
        OldSysParam : LongInt; 
    Begin 
        SystemParametersInfo( SPI_SCREENSAVERRUNNING, Word( State ), @OldSysParam, 0 ); 
    End;

Взято из <https://forum.sources.ru>
