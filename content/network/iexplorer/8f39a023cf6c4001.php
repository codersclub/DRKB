<h1>Как узнать путь к браузеру по умолчанию?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  Registry; 
 
{....} 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  Reg: TRegistry; 
  KeyName: string; 
  ValueStr: string; 
begin 
  Reg := TRegistry.Create; 
  try 
    Reg.RootKey := HKEY_CLASSES_ROOT; 
    KeyName  := 'htmlfile\shell\open\command'; 
    if Reg.OpenKey(KeyName, False) then 
    begin 
      ValueStr := Reg.ReadString(''); 
      Reg.CloseKey; 
      Label1.Caption := ValueStr; 
    end 
    else 
      ShowMessage('No Default Webbrowser !'); 
  finally 
    Reg.Free; 
  end; 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
