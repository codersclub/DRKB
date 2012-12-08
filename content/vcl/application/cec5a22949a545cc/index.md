---
Title: Как сворачивать все приложение при сворачивании неглавного окна?
Author: Alex
Date: 01.01.2007
---


Как сворачивать все приложение при сворачивании неглавного окна?
================================================================

::: {.date}
01.01.2007
:::

     
        procedure WMActivateApp(var Msg: TWMActivateApp); message WM_ACTIVATEAPP;
        procedure WMSysCommand(var Msg: TWMSysCommand); message WM_SYSCOMMAND;
     

     
    ...
    procedure Form2.WMActivateApp(var Msg: TWMActivateApp);
    begin
      if IsIconic(Application.Handle) then begin
        ShowWindow(Application.Handle, SW_RESTORE);
        SetActiveWindow(Handle);
      end;
      inherited;
    end;
     
    procedure Form2.WMSysCommand(var Msg: TWMSysCommand);
    begin
      if (Msg.CmdType = SC_Minimize) then
        ShowWindow(Application.Handle, SW_MINIMIZE)
      else
        inherited;
    end;
     

Теперь при сворачивании формы сворачиваеться все приложение.

Автор: Alex

Взято с Vingrad.ru <https://forum.vingrad.ru>
