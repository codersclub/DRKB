<h1>Обращение через свойство Controls</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.UpDown1Click(Sender: TObject; Button: TUDBtnType);

var
  I: Integer;
  ChildControl: TControl;
begin
  for I:= 0 to GroupBox1.ControlCount -1 do
  begin
    ChildControl := GroupBox1.Controls[I];
    ChildControl.Top := ChildControl.Top + 15
  end;
end;
</pre>

<p>Проверить тип контрола надо оператором is:</p>
<p>if edit1 is TEdit then....</p>
<p>Затем доступ ко всем свойствам путем приведения класса:</p>
<p>(edit1 as TEdit).text:=''; </p>
<p class="author">Автор: Kiber_rat</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
