<h1>Можно ли работать и создавать, редактировать документы, используя объект Word.Basic?</h1>
<div class="date">01.01.2007</div>

<p>Можно работать с документами Word, используя Word.Basic. Для этого вначале создаем объект W:=CreateOleObject('Word.Basic'). Чтобы открыть файл, используем W.FileOpen('Путь и имя файла'). Для сохранения файла используем W.FileSave. Для поиска строки используем W.EditFind ('текст'), после чего оцениваем результат поиска W.EditFindFound и т.д. Объект Word.Application имеет больше возможностей, поэтому лучше использовать его.</p>
&nbsp;<br>
<p>Уточнение по работе с "Офисом XP" (замечание автора)</p>
Для работы в "Офисе XP" пришлось аргументы типа real заменить аргументами типа extended. Это пришлось сделать во всех функциях, особенно там, где необходимо установить координаты расположения объектов. Смотрите пример изменения координат и размеров объекта TextBox:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>
Function SetPosZizeTextBox(TextBox:variant;
  Left,Top,Width,Height:real):boolean;
 const msoTextBox=17;
 var l_,t_,w_,h_:Extended;
begin
 SetPosZizeTextBox:=true;
 try
  l_:=Left; t_:=Top; w_:=Width; h_:=Height;
  if w.ActiveDocument.Shapes.Item(TextBox).Type=msoTextBox
 &nbsp; then begin
 &nbsp;&nbsp; W.ActiveDocument.Shapes.Item(TextBox).Left:=l_;
 &nbsp;&nbsp; W.ActiveDocument.Shapes.Item(TextBox).Top:=t_;
 &nbsp;&nbsp; W.ActiveDocument.Shapes.Item(TextBox).Width:=w_;
 &nbsp;&nbsp; W.ActiveDocument.Shapes.Item(TextBox).Height:=h_;
 &nbsp; end
 &nbsp; else SetPosZizeTextBox:=false;
 except
  SetPosZizeTextBox:=false;
 end;
End;
</pre>

