---
Title: Как перехватить сообщение об ошибке?
Author: Vit
Date: 01.01.2007
---


Как перехватить сообщение об ошибке?
====================================

::: {.date}
01.01.2007
:::

    try
      {здесь вы пишите код в котором может произойти ошибка}
    except
      on e:Exception do Shwomessage(e.message);
    end

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
