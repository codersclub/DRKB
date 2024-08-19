---
Title: Запретить в выбранном окне кнопку закрытия x
Author: Radmin
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Запретить в выбранном окне кнопку закрытия x
============================================

    EnableMenuItem(GetSystemMenu(FindWindow(Nil, Pchar('Название Окна')),False),
      SC_CLOSE,MF_BYCOMMAND or MF_GRAYED);

