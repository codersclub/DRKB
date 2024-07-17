---
Title: Как открыть диалог Add Printer?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как открыть диалог Add Printer?
===============================

добавьте ShellAPI в USES

    ShellExecute(handle, nil, 
                 'rundll32.exe', 
                 'shell32.dll,SHHelpShortcuts_RunDLL AddPrinter',
                 '', SW_SHOWNORMAL); 

