---
Title: Как перезагрузить Explorer?
Date: 01.01.2007
---


Как перезагрузить Explorer?
===========================

::: {.date}
01.01.2007
:::

HWND hwndShell;

hwndShell = FindWindow ("Progman", NULL);

PostMessage (hwndShell, WM\_QUIT, 0, 0L);

ShellExecute (0, "open", "Explorer", NULL, NULL, SW\_SHOWNORMAL);
