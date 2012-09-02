<h1>Как изменить значение свойства компонента по имени?</h1>
<div class="date">01.01.2007</div>



<pre>
function GetProperty(AControl: TPersistent; AProperty: String): PPropInfo;
var
  i: Integer;
  props: PPropList;
  typeData: PTypeData;
begin
  Result := nil;
  if (AControl = nil) or (AControl.ClassInfo = nil) then
    Exit;
  typeData := GetTypeData(AControl.ClassInfo);
  if (typeData = nil) or (typeData^.PropCount = 0) then
    Exit;
  GetMem(props, typeData^.PropCount * SizeOf(Pointer));
  try
    GetPropInfos(AControl.ClassInfo, props);
    for i := 0 to typeData^.PropCount - 1 do
    begin
      with Props^[i]^ do
        if (Name = AProperty) then
          result := Props^[i];
    end;
  finally
    FreeMem(props);
  end;
end;
 
 
procedure TForm1.Button1Click(Sender: TObject);
var
  propInfo: PPropInfo;
begin
  PropInfo := GetProperty(Button1.Font, 'Name');
  if PropInfo &lt;&gt; nil then
    SetStrProp(Button1.Font, PropInfo, 'Arial');
end;
</pre>

<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>
<hr />You can use RTTI to do this. Here is how to change a particular component:</p>

<pre>
procedure TForm1.BtnClick(Sender: TObject);
var
  p: PPropInfo;
  f: TFont;
begin
  f := TFont.Create;
  {Setup the font properties}
  f.Name := 'Arial';
  p := GetPropInfo(Sender.ClassInfo, 'Font');
  if Assigned(p) then
    SetOrdProp(Sender, p, Integer(f));
  f.Free;
end;
</pre>

<p>To get at all the forms loop through the Screen global variable. For each form loop through its Components list calling the above procedure (or something close). If you only create your components at design time that is it. If you create some at runtime and the owner is not the form, then for each component loop through its Components list recursively to get at all the owned components.</p>


<p>Tip by Jeff Overcash</p>
<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>
<hr />I am building a routine that checks our forms for validity before deploying them. I would like to use some kind of structure that tests if a component type has access to a certain property, something like: " if (self.Controls[b] has Tag) then ...". Can anyone offer suggestions?</p>
<p>Here's an example of setting a string property for a component if it exists and another for an integer property:</p>

<pre>
{
Copyright © 1999 by Delphi 5 Developer's Guide - Xavier Pacheco and Steve Teixeira
}
procedure SetStringPropertyIfExists(AComp: TComponent; APropName: String;
AValue: String);
var
  PropInfo: PPropInfo;
  TK: TTypeKind;
begin
  PropInfo := GetPropInfo(AComp.ClassInfo, APropName);
  if PropInfo &lt;&gt; nil then
  begin
    TK := PropInfo^.PropType^.Kind;
    if (TK = tkString) or (TK = tkLString) or (TK = tkWString) then
      SetStrProp(AComp, PropInfo, AValue);
  end;
end;
 
 
procedure SetIntegerPropertyIfExists(AComp: TComponent; APropName: String;
AValue: Integer);
var
  PropInfo: PPropInfo;
begin
  PropInfo := GetPropInfo(AComp.ClassInfo, APropName);
  if PropInfo &lt;&gt; nil then
  begin
    if PropInfo^.PropType^.Kind = tkInteger then
      SetOrdProp(AComp, PropInfo, AValue);
  end;
end;
</pre>


<p>Tip by Xavier Pacheco</p>
<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>
