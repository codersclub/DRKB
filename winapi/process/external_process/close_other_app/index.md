---
Title: Как можно из своей программы закрыть чужую?
Author: Fantasist
Date: 01.01.2007
---

Как можно из своей программы закрыть чужую?
===========================================

::: {.date}
01.01.2007
:::

    PostThreadMessage(AnotherProg_MainThreadID,WM_CLOSE,0,0);
    PostMessage(AnotherProg_MainWindow,WM_CLOSE,0,0);

Автор: Fantasist

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

[https://delphi.mastak.ru/download/255.zip](https://delphi.mastak.ru/download/255.zip%20)

Автор: LENIN INC

Взято с Vingrad.ru <https://forum.vingrad.ru>
