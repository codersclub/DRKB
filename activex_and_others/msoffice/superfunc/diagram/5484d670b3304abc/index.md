---
Title: Тип диаграммы
Date: 01.01.2007
---


Тип диаграммы
=============

::: {.date}
01.01.2007
:::

Тип диаграммы

Тип диаграммы определяет, каким образом отображается информация: в виде
плоских или объемных фигур или графиков, а также сам вид этих фигур.
Существует около 70 типов диаграмм, и чтобы выбрать один из них,
используется метод ApplyCustomType. В качестве аргумента этого метода
используется константа из списка (см. приложение
www.kornjakov.ru/st2\_6.zip). В Delphi выбор типа диаграммы можно
реализовать, используя функцию SetChartType.

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"}
    Function SetChartType (Name:variant;ChartType:integer):boolean;
    begin
     SetChartType:=true;
     try
      E.Charts.Item[name].ApplyCustomType(ChartType:=ChartType);
     except
      SetChartType:=false;
     end;
    End;

 

.
:::
