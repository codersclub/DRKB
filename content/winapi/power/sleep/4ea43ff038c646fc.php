<h1>Поддерживает ли система suspend?</h1>
<div class="date">01.01.2007</div>


<pre>
function SuspendAllowed: Boolean;
type
  TIsPwrSuspendAllowed = function: Boolean;
  stdcall;
var
  hPowrprof: HMODULE;
  IsPwrSuspendAllowed: TIsPwrSuspendAllowed;
begin
  Result := False;
  hPowrprof := LoadLibrary('powrprof.dll');
  if hPowrprof &lt;&gt; 0 then
  begin
    try
      @IsPwrSuspendAllowed := GetProcAddress(hPowrprof, 'IsPwrSuspendAllowed');
      if @IsPwrSuspendAllowed &lt;&gt; nil then
      begin
        Result := IsPwrSuspendAllowed;
      end;
    finally
      FreeLibrary(hPowrprof);
    end;
  end;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>


