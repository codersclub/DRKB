<h1>Другие режимы отображения текста в ячейке Excel</h1>
<div class="date">01.01.2007</div>

<p>Другие режимы отображения текста в ячейке</p>
Угол, под которым текст отображается в ячейке, определяется свойством Orientation объекта Range. Значение Orientation может находиться в пределах от -90 до 90. Функция SetOrientation реализует эту возможность в приложениях Delphi.</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>Function SetOrientation (sheet:variant;range:string;
  orientation:integer):boolean;
begin
 SetOrientation:=true;
 try
  E.ActiveWorkbook.Sheets.Item[sheet].Range
 &nbsp; [range].Orientation:=orientation;
 except
  SetOrientation:=false;
 end;
End;
</pre>
&nbsp;</p>
Текст, ширина которого больше ширины ячейки, может отображаться несколькими строками (переносом по словам) или одной строкой. Это свойство ячейки содержится в поле WrapText объекта Range. Функция SetWrapText изменяет это поле и режим отображения текста большой длины.</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>Function SetWrapText(sheet:variant;range:string;
  WrapText:boolean):boolean;
begin
 SetWrapText:=true;
 try
  E.ActiveWorkbook.Sheets.Item[sheet].Range
 &nbsp; [range].WrapText:=WrapText;
 except
  SetWrapText:=false;
 end;
End;
</pre>
&nbsp;</p>
Можно использовать и альтернативный способ для размещения текста большой длины в ячейке. Он основан на автоподборе ширины текста под ширину ячейки. Свойство.ShrinkToFit объекта Range определяет этот режим отображения. Смотрите функцию SetShrinkToFit. Если установлен режим "перенос по словам", то действие этой функции отменяется.</p>
<pre>
Function SetShrinkToFit (sheet:variant;range:string;
  ShrinkToFit:boolean):boolean;
begin
 SetShrinkToFit:=true;
 try
  E.ActiveWorkbook.Sheets.Item[sheet].Range
   [range].ShrinkToFit:=ShrinkToFit;
 except
  SetShrinkToFit:=false;
 end;
End;
</pre>
Несколько ячеек можно объединить. Для этой цели используется свойство MergeCells объекта Range[range], где range - область для объединения, например "A1:C2". Если в MergeCells записывает значение True, то это приводит к объединению ячеек. Для реализации в приложениях на Delphi используем функцию SetMergeCells.</p>
<pre>
Function SetMergeCells (sheet:variant;range:string;
  MergeCells:boolean):boolean;
begin
 SetMergeCells:=true;
 try
  E.ActiveWorkbook.Sheets.Item[sheet].Range
   [range].MergeCells:=MergeCells;
 except
  SetMergeCells:=false;
 end;
End;
</pre>
&nbsp;</p>
