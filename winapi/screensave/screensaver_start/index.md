---
Title: Как запустить текущий screensaver?
Date: 01.01.2007
---

Как запустить текущий screensaver?
==================================

::: {.date}
01.01.2007
:::

SendMessage(Application.Handle, WM\_SYSCOMMAND, SC\_SCREENSAVE, 0);

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
