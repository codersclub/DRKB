---
Title: Размещение диаграммы
Date: 16.06.2003
Author: Василий КОРНЯКОВ (_kvn@mail.ru)
---


Размещение диаграммы
====================

Диаграмма может размещаться совместно с данными или на отдельном листе.
Размещение диаграммы лучше совмещать с процессом ее создания, но можно
выполнить эту процедуру и самостоятельно. При этом необходимо учитывать,
что при изменении размещения меняется и имя диаграммы (не путать с
названием). Для размещения диаграммы используйте функцию
SetChartLocation, аргумент xlLocation которой может иметь одно из двух
значений (xlLocationAsNewSheet или xlLocationAsObject).

    Function SetChartLocation (var name:variant;sheet:variant;
      xlLocation:integer):boolean;
    begin
     SetChartLocation:=true;
     try
      name:=E.Charts.Item[name].Location(Where:=
       xlLocationAsObject,Name:=sheet).name;
     except
     SetChartLocation:=false;
     end;
    End;
