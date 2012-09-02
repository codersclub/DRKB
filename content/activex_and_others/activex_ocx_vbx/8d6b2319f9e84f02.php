<h1>Как узнать, установлен ли ActiveX на машине?</h1>
<div class="date">01.01.2007</div>


<pre>
{ ... }
var
  strOLE: string;
begin
  strOLE = "YourCOMServer.Application" {your ProgID}
  if (CLSIDFromProgID(PWideChar(WideString(strOLE), ClassID) = S_OK) then
    begin
      { ... }
    end;
end;
</pre>

<hr />
<pre>
{ ... }
const
  cKEY = '\SOFTWARE\Classes\CLSID\%s\InprocServer32'
  var
  sKey: string;
  sComServer: string;
  exists: boolean;
  Reg: TRegistry;
begin
  Reg := TRegistry.Create;
  try
    Reg.RootKey := HKEY_LOCAL_MACHINE;
    sKey := format(cKEY, [GuidToString(ClassID)]);
    if Reg.OpenKey(sKey, False) then
    begin
      sComServer := Reg.ReadString('');
      if FileExists(sComServer) then
      begin
        { ... }
      end;
    end;
  finally
    Reg.free;
  end;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

