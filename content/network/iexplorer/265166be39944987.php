<h1>Как узнать версию IE?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  Registry; 
 
function GetIEVersion(Key: string): string; 
var 
  Reg: TRegistry; 
begin 
  Reg := TRegistry.Create; 
  try 
    Reg.RootKey := HKEY_LOCAL_MACHINE; 
    Reg.OpenKey('Software\Microsoft\Internet Explorer', False); 
    try 
      Result := Reg.ReadString(Key); 
    except 
      Result := ''; 
    end; 
    Reg.CloseKey; 
  finally 
    Reg.Free; 
  end; 
end; 
 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  ShowMessage('IE-Version: ' + GetIEVersion('Version')[1] + '.' + GetIEVersion('Version')[3]); 
  ShowMessage('IE-Version: ' + GetIEVersion('Version')); 
  // &lt;major version&gt;.&lt;minor version&gt;.&lt;build number&gt;.&lt;sub-build number&gt; 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
