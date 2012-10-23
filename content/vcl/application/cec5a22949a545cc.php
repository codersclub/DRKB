<h1>Как сворачивать все приложение при сворачивании неглавного окна?</h1>
<div class="date">01.01.2007</div>


<pre>
 
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
 
</pre>

<p>Теперь при сворачивании формы сворачиваеться все приложение.</p>
<div class="author">Автор: Alex </div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
