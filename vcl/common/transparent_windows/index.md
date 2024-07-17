---
Title: Как правильно работать с прозрачными окнами?
Source: Vingrad.ru <https://forum.vingrad.ru>
Author: Andrei Bogomolov (admin@cardy.hypermart.net)
Date: 01.01.2007
---


Как правильно работать с прозрачными окнами?
============================================

> Как правильно работать с прозрачными окнами (стиль WS\_EX\_TRANSPARENT)?

Стиль окна-формы указывается в CreateParams. Только вот когда
перемещаешь его, фон остается со старым куском экрана. Чтобы этого не
происходило, то когда pисуешь своё окно, запоминай, что было под ним,а
пpи пеpемещении восстанавливай.

тебе поможет:

    HDC hDC = GetDC(GetDesktopWindow())

--  
Andrei Bogomolov  
admin@cardy.hypermart.net  
https://cardy.hypermart.net  
ICQ UIN:7329451  
e-pager: 7329451@pager.mirabilis.com  
(2:5013/11.3)

