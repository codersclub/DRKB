<h1>Выбор строки или колонки компонента TStringGrid</h1>
<div class="date">01.01.2007</div>

Автор: Neil J. Rubenking</p>
<p>Вот функция, выбирающая при нажатии на кнопку первую строку сетки. Это работает независимо от размера сетки и количества фиксированных строк/колонок.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  NewSel: TGridRect;
begin
  with StringGrid1 do
  begin
    NewSel.Left := FixedCols;
    NewSel.Top := FixedRows;
    NewSel.Right := ColCount - 1;
    NewSel.Bottom := FixedRows;
    Selection := NewSel;
  end;
end;
 
 
 
 
 StringGrid1.Row := номер строки от нуля;
 StringGrid1.Col := номер столбца от нуля;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
