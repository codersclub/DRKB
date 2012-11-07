<h1>Как узнать, доступен ли DCOM?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
function IsDCOMEnabled: Boolean;
var
  Ts: string;
  R: TRegistry;
begin
  r := TRegistry.Create;
  r.RootKey := HKEY_LOCAL_MACHINE;
  r.OpenKey('Software\Microsoft\OLE', False);
  ts := AnsiUpperCase(R.ReadString('EnableDCOM'));
  r.Free;
  Result := (Ts = 'Y');
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

<hr />

<pre class="delphi">
function IsDCOMInstalled: Boolean;
var
  OLE32: HModule;
begin
  Result := not (IsWin95 or IsWin95OSR2);
  if not Result then
  begin
    OLE32 := LoadLibrary(COLE32DLL);
    if OLE32 &gt; 0 then
    try
      Result := GetProcAddress(OLE32, PChar('CoCreateInstanceEx')) &lt;&gt; nil;
    finally
      FreeLibrary(OLE32);
    end;
  end;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
