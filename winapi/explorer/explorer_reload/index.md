---
Title: Как перезагрузить Explorer?
Date: 01.01.2007
---


Как перезагрузить Explorer?
===========================

HWND hwndShell;

    hwndShell = FindWindow ('Progman', NULL);

    PostMessage (hwndShell, WM_QUIT, 0, 0L);

    ShellExecute (0, 'open', 'Explorer', NULL, NULL, SW_SHOWNORMAL);
