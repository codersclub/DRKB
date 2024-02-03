---
Title: Как программно вызвать окно "Завершение работы Windows"?
Date: 01.01.2007
---


Как программно вызвать окно "Завершение работы Windows"?
======================================================

::: {.date}
01.01.2007
:::

    SendMessage (FindWindow ('Progman', 'Program Manager'), WM_CLOSE, 0, 0);

Взято из <https://forum.sources.ru>
