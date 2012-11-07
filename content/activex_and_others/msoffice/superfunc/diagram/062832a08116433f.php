<h1>Область построения диаграммы</h1>
<div class="date">01.01.2007</div>

<p>Область построения диаграммы</p>
Область построения диаграммы служит для размещения графического изображения. Она имеет координаты относительно области диаграммы и другие свойства, присущие области: цвет и стиль рамки, цвет заливки и фоновый рисунок. Для доступа к ее координатам и размерам используем объект PlotArea (область построения диаграммы), который содержит все свойства области. Функция PositionPlotArea изменяет ее координаты и размеры.</p>

<pre class="delphi">Function PositionPlotArea(Name:variant;
  Left,Top,Width,Height:real):boolean;
begin
 PositionPlotArea:=true;
 try
  E.Charts.Item[name].PlotArea.Left:=Left;
  E.Charts.Item[name].PlotArea.Top:=Top;
  E.Charts.Item[name].PlotArea.Width:=Width;
  E.Charts.Item[name].PlotArea.Height:=Height;
 except
  PositionPlotArea:=false;
 end;
End;
</pre>

<p>Другими важными свойствами области диаграммы являются свойства, определяющие стиль, цвет, толщину рамки окаймления и рисунок, цвет самой области. Свойства рамки содержатся в объекте Border области PlotArea. Цвет рамки может быть представлен как комбинация из трех цветов RGB или выбран из палитры. Толщина и стиль выбираются из конечного, определенного списка значений (смотрите исходный текст).</p>

<pre class="delphi">Function BorderPlotArea(Name:variant;
  Color,LineStyle,Weight:integer):boolean;
begin
 BorderPlotArea:=true;
 try
  E.Charts.Item[name].PlotArea.Border.Color:=Color;
  E.Charts.Item[name].PlotArea.Border.Weight:=Weight;
  E.Charts.Item[name].PlotArea.Border.LineStyle:=LineStyle;
 except
  BorderPlotArea:=false;
 end;
End;
</pre>

<p>Цветовая характеристика области построения диаграммы содержится в объекте Interior. Цвет области и рисунка заполнения может быть представлен как комбинация из трех цветов RGB или выбран из палитры. Вид рисунка заполнения выбирается из конечного, определенного списка значений (смотрите исходный текст). Функция BrushPlotArea устанавливает цветовые параметры области диаграммы.</p>

<pre class="delphi">
Function BrushPlotArea(Name:variant;
  Color,Pattern,PatternColor:integer):boolean;
begin
 BrushPlotArea:=true;
 try
  E.Charts.Item[name].PlotArea.Interior.Color:=Color;
  E.Charts.Item[name].PlotArea.Interior.Pattern:=Pattern;
  E.Charts.Item[name].PlotArea.Interior.PatternColor:=PatternColor;
 except
  BrushPlotArea:=false;
 end;
End;
</pre>

<p>Фон области построения диаграммы может быть представлен не только в виде определенного узора и цветовой комбинации, но и в виде рисунка, загруженного из графического файла. Для этого используется метод UserPicture объекта Fill области PlotArea.</p>

<pre class="delphi">Function BrushPlotAreaFromFile(Name:variant;File_:string):boolean;
begin
 BrushPlotAreaFromFile:=true;
 try
  E.Charts.Item[name].PlotArea.Fill.UserPicture(PictureFile:= File_);
  E.Charts.Item[name].PlotArea.Fill.Visible:=True;
 except
  BrushPlotAreaFromFile:=false;
 end;
End;
</pre>
