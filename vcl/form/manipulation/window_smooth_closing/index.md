---
Title: Как сделать плавное закрытие окна?
Author: p0s0l
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как сделать плавное закрытие окна?
==================================

Работает в 2k/XP:

    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);

    begin
     AnimateWindow(Handle, 500, AW_HIDE or AW_BLEND);
    end; 

