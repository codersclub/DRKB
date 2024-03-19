---
Title: Как остановить или запустить IB сервис?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как остановить или запустить IB сервис?
=======================================

Вам нужно отключить службу базы данных Interbase, например для установки программы,
а затем перезапустить ее?

Вы можете сделать это с помощью большого количества кода Delphi,
включающего модуль WinSvc и вызовы функций для

    OpenSCManager()
    EnumServicesStatus()
    OpenService()
    StartService() or ControlService().

Но, к счастью, существует гораздо более простое решение,
использующее программу NET.EXE, которая была частью Windows со времен Windows for Workgroups (Wfw 3.11).

Просто создайте два пакетных файла: IBSTOP.BAT и IBSTART.BAT
и вызовите их из своего кода.
Вы можете запустить их и дождаться их завершение.

IBSTOP.BAT:

```bat
@echo off
net stop "InterBase Guardian" >NULL
net stop "InterBase Server" >NULL
```

IBSTART.BAT:

```bat
@echo off
net start "Interbase Guardian" >NULL
```

