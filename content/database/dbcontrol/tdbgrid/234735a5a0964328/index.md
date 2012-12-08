---
Title: Симуляция нажатия кнопки при наличии TDBGrid
Date: 01.01.2007
---


Симуляция нажатия кнопки при наличии TDBGrid
============================================

::: {.date}
01.01.2007
:::

В случае нажатия клавиши Enter, клавиша по умолчанию не срабатывает,
если у вас на форме расположен компонент DBGrid, но вы можете создать
обработчик события DBGrid OnKeypUp, уведомляющий кнопку по умолчанию о
ее \"нажатии\" при реальном нажатии клавиши Enter. Пример:

    {Код DBGrid OnKeyUp. Default-кнопка - BitBtn1.}
    if Key = VK_RETURN then
    begin
      PostMessage(BitBtn1.Handle, WM_LBUTTONDOWN, Word(0), LongInt(0)) ;
      PostMessage(BitBtn1.Handle, WM_LBUTTONUP, Word(0), LongInt(0)) ;
    end ;

Взято с <https://delphiworld.narod.ru>
