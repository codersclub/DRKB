---
Title: Как сделать виртуальный диск?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как сделать виртуальный диск?
=============================

    { ... }
    if DefineDosDevice(DDD_RAW_TARGET_PATH, 'P:', 'F:\Backup\Music\Modules') then
      ShowMessage('Drive was created successfully')
    else
      ShowMessage('Error creating drive');
        { ... }

