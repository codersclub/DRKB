---
Title: Как открыть окно настройки даты и времени Windows?
Author: Vit
Date: 01.01.2007
---

Как открыть окно настройки даты и времени Windows?
==================================================

::: {.date}
01.01.2007
:::

    Shellexecute(handle, 'Open', 'Rundll32.exe', 'shell32.dll,Control_RunDLL TIMEDATE.CPL', Pchar(Getsystemdir), 0); 

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
