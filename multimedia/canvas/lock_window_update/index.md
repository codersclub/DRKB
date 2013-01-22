---
Title: Как временно отключить перерисовку окна?
Date: 01.01.2007
---


Как временно отключить перерисовку окна?
========================================

::: {.date}
01.01.2007
:::

Вызовите функцию WinAPI LockWindowUpdate передав ей дескриптор окна,
которое необходимо не обновлять. Передайте ноль в качестве параметра для
восстановления нормального обновления.

    LockWindowUpdate(Memo1.Handle); 
    ... 
     
    LockWindowUpdate(0); 