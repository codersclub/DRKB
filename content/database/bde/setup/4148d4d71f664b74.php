<h1>Как узнать версию BDE?</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
uses 
  BDE; 
 
{Without the Registry:} 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  ThisVersion: SYSVersion; 
begin 
  DbiGetSysVersion(ThisVersion); 
  ShowMessage('BORLAND DATABASE ENGINE VERSION = ' + IntToStr(ThisVersion.iVersion)); 
end; 
 
{With the Registry:} 
 
function GetBDEVersion: string; 
var 
  h: hwnd; 
  ptr: Pointer; 
  proc: TSYSVerProc; 
  ver: SYSVersion; 
  idapi: string; 
  reg: TRegistry; 
begin 
  try 
    reg.RootKey := HKEY_CLASSES_ROOT; 
    reg.OpenKey('CLSID\{FB99D710-18B9-11D0-A4CF-00A024C91936}\InProcServer32', False); 
    idapi := reg.ReadString(''); 
    reg.CloseKey; 
  finally 
    reg.Free; 
  end; 
  Result := '&lt;BDE Bulunamadi&gt;'; 
  h      := LoadLibrary(PChar(idapi)); 
  if h &lt;&gt; 0 then  
    try 
      ptr := GetProcAddress(h, 'DbiGetSysVersion'); 
      if ptr &lt;&gt; nil then  
      begin 
        proc := ptr; 
        Proc(Ver); 
        Result := IntToStr(ver.iVersion); 
        Insert('.', Result, 2); 
      end; 
    finally 
      FreeLibrary(h); 
    end; 
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

