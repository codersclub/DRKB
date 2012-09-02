<h1>Ограничение длины поля TStringGrid</h1>
<div class="date">01.01.2007</div>

Вероятно, это не очень эффективное решение, но оно будет работать: поместите следующий код в обработчик события onKeyPress:</p>
<pre>
if key &lt;&gt; #8 then 
begin {допускаем backspace/Del}
  len := length(grid.cells[grid.col, grid.row]);
  if len &gt;= ваша желаемая максимальная длина then 
  begin
    messageBeep (0);
    key := #0;
  end;
end;
</pre>
<p>После получения вышеуказанным кодом строки s проверяется условие и,</p>
<p>if Length(s) &gt; maxlengthoffield then exit;</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0 </p>

