---
Title: Как прочитать пароль, скрытый за звездочками?
Author: Baa
Date: 01.01.2007
Keywords: password, stars
Description: 
---

Как прочитать пароль, скрытый за звездочками?
=============================================

::: {.date}
01.01.2007
:::

Наверно так: хотя классов может быть больше

    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      Wnd : HWND;
      lpClassName: array [0..$FF] of Char;
    begin
      Wnd := WindowFromPoint(Mouse.CursorPos);
      GetClassName (Wnd, lpClassName, $FF);
      if ((strpas(lpClassName) = 'TEdit') or (strpas(lpClassName) = 'EDIT')) then
        PostMessage (Wnd, EM_SETPASSWORDCHAR, 0, 0);
    end; 

Автор: Baa

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

**Здесь проблема:**  
если страница памяти защищена, то её нельзя прочитать
таким способом, но можно заменить PasswordChar
(пример: поле ввода пароля в удаленном соединении)

Автор: Mikel

Взято с Vingrad.ru <https://forum.vingrad.ru>

