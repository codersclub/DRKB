---
Title: Cut и Copy отказываются работать
Author: Song
Date: 01.01.2007
---


Cut и Copy отказываются работать
================================

::: {.date}
01.01.2007
:::

Вам нужно добавить следующие строки в конец unit:

    initialization
      OleInitialize(nil);
    finalization
      OleUninitialize;

Автор: Song

Взято из <https://forum.sources.ru>
