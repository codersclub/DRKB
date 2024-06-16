---
Title: Заполняем Canvas рисунком с рабочего стола, учитывая координаты
Date: 01.01.2007
Author: Зайцев О.В., Владимиров А.М.
Source: <https://forum.sources.ru>
---


Заполняем Canvas рисунком с рабочего стола, учитывая координаты
===============================================================

    Function PaintDesktop(HDC) : boolean;

Например:

    PaintDesktop(form1.Canvas.Handle);

