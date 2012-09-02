<h1>Формат границ ячейки</h1>
<div class="date">01.01.2007</div>

<p>Формат границ ячейки</p>
Границы ячейки имеют следующие свойства: цвет, стиль и толщина. Чтобы получить доступ к границе, используем коллекцию Borders объекта Range, которая через индекс (Edge) предоставляет доступ к той или иной стороне границы ячейки (левая, правая и т.д. сторона). Edge может принимать одно из 8 определенных значений. Объекты коллекции Borders определяют цвет границы, который может задаваться выбором из определенной в Excel палитры или как комбинация из трех цветов RGB. Свойство ColorIndex содержит индекс цвета: когда нас не устраивает цвет из заранее определенной палитры, тогда используем свойство Color, в которое запишем значение из комбинации трех основных цветов, например: Color= RGB(200,100,125). Стиль границы (LineStyle) имеет тип integer и одно из 8 предопределенных значений (смотрите приложение). Толщина границы (Weight) имеет тип integer и одно из 4 значений. Исходный текст функции для установки параметров границы ячейки смотрите ниже.</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>Function SetBorderRange(sheet:variant;range:string;
  Edge,LineStyle,Weight,ColorIndex,Color:integer):boolean;
begin
 SetBorderRange:=true;
 try
  E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Borders.item
 &nbsp; [Edge].Weight:=Weight;
  E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Borders.item
 &nbsp; [Edge].LineStyle:=LineStyle;
  if ColorIndex&gt;0 then
 &nbsp; E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Borders.item
 &nbsp; [Edge].ColorIndex:=ColorIndex
  else
 &nbsp; E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Borders.item
 &nbsp; [Edge].Color:=color;
 except
  SetBorderRange:=false;
 end;
End;
</pre>
&nbsp;</p>
