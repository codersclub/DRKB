<h1>Формат заливки ячейки</h1>
<div class="date">01.01.2007</div>

<p>Формат заливки ячейки</p>
Заливка ячейки определяется цветом, фоновым рисунком и цветом фонового рисунка. Доступ к этим полям осуществляется через объект Interior, который является свойством объекта Range. Цвет заливки может выбираться из определенной палитры цветов, в этом случае индекс цвета записывается в поле ColorIndex. Если необходимо задать цвет, отличный от цветов палитры, используется поле Color, в которое записывается значение комбинации трех основных цветов RGB. Фоновый рисунок заливки выбирается путем записи в поле Pattern константы из списка (смотрите исходный текст на домашней странице). Цвет фонового рисунка выбирается из цветовой палитры с записью в переменную PatternColorIndex цветового индекса или записью непосредственно значения RGB в поле PatternColor. Функция SetPatternRange реализует в среде Delphi управление форматом заливки ячеек. В этой функции, как и во всех предыдущих, действия могут выполняться как над одной ячейкой так и над множеством, все определяется форматом аргумента функции range:string.</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>
Function SetPatternRange(sheet:variant;range:string;
  Pattern,ColorIndex,PatternColorIndex,Color,PatternColor:integer):boolean;
begin
 SetPatternRange:=true;
 try
  E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Interior.Pattern:=Pattern;
  if ColorIndex&gt;0
 &nbsp; then E.ActiveWorkbook.Sheets.Item[sheet].Range
 &nbsp;&nbsp; [range].Interior.ColorIndex:=ColorIndex
 &nbsp; else E.ActiveWorkbook.Sheets.Item[sheet].Range
 &nbsp;&nbsp; [range].Interior.Color:=color;
  if PatternColorIndex&gt;0
 &nbsp; then E.ActiveWorkbook.Sheets.Item[sheet].Range
 &nbsp;&nbsp; [range].Interior.PatternColorIndex:=PatternColorIndex
 &nbsp; else E.ActiveWorkbook.Sheets.Item[sheet].Range
 &nbsp;&nbsp; [range].Interior.PatternColor:=PatternColor;
 except
  SetPatternRange:=false;
 end;
End;
</pre>

