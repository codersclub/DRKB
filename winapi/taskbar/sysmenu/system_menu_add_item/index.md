---
Title: Работа с System Menu
Author: Sheff
Date: 01.01.2007
---

Работа с System Menu
====================

::: {.date}
01.01.2007
:::

Добавить новый пункт меню в системное меню диалога:

    AppendMenu(GetSystemMenu(Self.Handle,FALSE),MF_ENABLED,1001,'&Help'); 

Автор: Sheff

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Отловить клик по меню можно следующим образом:

    private
     
    procedure WhetherUserPressesHelp(var Msg: TMessage); message WM_SYSCOMMAND;
     
    ....
     
      procedure TForm1.WhetherUserPressesHelp(var Msg: TMessage);
      begin
        if Msg.WParam = 1001 then
          HelpForm.ShowModal
        else
          inherited; // к примеру вызываем форму на которой будет помощь
      end;

Автор: Song

Взято с Vingrad.ru <https://forum.vingrad.ru>
