<h1>Drag &amp; Drop из TScrollBox</h1>
<div class="date">01.01.2007</div>

Вы можете написать общую функцию для отдельного TImage, и назначать этот метод для каждого динамически создаваемого TImage, примерно так:</p>
<pre>
procedure TForm1.GenericMouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  TImage(Sender).BeginDrag(False);
  {что-то другое, что вы хотели бы сделать}
end;
 
{....}
 
UmpteenthDynImage := TImage.Create(dummyImage);
UmpteenthDynImage.MouseDown := TForm1.GenericMouseDown;
</pre>

<p>Это должно быть синтаксически закрытым. Вы можете просто назначать каждый динамический объект методу GenericMouseDown, и они все им будут пользоваться. Предок dummyImage позволяет легко разрушать все динамические объекты обычным деструктором dummyImage.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
