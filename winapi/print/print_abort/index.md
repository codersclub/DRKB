---
Title: Прерывание работы принтера
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---

Прерывание работы принтера
==========================

> При вызове Printer.Abort должен вызываться код
> 
>     WinProcs.AbortProc(Printer.Handle)
> 
> но этого не происходит.

Вызывайте это сами каждый раз при использовании Printer.Abort.

