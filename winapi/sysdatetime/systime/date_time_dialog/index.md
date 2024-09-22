---
Title: Как открыть окно настройки даты и времени Windows?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---

Как открыть окно настройки даты и времени Windows?
==================================================

    Shellexecute(handle, 'Open', 'Rundll32.exe',
                 'shell32.dll,Control_RunDLL TIMEDATE.CPL',
                 Pchar(Getsystemdir), 0); 

