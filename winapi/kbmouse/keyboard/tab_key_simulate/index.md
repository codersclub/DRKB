---
Title: Имитация Tab
Date: 01.01.2007
---


Имитация Tab
============

::: {.date}
01.01.2007
:::

    SelectNext(screen.ActiveControl, True, True);

Разместите приведенный код в обработчике одного из собитий. SelectNext -
защищенный метод TWinControl со следующим прототипом:

    procedure SelectNext(CurControl: TWinControl;
    GoForward, CheckTabStop: Boolean);

Так как форма также является потомком TWinControl, то она имеет доступ к
защищенным методам.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
