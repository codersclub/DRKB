---
Title: Прерывание работы принтера
Date: 01.01.2007
---

Прерывание работы принтера
==========================

::: {.date}
01.01.2007
:::

При вызове Printer.Abort должен вызываться код

   WinProcs.AbortProc(Printer.Handle)

но этого не происходит. Вызывайте это сами каждый раз при использовании
Printer.Abort.

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba
