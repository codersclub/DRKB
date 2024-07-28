---
Title: Как заставить системное меню выпасть в указанном месте?
Date: 01.01.2007
---


Как заставить системное меню выпасть в указанном месте?
=======================================================

> Как вызвать всплывающее системное меню Windows?

Вы можете использовать Keybd_event для эмуляции ALT+SPACE.
Возможно, вы можете использовать TPopupmenu.
Но с ними всегда есть какие-то проблемы.

Приведённый ниже метод — идеальное решение!

Кстати: если у вашей формы `borderstyle = bsNone`, сделайте это так:

Установите стиль формы = bsSingle; и используйте код ниже,
чтобы установить границу формы:

```delphi
SetWindowLong(Handle, GWL_STYLE, GetWindowLong(Handle, GWL_STYLE)
  and (not WS_CAPTION) or WS_DLGFRAME or WS_OVERLAPPED);
```

    {
      How to popup the windows system menu?
      Maybe you can use Keybd_event to eumlate ALT+SPACE
      Maybe you can use a TPopupmenu.
      But they always have some problem.
      The method below is a perfect solution!
      BTW: if your form has borderstyle = bsNone, Please do it like this:
      Set forms style = bsSingle; and use the code below to set form boder:
      SetWindowLong(Handle, GWL_STYLE,GetWindowLong(Handle, GWL_STYLE)
      and (not WS_CAPTION) or WS_DLGFRAME or WS_OVERLAPPED);
    }
     
    procedure TForm1.Button1Click(Sender: TObject);
    const
      { Undocument message ID }
      WM_POPUPSYSTEMMENU = $313;
    begin
      SendMessage(Handle, WM_POPUPSYSTEMMENU, 0,
      MakeLong(Mouse.CursorPos.X, Mouse.CursorPos.Y));
    end;
     
