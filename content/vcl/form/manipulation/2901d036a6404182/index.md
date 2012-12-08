---
Title: Как сделать плавное закрытие окна?
Author: p0s0l
Date: 01.01.2007
---


Как сделать плавное закрытие окна?
==================================

::: {.date}
01.01.2007
:::

Работает в 2k/XP:

    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);

    begin
     AnimateWindow(Handle, 500, AW_HIDE or AW_BLEND);
    end; 

Автор: p0s0l

Взято с Vingrad.ru <https://forum.vingrad.ru>
