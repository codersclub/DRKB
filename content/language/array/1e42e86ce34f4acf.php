<h1>Использование ассоциативных массивов</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  DataField: TStrings;
begin
  DataField := TStringList.Create; 
  DataField.Add(Format('%s=%s', ['Jonas', '15.03.1980'])); 
  ShowMessage(DataField.Values['Jonas']) 
  // will print the Birthday of Jonas 
  DataField.Free; 
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
