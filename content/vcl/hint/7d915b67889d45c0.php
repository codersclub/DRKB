<h1>Всплывающие подсказки у выключенных кнопок</h1>
<div class="date">01.01.2007</div>

<p>Проблема заключается в том, что свойство Parent у выключенной (disabled) кнопки равно NIL. Я не уверен что это так, но это становится проблемой в ActivateHint. Если кнопка выключена, то даже при наличии над ней курсора мыши и включенной подсказки, появится.... правильно, подсказка ФОРМЫ.... </p>
<p>OK, давайте лечить. Метод FindDragTarget вызывается в коде-обработчике подсказки, и позволяет увидеть компонент, находящийся в данный момент под курсорм мыши. FindDragTarget вызывает функцию Windows API WindowFromPoint. И WindowFromPoint *НЕ* возвращает "выключенные" окна. В электронной справке по API говорится, что если вам необходимы также выключенные окна, используйте ChildWindowFromPoint. ОГО! Это идея. Если элемент управления выключен, то будет найдена или сама форма, или же контейнер выключенного компонента. Если компонент, найденый с помощью ChildWindowFromPoint отличается от найденного с помощью WindowFromPoint, мы должны высветить подсказку. Это работает! Но хочу предостеречь: вы не сможете таким образом получить подсказку для самой формы или контейнеров типа TPanel или TGroupBox. Попытайтесь сами!</p>
<pre>
procedure TForm1.AppShowHint(var HintStr: string;
  var CanShow: Boolean; var HintInfo: THintInfo);
var
  PT: TPoint;
  H: HWnd;
  TWC: TWinControl;
begin
  if not (HintInfo.HintControl is TWinControl) then
    Exit;
  GetCursorPos(PT);
  PT := HintInfo.HintControl.ScreenToClient(PT);
  H := ChildWindowFromPoint(TWinControl(HintInfo.HintControl).Handle, PT);
  TWC := FindControl(H);
  if TWC = nil then
    Exit;
  if TWC = Self then
    CanShow := False
  else if TWC = HintInfo.HintControl then
    exit(эту строку добавил Tim Frost}
  else if TWC.ControlCount &gt; 0 then
    CanShow := False
  else
    with TWC do
      if ShowHint and (Hint &lt;&gt; '') then
      begin
        HintStr := '(выключен) ' + Hint;
        HintInfo.HintPos := ClientOrigin;
        Inc(HintInfo.HintPos.Y, Height + 6);
      end;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  Application.OnShowHint := AppShowHint;
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

