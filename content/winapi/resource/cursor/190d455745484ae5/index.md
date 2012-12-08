---
Title: Как вставить свой курсор из внешнего файла?
Date: 01.01.2007
---

Как вставить свой курсор из внешнего файла?
===========================================

::: {.date}
01.01.2007
:::

Используя процедуру LoadCursorFromFile

    var
      h: hcursor;
    begin
      h := LoadCursorFromFile('D:\mc.cur');
      Screen.Cursors[1] := h;
      Form1.Cursor := 1;
    end;

------------------------------------------------------------------------

    var h: THandle;
    begin
      h := LoadImage(0, 'c:\Cursor.cur', IMAGE_CURSOR, 0, 0, LR_DEFAULTSIZE or
        LR_LOADFROMFILE);
      if h = 0 then
        ShowMessage('Cursor not loaded!!!')
      else
        begin
          Screen.Cursors[1] := h;
          Form1.Cursor := 1;
        end;
    end;

------------------------------------------------------------------------

Этот пример позволяет также использовать анимированные курсоры (\*.ani)!

Вот кусок кода для загрузки анимированного курсора, который можно
вставить в обработку события активизации формы :

    var
      h: THandle;
      name: array[0..255] of char;
    begin
      StrPCopy(name, 'Animcurs.ani');
      h := LoadImage(0, name, IMAGE_CURSOR, 0, 0, LR_DEFAULTSIZE or
        LR_LOADFROMFILE);
      if h <> 0 then
        begin
          Screen.Cursors[1] := h;
          Screen.Cursor := 1;
        end
      else
        Screen.Cursor := crDefault;
    end;

Взято с сайта <https://blackman.wp-club.net/>
