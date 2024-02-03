---
Title: Как удалить иконку с Tray?
Date: 01.01.2007
---

Как удалить иконку с Tray?
==========================

::: {.date}
01.01.2007
:::

Для  удаления  иконки  вы  должны  знать  ее  ID  и  дескриптор  
окна-обработчика сообщений.   Для    удаления    иконки   с   Tray  
надо   вызвать   функцию     Shell\_NotifyIcon()   с  параметром 
NIM\_DELETE  и  указателем  на   экземпляр   структуры  NOTIFYICONDATA, 
у  которого  должны  быть  заполнены следующие поля: cbSize, hWnd, uID.

Взято из FAQ:

<https://blackman.km.ru/myfaq/cont4.phtml%5Dhttp://blackman.km.ru/myfaq/cont4.phtml>
