---
Title: Имитация нажатия Tab
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Имитация нажатия Tab
============

Разместите следующий код в обработчике одного из собитий.

    SelectNext(screen.ActiveControl, True, True);

SelectNext - защищенный метод TWinControl со следующим прототипом:

    procedure SelectNext(CurControl: TWinControl;
    GoForward, CheckTabStop: Boolean);

Так как форма также является потомком TWinControl, то она имеет доступ к
защищенным методам.


