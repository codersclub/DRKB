<h1>Как завершить сеанс работы или перезагрузить Windows NT?</h1>
<div class="date">01.01.2007</div>


<p>Для этого нам потребуются определённые привелегии:</p>
<pre>
function SetPrivilege(aPrivilegeName : string; 
                      aEnabled : boolean ): boolean; 
var 
  TPPrev, 
  TP         : TTokenPrivileges; 
  Token      : THandle; 
  dwRetLen   : DWord; 
begin 
  Result := False; 
  OpenProcessToken(GetCurrentProcess,TOKEN_ADJUST_PRIVILEGES 
                   or TOKEN_QUERY, @Token ); 
 
  TP.PrivilegeCount := 1; 
  if( LookupPrivilegeValue(nil, PChar( aPrivilegeName ), 
                           TP.Privileges[ 0 ].LUID ) ) then 
  begin 
    if( aEnabled )then 
      TP.Privileges[0].Attributes:= SE_PRIVILEGE_ENABLED; 
    else 
      TP.Privileges[0].Attributes:= 0; 
 
    dwRetLen := 0; 
    Result := AdjustTokenPrivileges(Token,False,TP, 
                                    SizeOf( TPPrev ), 
                                    TPPrev,dwRetLen ); 
  end; 
 
  CloseHandle( Token ); 
end; 
 
 
function WinExit( iFlags : integer ) : boolean; 
//   возможные флаги:
//   EWX_LOGOFF 
//   EWX_REBOOT 
//   EWX_SHUTDOWN 
begin 
  Result := True; 
  if( SetPrivilege( 'SeShutdownPrivilege', true ) ) then 
  begin 
    if( not ExitWindowsEx( iFlags, 0 ) )then 
    begin 
      Result := False; 
    end; 
    SetPrivilege( 'SeShutdownPrivilege', False ) 
  end 
  else 
  begin 
    Result := False; 
  end; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
