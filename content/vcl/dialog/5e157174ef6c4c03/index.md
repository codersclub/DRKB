---
Title: Как открыть диалог Add Printer?
Date: 01.01.2007
---


Как открыть диалог Add Printer?
===============================

::: {.date}
01.01.2007
:::

добавьте ShellAPI в USES

    ShellExecute(handle, nil, 
    'rundll32.exe', 
    'shell32.dll,SHHelpShortcuts_RunDLL AddPrinter', '', SW_SHOWNORMAL); 

Взято из <https://forum.sources.ru>
