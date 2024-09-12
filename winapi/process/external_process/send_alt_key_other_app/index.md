---
Title: Послать Alt+буква другому приложению
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Послать Alt+буква другому приложению
====================================

Вопрос:

> Как мне программно нажать ALT + буква(VK\_...) в другом приложении?  
> Хендл я нашел, делаю так:
> 
>     SendMessage(Handle_, WM_KEYDOWN, VK_MENU,0);
>     SendMessage(Handle_, WM_KEYDOWN, VK_F1,0);
>     SendMessage(Handle_, WM_KEYUP, VK_F1,0);
> 
> но у меня не получается, что не так?

**Ответ:**

Попробуй так

    SendMessage(Handle,WM_KEYDOWN,Byte(C),$20000001);

