<h1>Серии коллекции</h1>
<div class="date">01.01.2007</div>

<p>Серии коллекции</p>
Рассмотрим серии коллекции - графики, набор фигур на диаграмме. Доступ к коллекциям получаем через объект SeriesCollection. Количество их зависит от размеров области данных диаграммы на рабочем листе. Чтобы получить его значение, считаем поле Count объекта SeriesCollection. Функция SeriesCount (для работы в среде Delphi) возвращает количество серий.</p>
<pre class="delphi">Function SeriesCount (Name:variant):integer;
begin
 SeriesCount:=-1;
 try
  SeriesCount:=E.Charts.Item[name].SeriesCollection.Count;
 except
  SeriesCount:=-1;
 end;
End;
</pre>
</p>
Рассмотрим вид коллекции - вид фигур в коллекции (куб, пирамида и др.). Я насчитал шесть видов. Для своих приложений можем использовать функцию BarShapeSeries для выбора любого из шести видов.</p>
<pre class="delphi">Function BarShapeSeries (Name:variant;series,BarShape:integer):boolean;
begin
 BarShapeSeries:=true;
 try
  E.Charts.Item[name].SeriesCollection.Item[series].BarShape:=BarShape;
 except
  BarShapeSeries:=false;
 end;
End;
</pre>
</p>
Остальные параметры: параметры границы и областей коллекции аналогичны параметрам любых областей диаграммы. Привожу их краткий список в виде операторов для Delphi:</p>
<pre class="delphi">E.Charts.Item[name].SeriesCollection.Item[series].Border.Color:=Color;
E.Charts.Item[name].SeriesCollection.Item[series].Border.Weight:=Weight;
E.Charts.Item[name].SeriesCollection.Item[series].Border.LineStyle:=LineStyle;
E.Charts.Item[name].SeriesCollection.Item[series].Interior.Color:=Color;
E.Charts.Item[name].SeriesCollection.Item[series].Interior.Pattern:=Pattern;
E.Charts.Item[name].SeriesCollection.Item[series].Interior.PatternColor:=PatternColor;
E.Charts.Item[name].SeriesCollection.Item[series].Fill.UserPicture(PictureFile:=File_);
E.Charts.Item[name].SeriesCollection.Item[series].Fill.Visible:=True;
</pre>
</p>
