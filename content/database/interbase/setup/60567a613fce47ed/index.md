---
Title: Как остановить или запустить IB сервис?
Date: 01.01.2007
---


Как остановить или запустить IB сервис?
=======================================

::: {.date}
01.01.2007
:::

Do you need to shutdown the Interbase db service e.g. for an
installation program and afterwards restart it?

You could do this with a lot of Delphi code involving unit WinSvc and
function calls to

OpenSCManager()

EnumServicesStatus()

OpenService()

StartService() or ControlService().

But luckily there is a much easier solution that uses the NET.EXE
program which has been part of Windows since Windows for Workgroups (Wfw
3.11). Just create the two batch files

IBSTOP.BAT

IBSTART.BAT

and call them from your code. You may want to call them and wait for
their termination.

IBSTOP.BAT

=============

\@echo off

net stop \"InterBase Guardian\" \>NULL

net stop \"InterBase Server\" \>NULL

IBSTART.BAT

=============

\@echo off

net start \"Interbase Guardian\" \>NULL

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
