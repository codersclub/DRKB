---
Title: Стены и основание диаграммы
Date: 16.06.2003
Author: Василий КОРНЯКОВ (_kvn@mail.ru)
---


Стены и основание диаграммы
===========================

Стены представляют собой вертикальные области, ограничивающие
графическую часть диаграммы, и описываются через свойства и методы
объекта Walls. Этот объект имеет такие свойства, как цвет и стиль
окаймления, стиль и цвет (заливка) области стен. Функции управления
этими свойствами смотрите в приложении [st2_6.zip](st2_6.zip), а
здесь рассмотрим их фрагменты.


### Цвет, толщина и стиль рамки окаймления:

    E.Charts.Item[name].Walls.Border.Color:=Color;
    E.Charts.Item[name].Walls.Border.Weight:=Weight;
    E.Charts.Item[name].Walls.Border.LineStyle:=LineStyle;


### Цвет, рисунок и цвет рисунка заполнения стен:

     
    E.Charts.Item[name].Walls.Interior.Color:=Color;
    E.Charts.Item[name].Walls.Interior.Pattern:=Pattern;
    E.Charts.Item[name].Walls.Interior.PatternColor:=PatternColor;

### Заливка области стен из файла:

    E.Charts.Item[name].Walls.Fill.UserPicture(PictureFile:=File_);
    E.Charts.Item[name].Walls.Fill.Visible:=True;

 
Основание графической части диаграммы - область, ограничивающая
диаграмму внизу. Она описывается через свойства и методы объекта Floor.
Этот объект обладает аналогичными свойствами, как и область стен. Вот
несколько примеров их настройки из приложений Delphi.

### Цвет, толщина и стиль линий - границы основания:

    E.Charts.Item[name].Floor.Border.Color:=Color;
    E.Charts.Item[name].Floor.Border.Weight:=Weight;
    E.Charts.Item[name].Floor.Border.LineStyle:=LineStyle;


### Цвет, рисунок и цвет рисунка области основания:

    E.Charts.Item[name].Floor.Interior.Color:=Color;
    E.Charts.Item[name].Floor.Interior.Pattern:=Pattern;
    E.Charts.Item[name].Floor.Interior.PatternColor:=PatternColor;


### Заливка области основания из файла:

    E.Charts.Item[name].Floor.Fill.UserPicture(PictureFile:=File_);
    E.Charts.Item[name].Floor.Fill.Visible:=True;

