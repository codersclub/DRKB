<h1>Можно ли отключить определенный элемент в RadioGroup?</h1>
<div class="date">01.01.2007</div>


<p>В примере показано как получить доступ к отдельным элементам компонента TRadioGroup.</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  TRadioButton(RadioGroup1.Controls[1]).Enabled := False;
end;
</pre>

