<h1>Настройки всплывающих подсказок в TDBNavigator</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  ix: integer;
begin
  with DBNavigator1 do
    for ix := 0 to ControlCount - 1 do
      if Controls[ix] is TNavButton then
        with Controls[ix] as TNavButton do
          case index of
            nbFirst: Hint := 'Подсказка для кнопки First';
            nbPrior: Hint := 'Подсказка для кнопки Prior';
            nbNext: Hint := 'Подсказка для кнопки Next';
            nbLast: Hint := '';
            {......}
          end;
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
