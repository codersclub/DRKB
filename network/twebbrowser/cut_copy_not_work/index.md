---
Title: Cut и Copy отказываются работать
Author: Song
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Cut и Copy отказываются работать
================================

Вам нужно добавить следующие строки в конец unit:

    initialization
      OleInitialize(nil);
    finalization
      OleUninitialize;

