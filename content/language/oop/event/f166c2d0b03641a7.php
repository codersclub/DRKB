<h1>Как получить список всех назначенных событий?</h1>
<div class="date">01.01.2007</div>


<pre>
uses TypInfo;
 
{ .... }
 
procedure TForm1.Button1Click(Sender: TObject);
var 
  x, y, z: Word;
  pl: PPropList;
begin
  y := GetPropList(Self, pl);
  for x := 0 to y - 1 do
  begin
    if Copy(pl[x].Name, 1, 2) &lt;&gt; 'On' then Continue;
    if GetMethodProp(Self, pl[x].Name).Code &lt;&gt; nil then
      Memo1.Lines.Add(Self.Name + ' - ' + pl[x].Name);
  end;
  for z := 0 to Self.ComponentCount - 1 do
  begin
    y := GetPropList(Self.Components[z], pl);
    for x := 0 to y - 1 do
    begin
      if Copy(pl[x].Name, 1, 2) &lt;&gt; 'On' then Continue;
      if GetMethodProp(Self.Components[z], pl[x].Name).Code &lt;&gt; nil then
        Memo1.Lines.Add(Self.Components[z].Name + ' - ' + pl[x].Name);
    end;
  end;
end;
</pre>


<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
