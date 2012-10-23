<h1>Хранение стилей шрифта</h1>
<div class="date">01.01.2007</div>


<p>Как мне сохранить свойство шрифта Style, ведь он же набор?</p>

<p>Вы можете получать и устанавливать FontStyle через его преобразование к типу byte.</p>

<p>Для примера,</p>
<pre>
Var
  Style: TFontStyles;
begin
  { Сохраняем стиль шрифта в байте }
  Style := Canvas.Font.Style; {необходимо, поскольку Font.Style - свойство}
  ByteValue := Byte ( Style );
  { Преобразуем значение byte в TFontStyles }
  Canvas.Font.Style := TFontStyles ( ByteValue );
end;
</pre>


<p>Для восстановления шрифта, вам необходимо сохранить параметры Color, Name, Pitch, Style и Size в базе данных и назначить их соответствующим свойствам при загрузке.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
