---
Title: Как программно вызвать окно "Завершение работы Windows"?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как программно вызвать окно "Завершение работы Windows"?
======================================================

    SendMessage (FindWindow ('Progman', 'Program Manager'), WM_CLOSE, 0, 0);

