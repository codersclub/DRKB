---
Title: Создание диаграммы
Date: 16.06.2003
Author: Василий КОРНЯКОВ (_kvn@mail.ru)
---


Создание диаграммы
==================

Для создания диаграммы используем метод Add коллекции Charts. Процедура
AddChart (для Delphi) создает диаграмму, устанавливает ее вид и
возвращает ее имя для доступа к этой диаграмме в дальнейшем. В качестве
второго аргумента функции можно использовать константу xl3Darea(-4098),
которая позволяет создать объемную диаграмму. Значения других констант,
которые соответствуют другим видам диаграмм, и исходный текст смотрите
в файле [st2_5.zip](st2_5.zip).

    Function AddChart(var name:string;
      ChartType:integer):boolean;
    begin
     AddChart:=true;
     try
      name:=E.Charts.Add.Name;
      E.Charts.Item[name].ChartType:=ChartType;
     except
      AddChart:=false;
     end;
    End;

