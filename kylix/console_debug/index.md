---
Title: Как отлаживать консольные приложения?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как отлаживать консольные приложения?
=====================================

As with Delphi you can use Kylix to write console applications even
though many people think that\'s not important. ;-)

When you start a console program in the Delphi Debugger it automatically
opens a console window ("DOS command prompt") where you can see the output
of e.g. the writeln command.

Kylix doesn\'t do that automatically and if you don\'t look hard enough
you might think it is impossible to debug console applications with it.

But if you open the run / parameters dialog you will find an entry
called "Use Launcher Application" that is prefilled with xconsole. Just tick
this option and there you go.

