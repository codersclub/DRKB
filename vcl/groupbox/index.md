---
Title: Как заставить TGroupBox прорисовать на форме свой Caption неактивным цветом?
Author: Гавриш Дмитрий
Source: <https://delphiworld.narod.ru>
Date: 01.01.2007
---


Как заставить TGroupBox прорисовать на форме свой Caption неактивным цветом?
============================================================================

> Как заставить GroupBox1 прорисовать на форме свой Caption неактивным
> цветом? GroupBox1.Enabled:=FALSE не помогает. Хотя если то же самое
> проделать с Label1 или Edit1, то все получается.

Вот так:

    GroupBox1.Font.color:=clInactiveCaption;
