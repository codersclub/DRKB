---
Title: Выставляем горячие клавиши для Delphi приложения
Date: 01.01.2007
---


Выставляем горячие клавиши для Delphi приложения
================================================

::: {.date}
01.01.2007
:::

Как сделать так, чтобы при минимизации приложения в Tray его можно было
вызвать определённой комбинацией клавиш, например Alt-Shift-F9 ?

    //В обработчике события OnCreate
    //основной формы создаём горячую клавишу:
     
    If not RegisterHotkey
       (Handle, 1, MOD_ALT or MOD_SHIFT, VK_F9) Then
        ShowMessage('Unable to assign Alt-Shift-F9 as hotkey.');
     
    //В событии OnClose удаляем горячую клавишу:
     
      UnRegisterHotkey( Handle, 1 );
     
    //Добавляем обработчик в форму для сообщения
    //WM_HOTKEY:
     
      private // в секции объявлений формы
        Procedure WMHotkey( Var msg: TWMHotkey );
          message WM_HOTKEY;
     
    Procedure TForm1.WMHotkey( Var msg: TWMHotkey );
      Begin
        If msg.hotkey = 1 Then Begin
          If IsIconic( Application.Handle ) Then
            Application.Restore;
          BringToFront;
        End;
      End;

Взято с Vingrad.ru <https://forum.vingrad.ru>
