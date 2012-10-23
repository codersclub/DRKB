<h1>Выставляем горячие клавиши для Delphi приложения</h1>
<div class="date">01.01.2007</div>


<p>Как сделать так, чтобы при минимизации приложения в Tray его можно было вызвать определённой комбинацией клавиш, например Alt-Shift-F9 ?</p>
<pre>
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
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
