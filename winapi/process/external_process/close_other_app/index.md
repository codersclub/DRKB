---
Title: Как можно из своей программы закрыть чужую?
Date: 01.01.2007
---

Как можно из своей программы закрыть чужую?
===========================================

Вариант 1:

@Drkb::02094

Author: Fantasist

Source: Vingrad.ru <https://forum.vingrad.ru>

    PostThreadMessage(AnotherProg_MainThreadID,WM_CLOSE,0,0);
    PostMessage(AnotherProg_MainWindow,WM_CLOSE,0,0);

------------------------------------------------------------------------

Вариант 2:

Author: LENIN INC

@Drkb::02095

Source: Vingrad.ru <https://forum.vingrad.ru>

<https://delphi.mastak.ru/download/255.zip>


