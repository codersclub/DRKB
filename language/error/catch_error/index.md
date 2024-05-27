---
Title: Как перехватить сообщение об ошибке?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как перехватить сообщение об ошибке?
====================================

    try
      {здесь вы пишете код, в котором может произойти ошибка}
    except
      on e:Exception do Shwomessage(e.message);
    end

