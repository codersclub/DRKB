<h1>Стены и основание диаграммы</h1>
<div class="date">01.01.2007</div>

<p>Стены и основание диаграммы</p>
Стены представляют собой вертикальные области, ограничивающие графическую часть диаграммы, и описываются через свойства и методы объекта Walls. Этот объект имеет такие свойства, как цвет и стиль окаймления, стиль и цвет (заливка) области стен. Функции управления этими свойствами смотрите в приложении (www.kornjakov.ru/st2_6.zip), а здесь рассмотрим их фрагменты.</p>
Цвет, толщина и стиль рамки окаймления:</p>
<pre class="delphi">
E.Charts.Item[name].Walls.Border.Color:=Color;
E.Charts.Item[name].Walls.Border.Weight:=Weight;
E.Charts.Item[name].Walls.Border.LineStyle:=LineStyle;
</pre>
</p>
Цвет, рисунок и цвет рисунка заполнения стен:</p>
<pre class="delphi">
 
E.Charts.Item[name].Walls.Interior.Color:=Color;
E.Charts.Item[name].Walls.Interior.Pattern:=Pattern;
E.Charts.Item[name].Walls.Interior.PatternColor:=PatternColor;
</pre>
Заливка области стен из файла:</p>
<pre class="delphi">
E.Charts.Item[name].Walls.Fill.UserPicture(PictureFile:=File_);
E.Charts.Item[name].Walls.Fill.Visible:=True;
</pre>
</p>
Основание графической части диаграммы - область, ограничивающая диаграмму внизу. Она описывается через свойства и методы объекта Floor. Этот объект обладает аналогичными свойствами, как и область стен. Вот несколько примеров их настройки из приложений Delphi.</p>
Цвет, толщина и стиль линий - границы основания:</p>
<pre class="delphi">
E.Charts.Item[name].Floor.Border.Color:=Color;
E.Charts.Item[name].Floor.Border.Weight:=Weight;
E.Charts.Item[name].Floor.Border.LineStyle:=LineStyle;
</pre>
</p>
Цвет, рисунок и цвет рисунка области основания:</p>
<pre class="delphi">
E.Charts.Item[name].Floor.Interior.Color:=Color;
E.Charts.Item[name].Floor.Interior.Pattern:=Pattern;
E.Charts.Item[name].Floor.Interior.PatternColor:=PatternColor;
</pre>
</p>
Заливка области основания из файла:</p>
<pre class="delphi">
E.Charts.Item[name].Floor.Fill.UserPicture(PictureFile:=File_);
E.Charts.Item[name].Floor.Fill.Visible:=True;
</pre>
</p>
