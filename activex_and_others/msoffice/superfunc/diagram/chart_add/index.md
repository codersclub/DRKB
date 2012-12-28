---
Title: Создание диаграммы
Date: 01.01.2007
---


Создание диаграммы
==================

::: {.date}
01.01.2007
:::

Для создания диаграммы используем метод Add коллекции Charts. Процедура
AddChart (для Delphi) создает диаграмму, устанавливает ее вид и
возвращает ее имя для доступа к этой диаграмме в дальнейшем. В качестве
второго аргумента функции можно использовать константу xl3Darea(-4098),
которая позволяет создать объемную диаграмму. Значения других констант,
которые соответствуют другим видам диаграмм, и исходный текст смотрите
на www.kornjakov.ru/st2\_5.zip.

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

