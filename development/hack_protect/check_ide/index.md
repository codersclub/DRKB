---
Title: Как определить, запущена ли Delphi?
Date: 01.01.2007
---


Как определить, запущена ли Delphi?
===================================

::: {.date}
01.01.2007
:::

Иногда, особенно при создании компонент, бывает необходимо получить
доступ к компоненту только когда запущена Delphi IDE.

    If FindWindow('TAppBuilder',nil) <= 0 then 
      ShowMessage('Delphi is not running !') 
    else 
      ShowWindow('Delphi is running !'); 

Взято из <https://forum.sources.ru>
