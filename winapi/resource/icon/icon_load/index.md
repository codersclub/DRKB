---
Title: Загрузка иконки
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Загрузка иконки
===============

Если ваша иконка хранится в компоненте Image
(видимым или иным способом), вы можете написать:

    Application.Icon := Image1.Picture.Icon;

Если в файле ресурса:

    Application.Icon.Handle := LoadIcon(hInstance, 'ICONNAME');

В любом случае для форсирования показа иконки необходимо вызвать
следующую функцию:

    InvalidateRect(Application.Handle, NIL, True);

... и новая иконка предстанет свету.

Иконка, расположенная в .RES-файле, должна быть видима в .EXE-файле, к
примеру, при просмотре файла посредством Program Manager. Иконка,
расположенная в компоненте Image, в этом случае не видна.


