---
Title: Как открыть диалог добавления принтера?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Как открыть диалог добавления принтера?
=======================================

    // добавьте ShellAPI в USES
     
    begin
      ShellExecute(handle, nil, 'rundll32.exe',
        'shell32.dll,SHHelpShortcuts_RunDLL AddPrinter',
        '', SW_SHOWNORMAL);
    end;

