---
Title: Послать Alt+буква другому приложению
Date: 01.01.2007
---

Послать Alt+буква другому приложению
====================================

::: {.date}
01.01.2007
:::

Как мне программно нажать ALT + буква(VK\_\...) в другом приложении.
Хендл я нашел, деляю так

SendMessage(Handle\_, WM\_KEYDOWN, VK\_MENU,0);

SendMessage(Handle\_, WM\_KEYDOWN, VK\_F1,0);

SendMessage(Handle\_, WM\_KEYUP, VK\_F1,0);

но у меня не получается, что не так?

Попробуй так

    SendMessage(Handle,WM_KEYDOWN,Byte(C),$20000001);

Взято из <https://forum.sources.ru>