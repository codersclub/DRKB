---
Title: Асинхронная ошибка
Date: 01.01.2007
---


Асинхронная ошибка
==================

::: {.date}
01.01.2007
:::

Вопрос: Почему не работает следующий код?

         begin
           ClietnSocket1.Open;
           if ClietnSocket1.Socket.Connected then
             ClietnSocket1.Socket.SendText('Hello');
           {..}
         end;
         // Выдает - ассинхронная ошибка.

Вы работаете в ассинхронном режиме. Следует использовать соответсвующие
события.

Взято с <https://delphiworld.narod.ru>
