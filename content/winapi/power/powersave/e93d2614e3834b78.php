<h1>Поддерживает ли система Hibernation?</h1>
<div class="date">01.01.2007</div>


<pre>
function HibernateAllowed: Boolean;
type
  TIsPwrHibernateAllowed = function: Boolean;
  stdcall;
var
  hPowrprof: HMODULE;
  IsPwrHibernateAllowed: TIsPwrHibernateAllowed;
begin
  Result := False;
  if IsNT4Or95 then Exit;
  hPowrprof := LoadLibrary('powrprof.dll');
  if hPowrprof &lt;&gt; 0 then
  begin
    try
      @IsPwrHibernateAllowed := GetProcAddress(hPowrprof, 'IsPwrHibernateAllowed');
      if @IsPwrHibernateAllowed &lt;&gt; nil then
      begin
        Result := IsPwrHibernateAllowed;
      end;
    finally
      FreeLibrary(hPowrprof);
    end;
  end;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

