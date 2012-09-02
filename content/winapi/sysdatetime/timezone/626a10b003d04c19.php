<h1>Как получить список часовых поясов?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  Registry;
 
...
 
var
  reg : TRegistry;
  ts : TStrings;
  i : integer;
begin
  reg := TRegistry.Create;
  reg.RootKey := HKEY_LOCAL_MACHINE;
  reg.OpenKey('SOFTWARE\Microsoft\Windows\CurrentVersion\Time Zones', false);
  if reg.HasSubKeys then
  begin
    ts := TStringList.Create;
    reg.GetKeyNames(ts);
    reg.CloseKey;
    for i := 0 to ts.Count -1 do
    begin
      reg.OpenKey('SOFTWARE\Microsoft\Windows\CurrentVersion\Time Zones\' + ts.Strings[i], false);
      Memo1.Lines.Add(ts.Strings[i]);
      Memo1.Lines.Add(reg.ReadString('Display'));
      Memo1.Lines.Add(reg.ReadString('Std'));
      Memo1.Lines.Add(reg.ReadString('Dlt'));
      Memo1.Lines.Add('----------------------');
      reg.CloseKey;
    end;
    ts.Free;
  end
  else
    reg.CloseKey;
  reg.free;
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
