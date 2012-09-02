<h1>Как изменить шрифт в таблице?</h1>
<div class="date">01.01.2007</div>

<p>Попробуем изменить шрифт только в ячейке таблицы. Для этого можно использовать объект Font как свойство ячейки, например: ActiveDocument.Tables.Item(Table).Columns.Item(Column).Cells.Item(Row).Range.font.</p>
Есть и другой способ: можно выделить ячейку и работать с объектом Selection.Font. Второй способ выгоден тем, что его можно использовать для изменения шрифта не только в таблице, но и во всех выделенных объектах. Рассмотрим его подробнее. Выделим ячейку таблицы, используя метод Select объекта Cell. В Delphi эта функция будет выглядеть следующим образом:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>Function SelectCell(Table:integer;
  Row,Column:integer):boolean;
begin
 SelectCell:=true;
 try
  W.ActiveDocument.Tables.Item(Table).Columns.Item
 &nbsp; (Column).Cells.Item(Row).Select;
 except
  SelectCell:=false;
 end;
End;
</pre>
&nbsp;</p>
Используем эту функцию для выделения определенной ячейки таблицы. После этого можно приступать к работе со свойством Font объекта Selection. Объект Font аналогичен одноименному объекту в Delphi, но имеет некоторые отличия: цвет шрифта определяется индексом, который может иметь небольшое количество возможных значений, но количество режимов подчеркивания и перечеркивания текста больше, чем для шрифта в Delphi. Так как предполагается, что мы разрабатываем приложения на Delphi для разработки документов в Word, то было бы удобно применить функцию преобразования полей шрифта. Приведу пример такой функции:</p>
<pre>
Function FontToEFont(font:Tfont;EFont:variant;
  ColorIndex:integer):boolean;
begin
 FontToEFont:=true;
 try
  EFont.Name:=font.Name;
  if fsBold in font.Style
   then EFont.Bold:=True // Жирный
   else EFont.Bold:=False; // Тонкий
  if fsItalic in font.Style
   then EFont.Italic:=True // Наклонный
   else EFont.Italic:=False; //
  EFont.Size:=font.Size; // Размер
  if fsStrikeOut in font.Style
   then EFont.Strikethrough:=True // Перечеркнутый
   else EFont.Strikethrough:=False; //
  if fsUnderline in font.Style
   then EFont.Underline:=wdUnderlineSingle // Подчеркивание
   else EFont.Underline:=wdUnderlineNone; //
  EFont.ColorIndex:=ColorIndex; // Цвет
 except
  FontToEFont:=false;
 end;
End;
</pre>
&nbsp;</p>
Когда объект выделен, можем изменить его шрифт, для этого используем приведенную ниже функцию для объекта Selection:</p>
<pre>
Function SetFontSelection(font:Tfont;
  ColorIndex:integer):boolean;
begin
 SetFontSelection:=true;
 try
  SetFontSelection:=FontToEFont(font,W.Selection.font,ColorIndex);
 except
  SetFontSelection:=false;
 end;
End;
</pre>
&nbsp;</p>
В теле вашей программы замена шрифта будет выглядеть, например, следующим образом:</p>
SelectCell(tab_,2,3); SetFontSelection(Button2.font,5);</p>
Где tab_ - номер таблицы, Button2.font - шрифт кнопки, 5 - индекс цвета.</p>
