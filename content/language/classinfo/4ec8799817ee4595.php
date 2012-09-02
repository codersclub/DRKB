<h1>Как определить, насдледовано ли свойство от определенного класса?</h1>
<div class="date">01.01.2007</div>


<pre>
function GetFontProp(anObj: TObject): TFont;
var
  PInfo: PPropInfo;
begin
  {Try to get a pointer to the property information for a property with the name 'Font'.
  TObject.ClassInfo returns a pointer to the RTTI table, which we need to pass to GetPropInfo}
  PInfo := GetPropInfo(anObj.ClassInfo, 'font');
  Result := nil;
  if PInfo &lt;&gt; nil then
    {found a property with this name, check if it has the correct type}
    if (PInfo^.Proptype^.Kind = tkClass) and
      GetTypeData(PInfo^.Proptype^)^.ClassType.InheritsFrom(TFont)
      then
      Result := TFont(GetOrdProp(anObj, PInfo));
end;
</pre>

<p>Tip by Peter Below</p>
<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>
