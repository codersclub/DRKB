<h1>Как узнать имена установленных в системе COM-портов?</h1>
<div class="date">01.01.2007</div>



<pre>
uses Registry; 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  reg : TRegistry; 
  ts : TStrings; 
  i : integer; 
begin 
  reg := TRegistry.Create; 
  reg.RootKey := HKEY_LOCAL_MACHINE; 
  reg.OpenKey('hardware\devicemap\serialcomm', 
              false); 
  ts := TStringList.Create; 
  reg.GetValueNames(ts); 
  for i := 0 to ts.Count -1 do begin 
    Memo1.Lines.Add(reg.ReadString(ts.Strings[i])); 
  end; 
  ts.Free; 
  reg.CloseKey; 
  reg.free; 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

