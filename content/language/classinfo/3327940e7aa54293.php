<h1>Как сделать текстовый список всех доступных свойств перечисляемого типа?</h1>
<div class="date">01.01.2007</div>



<p>I need to get a list of strings (like a StringList) with the possible values for a TBrushStyle property (bsSolid, bsClear, bsHorizontal, for example). I want to build a ComboBox with this options. How can I set the property Items of my ComboBox directly with all the values from the enumerated type TBrushStyle? My ComboBox will be alike the Property Editor for this type.</p>

<p>You can use runtime type information (RTTI) to do that. Below is an example:</p>

<pre>
uses 
  {...}, TypInfo
 
procedure BrushStylesAsStrings(AList: TStrings);
var
  a: integer;
  pInfo: PTypeInfo;
  pEnum: PTypeData;
begin
  AList.Clear;
  pInfo := PTypeInfo(TypeInfo(TBrushStyle));
  pEnum := GetTypeData(pInfo);
  with pEnum^ do
  begin
    for a := MinValue to MaxValue do
      AList.Add(GetEnumName(pInfo, a));
  end;
end; 
</pre>

<p>Tip by Sen</p>
<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>
