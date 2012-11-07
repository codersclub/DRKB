<h1>Как выяснить, имеет ли объект определенное свойство?</h1>
<div class="date">01.01.2007</div>



<pre>
function hasprop(comp: TComponent; const prop: String): Boolean;
var
  proplist: PPropList;
  numprops, i: Integer;
begin
  result := false;
  getmem(proplist, getTypeData(comp.classinfo)^.propcount * Sizeof(Pointer));
  try
    NumProps := getproplist(comp.classInfo, tkProperties, proplist);
    for i := 0 to pred (NumProps) do
    begin
      if comparetext(proplist[i]^.Name, prop) = 0 then
      begin
        result := true;
        break;
      end;
    end;
  finally
    freemem(proplist, getTypeData(comp.classinfo)^.propcount * Sizeof(Pointer));
  end;
end;
 
 
procedure setcomppropstring(comp: TComponent; const prop, s: String);
var
  proplist: PPropList;
  numprops, i: Integer;
begin
  getmem(proplist, getTypeData(comp.classinfo)^.propcount * Sizeof(Pointer));
  try
    NumProps := getproplist(comp.classInfo, tkProperties, proplist);
    for i := 0 to pred (NumProps) do
    begin
      if (comparetext(proplist[i]^.Name, prop) = 0) and
         (comparetext(proplist[i]^.proptype^.name, 'string') = 0 then
      begin
        setStrProp(comp, proplist[i], s);
        break;
      end;
    end;
  finally
    freemem(proplist, getTypeData(comp.classinfo)^.propcount * Sizeof(Pointer));
  end;
end;
</pre>

<p>Взято из <a href="https://www.lmc-mediaagentur.de/dpool" target="_blank">https://www.lmc-mediaagentur.de/dpool</a></p>

<hr />
<pre>
function HasProperty(Obj: TObject; Prop: string): PPropInfo;
begin
  Result := GetPropInfo(Obj.ClassInfo, Prop);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  p: pointer;
begin
  p := HasProperty(Button1, 'Color');
  if p &lt;&gt; nil then
    SetOrdProp(Button1, p, clRed)
  else
    ShowMessage('Button has no color property');
  p := HasProperty(Label1, 'Color');
  if p &lt;&gt; nil then
    SetOrdProp(Label1, p, clRed)
  else
    ShowMessage('Label has no color property');
  p := HasProperty(Label1.Font, 'Color');
  if p &lt;&gt; nil then
    SetOrdProp(Label1.Font.Color, p, clBlue)
  else
    ShowMessage('Label.Font has no color property');
end;
</pre>
<hr />
<pre>
TypInfo.GetPropInfo (My_Component.ClassInfo, 'Hint') &lt;&gt; nil 
</pre>

<p>Таким образом можно узнать наличие таковой published "прОперти". А вот если это не поможет, то можно и "ломиком" поковыряться посредством FieldAddress. Однако этот метод дает адрес полей, которые перечисляются сразу после объявления класса как в unit'ых форм. А вот ежели "прОперть" нигде не "засветилась" (published) то фиг ты ее достанешь.</p>

<p>А модифицировать значение можно посредством прямой записи по адресу FieldAddress (крайне нежелательно!) либо используя цивилизованный способы, перечисленные в unit'е TypInfo.</p>

<p>Модифицировать кучу объектов можно организовав цикл перебора оных с получением в цикле PropertyInfo объекта и записи в объект на основе PropInfo.</p>

<div class="author">Автор: <a href="mailto:Nomadic@newmail.ru" target="_blank">Nomadic</a></div>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
