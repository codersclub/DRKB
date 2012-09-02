<h1>Приостановить компьютер (Sleep)</h1>
<div class="date">01.01.2007</div>


<p>У компьютеров ATX есть функция Sleep. Эта программа заставляет компьютер "заснуть". </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  SetSystemPowerState(true, true);
end;
</pre>
<p class="author">Автор советов: Даниил Карапетян</p>
<p>e-mail: delphi4all@narod.ru</p>
<p class="author">Автор справки: Алексей Денисов</p>
<p>e-mail: aleksey@sch103.krasnoyarsk.su</p>
<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Переход в Спящий режим (WinNT)
 
Зависимости: Windows, system
Автор:       DeMoN-777, DeMoN-777@yandex.ru, ICQ:169281983, Санкт-Петербург
Copyright:   @
Дата:        21 сентября 2002 г.
***************************************************** }
 
procedure NTSleep;
var
  hToken: THandle;
  tkp: TTokenPrivileges;
  ReturnLength: Cardinal;
begin
  if OpenProcessToken(GetCurrentProcess(), TOKEN_ADJUST_PRIVILEGES or
    TOKEN_QUERY, hToken) then
  begin
    LookupPrivilegeValue(nil, 'SeShutdownPrivilege', tkp.Privileges[0].Luid);
    tkp.PrivilegeCount := 1; // one privelege to set
    tkp.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED;
    if AdjustTokenPrivileges(hToken, False, tkp, 0, nil, ReturnLength) then
      SetSystemPowerState(true, true);
  end;
end;
</pre>

