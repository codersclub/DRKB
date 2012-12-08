---
Title: Как инициализировать BDE, если она установлена в нестандартном месте?
Date: 01.01.2007
---


Как инициализировать BDE, если она установлена в нестандартном месте?
=====================================================================

::: {.date}
01.01.2007
:::

I need to use a BDE that is placed in another directory than default.
How can I do it? DbiInit(pDbiEnv) doesn\'t work when pDbiEnv \< \> nil
(not default).

Answer:

    pDbiEnv := nil;
    check(DbiInit(pDbiEnv));

or if you don\'t need the pointer simply

check(DbiInit(nil));

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
