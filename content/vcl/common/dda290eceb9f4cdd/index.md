---
Title: Как правильно работать с прозрачными окнами?
Author: StayAtHome
Date: 01.01.2007
---


Как правильно работать с прозрачными окнами?
============================================

::: {.date}
01.01.2007
:::

Как правильно работать с прозрачными окнами (стиль WS\_EX\_TRANSPARENT)?

Стиль окна-формы указывается в CreateParams. Только вот когда
перемещаешь его, фон остается со старым куском экрана. Чтобы этого не
происходило, то когда pисуешь своё окно, запоминай, что было под ним,а
пpи пеpемещении восстанавливай.

HDC hDC = GetDC(GetDesktopWindow()) тебе поможет..

Andrei Bogomolov

https://cardy.hypermart.net

ICQ UIN:7329451

admin\@cardy.hypermart.net

e-pager: 7329451\@pager.mirabilis.com

(2:5013/11.3)

Автор: StayAtHome

Взято с Vingrad.ru <https://forum.vingrad.ru>
