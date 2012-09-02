<h1>Как присвоить все значения полей одного класса другому такому же классу?</h1>
<div class="date">01.01.2007</div>



<p>How can I assign all property values (or if it's not possible only published property values, or some of them) of one class (TComponent) to another instance of the same class? What I want to do is:</p>

<pre>
MyComponent1.{property1} := MyComponent2.{property1};
{...}
MyComponent2.{propertyN} := MyComponent2.{propertyN};
</pre>

<p>Is there a better and shorter way to do this? I tried this: MyComponent1 := MyComponent2; But it doesn't work. Why not? Can I point to the second component ?</p>

<p>Answer 1:</p>

<p>MyComponent2 and MyComponent1 are pointers to your components, and this kind of assigment leads to MyComponent1 pointing to MyComponent2. But it will not copy its property values.</p>

<p>A better way is to override the assign method of your control, do all property assignment there and call it when you need to copy component attributes. Here's example:</p>

<pre>
procedure TMyComponent.Assign(Source: TPersistent);
begin
  if Source is TMyComponent then
  begin
    property1 := TMyComponent(Source).property1;
    { ... }
  end
  else
    inherited Assign(Source);
end;
</pre>

<p>To assign properties you'll need to set this line in the code:</p>

<p>MyComponent1.Assign(MyComponent2);</p>

<p>Tip by Serge Gubenko</p>
<hr />
<pre>
procedure EqualClassProperties(AClass1, AClass2: TObject);
var
  PropList: PPropList;
  ClassTypeInfo: PTypeInfo;
  ClassTypeData: PTypeData;
  i: integer;
  NumProps: Integer;
  APersistent : TPersistent;
begin
  if AClass1.ClassInfo &lt;&gt; AClass2.ClassInfo then
    exit;
  ClassTypeInfo := AClass1.ClassInfo;
  ClassTypeData := GetTypeData(ClassTypeInfo);
  if ClassTypeData.PropCount &lt;&gt; 0 then
  begin
    GetMem(PropList, SizeOf(PPropInfo) * ClassTypeData.PropCount);
    try
      GetPropInfos(AClass1.ClassInfo, PropList);
      for i := 0 to ClassTypeData.PropCount - 1 do
        if not (PropList[i]^.PropType^.Kind = tkMethod) then
          {if Class1,2 is TControl/TWinControl on same form, its names must be unique}
          if PropList[i]^.Name &lt;&gt; 'Name' then
            if (PropList[i]^.PropType^.Kind = tkClass) then
            begin
              APersistent := TPersistent(GetObjectProp(AClass1, PropList[i]^.Name, TPersistent));
            if APersistent &lt;&gt; nil then
              APersistent.Assign(TPersistent(GetObjectProp(AClass2, PropList[i]^.Name, TPersistent)))
            end
            else
              SetPropValue(AClass1, PropList[i]^.Name, GetPropValue(AClass2, PropList[i]^.Name));
    finally
      FreeMem(PropList, SizeOf(PPropInfo) * ClassTypeData.PropCount);
    end;
  end;
end;
</pre>

<p>Note that this code skips object properties inherited other than TPersistent.</p>

<p>Tip by Gokhan Ersumer</p>
<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>
