---
Title: Как сделать виртуальный диск?
Date: 01.01.2007
---


Как сделать виртуальный диск?
=============================

::: {.date}
01.01.2007
:::

    { ... }
    if DefineDosDevice(DDD_RAW_TARGET_PATH, 'P:', 'F:\Backup\Music\Modules') then
      ShowMessage('Drive was created successfully')
    else
      ShowMessage('Error creating drive');
        { ... }

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
