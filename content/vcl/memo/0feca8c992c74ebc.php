<h1>Сортировка строк в TMemo</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button3Click(Sender: TObject);
var
  t: TStringList;
begin
  // создаем
  t:=TStringList.Create;
  // присваиваем переменной t строки из Memo
  t.AddStrings(memo1.lines);
  // сортируем
  t.Sort;
  memo1.Clear;
  // присваиваем memo уже отсортированные строки
  memo1.Lines.AddStrings(t);
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
