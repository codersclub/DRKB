<h1>Как определить день недели?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  d: TDateTime;
begin
  d := StrToDate(Edit1.Text);
  ShowMessage(FormatDateTime('dddd',d));
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
<hr /><p> 
<p>Функции DayOfTheWeek и DayOfWeek (см. справку по Дельфи)</p>
<div class="author">Автор: Vit</div>
<p> 
<p></p>
