---
Title: Асинхронная ошибка
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Асинхронная ошибка
==================

> Вопрос: Почему не работает следующий код?
> 
>     begin
>       ClietnSocket1.Open;
>       if ClietnSocket1.Socket.Connected then
>         ClietnSocket1.Socket.SendText('Hello');
>       {..}
>     end;
>     // Выдает - ассинхронная ошибка.

Вы работаете в **ассинхронном режиме**.
Следует использовать соответствующие события!

