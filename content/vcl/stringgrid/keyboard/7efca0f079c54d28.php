<h1>Tab как Enter в TStringGrid</h1>
<div class="date">01.01.2007</div>

Данный код переводит ввод на другую колонку. При достижении конца колонок, ввод перемещается на следующую строку. При достижении самого конца сетки, управление перемещается в ее самое начало - естественно, вы можете изменить это поведение, и передавать управление в этом случае другому элементу управления.</p>
<pre>
procedure TForm1.StringGrid1KeyPress(Sender: TObject; var Key: Char);
begin
  if Key = #13 then
    with StringGrid1 do
      if Col &lt; ColCount - 1 then {следующая колонка!}
        Col := Col + 1
      else if Row &lt; RowCount - 1 then
      begin {следующая строка!}
        Row := Row + 1;
        Col := 1;
      end
      else
      begin {Конец сетки! - Снова перемещаемся наверх!}
        Row := 1;
        Col := 1;
        {или вы можете передать управление другому элементу управления}
      end;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<pre>
procedure TForm1.StringGrid1KeyPress(Sender: TObject; var Key: Char);
 begin
   if Key = #13 then
     with StringGrid1 do
       if Col then {next column}
         Col := Col + 1
     else if Row then
     begin {next Row}
       Row := Row + 1;
       Col := 1;
     end
      else
     begin {End of Grid- Go to Top again}
       Row := 1;
       Col := 1;
     end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
