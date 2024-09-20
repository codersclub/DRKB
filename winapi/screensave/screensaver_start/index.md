---
Title: Как запустить текущий screensaver?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Как запустить текущий screensaver?
==================================

Вариант 1:

    SendMessage(Application.Handle, WM_SYSCOMMAND, SC_SCREENSAVE, 0);


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Сначала мы проверяем, установлен ли Screen Saver, если нет -
возвращаемся с отрицательным ответом, в противном случае - запускаем его
и возвращаем true.

    function RunScreenSaver: bool;
    var
      b: boolean;
    begin
      result := false;
      if SystemParametersInfo(SPI_GETSCREENSAVEACTIVE, 0, @b, 0) <> true then
        exit;
      if not b then
        exit;
      PostMessage(GetDesktopWindow, WM_SYSCOMMAND, SC_SCREENSAVE, 0);
      result := true;
    end;


