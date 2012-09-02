<h1>Как установить переменные окружения?</h1>
<div class="date">01.01.2007</div>


<p>Следующая простая подпрограмма создаёт новые значения в переменных окружения. Если переменной окружения не существует, то она создаётся. Если переменной окружения установить значение пустой строки, то переменная удаляется. Функция возвращает 0, если значение переменной установлено или переменная создана успешно, либо возвратит значение ошибки Windows вслучае неудачи. Обратите внимание, что размер пространства доступного для переменных окружения ограничен.</p>
<pre>
function SetEnvVarValue(const VarName, 
  VarValue: string): Integer; 
begin 
  // Просто вызываем API функцию
  if Windows.SetEnvironmentVariable(PChar(VarName), 
    PChar(VarValue)) then 
    Result := 0 
  else 
    Result := GetLastError; 
end;
</pre>


<p>ЗАМЕЧАНИЕ: данный способ позволяет делать изменения в переменных окружения только для текущего процесса либо для дочерних процессов, порождённых текущим.</p>

<p>Для того, чтобы передать какую-либо переменную окружения в дочерний процесс просто:</p>

<p>1) Создайте новую переменную окружения при помощи SetDOSEnvVar.</p>
<p>2) Запустите новую программу.</p>

<p>А вот как выглядит пример передачи текущих переменных окружения + переменной FOO=Bar в дочерний процесс:</p>
<pre>
{ snip ... } 
var 
  ErrCode: Integer; 
begin 
  ErrCode := SetEnvVarValue('FOO', 'Bar'); 
  if ErrCode = 0 then 
    WinExec('MyChildProg.exe', SW_SHOWNORMAL); 
  else 
    ShowMessage(SysErrorMessage(ErrCode)); 
end; 
{ ... end snip }
</pre>



<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />
<pre>
{*********************************************}
{ Set Global Environment Function             }
{ Coder : Kingron,2002.8.6                    }
{ Bug Report : Kingron@163.net                }
{ Test OK For Windows 2000 Advance Server     }
{ Parameter:                                  }
{ Name : environment variable name            }
{ Value: environment variable Value           }
{ Ex: SetGlobalEnvironment('MyVar','OK')      }
{*********************************************}
 
function SetGlobalEnvironment(const Name, Value: string;
  const User: Boolean = True): Boolean;
resourcestring
  REG_MACHINE_LOCATION = 'System\CurrentControlSet\Control\Session Manager\Environment';
  REG_USER_LOCATION = 'Environment';
begin
  with TRegistry.Create do
    try
      if User then { User Environment Variable }
        Result := OpenKey(REG_USER_LOCATION, True)
      else { System Environment Variable }
      begin
        RootKey := HKEY_LOCAL_MACHINE;
        Result  := OpenKey(REG_MACHINE_LOCATION, True);
      end;
      if Result then
      begin
        WriteString(Name, Value); { Write Registry for Global Environment }
        { Update Current Process Environment Variable }
        SetEnvironmentVariable(PChar(Name), PChar(Value));
        { Send Message To All Top Window for Refresh }
        SendMessage(HWND_BROADCAST, WM_SETTINGCHANGE, 0, Integer(PChar('Environment')));
      end;
    finally
      Free;
    end;
end; { SetGlobalEnvironment }
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

