---
Title: Отладка экспертов
Date: 01.01.2007
---


Отладка экспертов
=================

::: {.date}
01.01.2007
:::

Debug Delphi 3 experts with Delphi 3

Delphi 3 has a new feature \"debug DLLs\". It can be used to debug
experts with the internal debugger. Just follow these simple steps, and
debugging an expert can be fun:

Make sure that the expert is not installed. If there is this entry

\\CURRENT\_USER\\software\\Delphi\\3.0\\experts,

myexpert=\\projects\\myexpert\\expert.dll

rename this entry to \"expert.xxx\". (don\'t delete it, you\'ll need it
later).

Otherwise, you cannot compile a new version.

Run Delphi, open your expert\'s project as used, compile it and set the
break points you think you need.

Go to the menu item run \| parameters. This is the new Delphi 3 feature
mentioned above.

Surprise: the host application is Delphi itself! So, next to the field
\"host app\", enter something like
e:\\Programs\\delphi3\\bin\\delphi32.exe (with path)

Second trick: now we install the expert\... If you have \"expert.xxx\"
installed, rename that to \"expert.dll\". This will be used by any
Delphi instance started from now on.

Run \"your application\" (= Delphi 3) using menu item run \| run.

If you have enough RAM, Delphi is loaded and this instance will have
your expert installed.

Activate the expert, you\'ll have the possibility to use the comfort of
the first instance\'s internal debugger.

Close the right instance of Delphi - and you can modify/ recompile etc.
your expert.

Взято с сайта <https://www.delphifaq.com>
