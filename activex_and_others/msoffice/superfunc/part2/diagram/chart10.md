---
Title: Подписи осей
Date: 16.06.2003
Author: Василий КОРНЯКОВ (_kvn@mail.ru)
---


Подписи осей
============

Оси диаграммы могут иметь подписи, представляющие собой области и
описываемые свойствами, присущими любым прямоугольным областям на
диаграмме. Рассмотрим только запись текста и включение, выключение
отображения объекта "подпись оси". Доступ ко всем полям и методам
подписи осуществляется через коллекцию Axes, члены которой и есть ссылки
на подписи. В приложениях Delphi запись текста в объект "подпись оси"
можно реализовать с помощью функции AxisChart.

    Function AxisChart (Name:variant;Category,Series,Value:string):boolean;
    begin
     AxisChart:=true;
     try
      if Category<>'' then E.Charts.Item[name].Axes[xlCategory].HasTitle:=True
       else E.Charts.Item[name].Axes[xlCategory].HasTitle:=False;
      if Series<>'' then E.Charts.Item[name].Axes[xlSeries].HasTitle:=True
       else E.Charts.Item[name].Axes[xlSeries].HasTitle:=False;
      if Value<>'' then E.Charts.Item[name].Axes[xlValue].HasTitle:=True
       else E.Charts.Item[name].Axes[xlValue].HasTitle:=False;
      E.Charts.Item[name].Axes[xlCategory].AxisTitle.Text:=Category;
      E.Charts.Item[name].Axes[xlSeries].AxisTitle.Text:=Series;
      E.Charts.Item[name].Axes[xlValue].AxisTitle.Text:=Value;
     except
      AxisChart:=false;
     end;
    End;

