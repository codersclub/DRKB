---
Title: Как послать сообщение всем окнам Windows?
Author: Andrey Burov
Date: 01.01.2007
---


Как послать сообщение всем окнам Windows?
=========================================

::: {.date}
01.01.2007
:::

    Var
    FM_FINDPHOTO: Integer;
    // Для использовать hwnd_Broadcast нужно сперва
    // зарегистрировать уникальное сообщение
    Initialization
    FM_FindPhoto:=RegisterWindowMessage('MyMessageToAll');
    // Чтобы поймать это сообщение в другом приложении
    //(приемнике) нужно перекрыть DefaultHandler
    procedure TForm1.DefaultHandler(var Message);
    begin
     with TMessage(Message) do
     begin
       if Msg = Fm_FindPhoto then MyHandler(WPARAM,LPARAM)  else
       Inherited DefaultHandler(Message);
     end;
     
    end;
     
    // А тепрь можно
    SendMessage(HWND_BROADCAST,FM_FINDPHOTO,0,0);

Кстати, для посылки сообщения дочерним контролам некоего контрола можно
использовать метод Broadcast.

Автор: Andrey Burov

(2:463/238.19)

Автор: StayAtHome

Взято с Vingrad.ru <https://forum.vingrad.ru>
