---
Title: Как открыть диалог добавления принтера?
Date: 01.01.2007
---

Как открыть диалог добавления принтера?
=======================================

::: {.date}
01.01.2007
:::

    // добавьте ShellAPI в USES
     
    begin
      ShellExecute(handle, nil, 'rundll32.exe',
        'shell32.dll,SHHelpShortcuts_RunDLL AddPrinter',
        '', SW_SHOWNORMAL);
    end;

Взято с <https://delphiworld.narod.ru>
