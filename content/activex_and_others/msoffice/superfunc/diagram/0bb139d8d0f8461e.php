<h1>Заголовок диаграммы</h1>
<div class="date">01.01.2007</div>

<p>Заголовок диаграммы</p>
Заголовок диаграммы имеет такие же параметры, как и любая область, но есть некоторые отличия. Ширина и высота заголовка определяется размером шрифта, и, в отличие от области диаграммы, важным параметром является текст надписи заголовка и сам шрифт как объект, входящий в ChartTitle. Полные версии функций для использования в приложениях Delphi смотрите на www.kornjakov.ru/st2_5.zip, здесь представлены только их фрагменты. Рассмотрим основные свойства объекта ChartTitle. Заголовок и текст заголовка выводится при условии, что в поле HasTitle объекта Chart записано значение True, а поле Text объекта ChartTitle записан сам текст. Смотрите пример:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>E.Charts.Item[name].HasTitle:=True;
E.Charts.Item[name].ChartTitle.Text:='Заголовок диаграммы';
</pre>
&nbsp;</p>
Координаты заголовка содержатся в полях Left и Top объекта ChartTitle. Для перемещения заголовка запишите в эти поля новые значения координат. Для определения координат считайте значения из этих полей.</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>E.Charts.Item[name].ChartTitle.Left:=Left;
E.Charts.Item[name].ChartTitle.Top:=Top;
</pre>
&nbsp;</p>
Чтобы изменить визуальные параметры рамки, используйте объект Border и его поля Color (цвет), Weight (толщина) и LineStyle (стиль линии)</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>E.Charts.Item[name].ChartTitle.Border.Color:=Color;
E.Charts.Item[name].ChartTitle.Border.Weight:=Weight;
E.Charts.Item[name].ChartTitle.Border.LineStyle:=LineStyle;
</pre>
&nbsp;</p>
Для заполнения цветом и узором области заголовка используйте объект Interior и его поля Color (цвет), Pattern (узор) и PatternColor (цвет узора).</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>
E.Charts.Item[name].ChartTitle.Interior.Color:=Color;
E.Charts.Item[name].ChartTitle.Interior.Pattern:=Pattern;
E.Charts.Item[name].ChartTitle.Interior.PatternColor:=PatternColor;
</pre>
Чтобы заполнить область заголовка рисунком из графического файла, используйте метод UserPicture объекта Fill. Чтобы этот рисунок стал видимым, запишите в поле Visible объекта Fill значение True.</p>
<pre>
E.Charts.Item[name].ChartTitle.Fill.UserPicture(PictureFile:= File_);
E.Charts.Item[name].ChartTitle.Fill.Visible:=True;
</pre>
&nbsp;</p>
