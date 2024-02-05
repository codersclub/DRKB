---
Title: Область диаграммы
Date: 16.06.2003
Author: Василий КОРНЯКОВ (_kvn@mail.ru)
---


Область диаграммы
=================

Если диаграмма расположена на одном листе с данными, то можно изменять
координаты и размеры области диаграммы. Диаграмма может быть размещена
также на отдельном листе, тогда ее размеры совпадают с размером листа.
Для доступа к координатам и размерам этой области используем объект
ChartArea (область диаграммы). Функция PositionChart изменяет ее
координаты и размеры. Аналогично мы можем получить координаты и размеры
диаграммы. Для этого достаточно считать значения Left, Top, Width и
Height объекта ChartArea.

    Function PositionChart(Name:variant;
      Left,Top,Width,Height:real):boolean;
    begin
     PositionChart:=true;
     try
      E.Charts.Item[name].ChartArea.Left:=Left;
      E.Charts.Item[name].ChartArea.Top:=Top;
      E.Charts.Item[name].ChartArea.Width:=Width;
      E.Charts.Item[name].ChartArea.Height:=Height;
     except
      PositionChart:=false;
     end;
    End;

 

Кроме размеров и координат, область диаграммы имеет свойства, которые
определяют стиль, цвет, толщину рамки окаймления, а также рисунок и цвет
самой области. Свойства рамки содержатся в объекте Border области
ChartArea. Цвет рамки может быть представлен как комбинация из трех
цветов RGB или выбран из палитры. Толщина и стиль выбираются из
конечного, определенного списка значений (смотрите исходный текст).
Используем функцию BorderChartArea для установки типа и цвета рамки из
приложений Delphi.

    Function BorderChartArea(Name:variant;
      Color,LineStyle,Weight:integer):boolean;
    begin
     BorderChartArea:=true;
     try
      E.Charts.Item[name].ChartArea.Border.Color:=Color;
      E.Charts.Item[name].ChartArea.Border.Weight:=Weight;
      E.Charts.Item[name].ChartArea.Border.LineStyle:=LineStyle;
     except
      BorderChartArea:=false;
     end;
    End;

 

Свойства области диаграммы содержатся в объекте Interior. Цвет области и
рисунка заполнения может быть представлен как комбинация из трех цветов
RGB или выбран из палитры. Вид рисунка заполнения выбирается из
конечного, определенного списка значений (смотрите исходный текст).
Функция BrushChartArea устанавливает цветовые параметры области
диаграммы.

    Function BrushChartArea(Name:variant;
      Color,Pattern,PatternColor:integer):boolean;
    begin
     BrushChartArea:=true;
     try
      E.Charts.Item[name].ChartArea.Interior.Color:=Color;
      E.Charts.Item[name].ChartArea.Interior.Pattern:=Pattern;
      E.Charts.Item[name].ChartArea.Interior.PatternColor:=PatternColor;
     except
      BrushChartArea:=false;
     end;
    End;

 

Для установки фона области диаграммы также можно использовать рисунок,
загруженный из файла в графическом формате. Для этого используется метод
UserPicture объекта Fill области ChartArea.

    Function BrushChartAreaFromFile(Name:variant;File_:string):boolean;
    begin
     BrushChartAreaFromFile:=true;
     try
      E.Charts.Item[name].ChartArea.Fill.UserPicture(PictureFile:=File_);
      E.Charts.Item[name].ChartArea.Fill.Visible:=True;
     except
      BrushChartAreaFromFile:=false;
     end;
    End;

 
Область диаграммы - это область, которая содержит все остальные объекты
диаграммы. Рассмотрим остальные компоненты, расположенные на этой
области.
