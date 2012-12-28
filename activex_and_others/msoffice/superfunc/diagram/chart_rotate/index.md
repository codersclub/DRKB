---
Title: Наклон и поворот
Date: 01.01.2007
---


Наклон и поворот
================

::: {.date}
01.01.2007
:::

Наклон диаграммы можно выполнить на угол от -90° до +90°. Значения,
выходящие за эти пределы, вызывают ошибку. Выбор угла поворота
осуществляется записью значения угла в свойство Elevation объекта Chart.
Поворот диаграммы осуществляется записью в поле Rotation объекта Chart
значения угла поворота. Этот угол может иметь значения от 0° до 360°.
Для задания углов наклона и поворота в приложениях на Delphi можно
использовать функции ElevationChart и RotationChart.

    Function ElevationChart (Name:variant;Elevation:real):boolean;
    begin
     ElevationChart:=true;
     try
      E.Charts.Item[name].Elevation:=Elevation;
     except
      ElevationChart:=false;
     end;
    End;
    Function RotationChart(Name:variant;Rotation:real):boolean;
    begin
     RotationChart:=true;
     try
      E.Charts.Item[name].Rotation:=Rotation;
     except
      RotationChart:=false;
     end;
    End;

 
