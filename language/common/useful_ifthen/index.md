---
Title: Удобная функция ifthen
Author: feriman
Date: 01.01.2007
---


Удобная функция ifthen
======================

::: {.date}
01.01.2007
:::

В Делфи 6 (модуль Math) появилась удобная функция ifthen которая
соответствует оператору "?" языка С++.

Пример:

    procedure TForm1.Button1Click(Sender: TObject);
    var k, i, j: Integer;
    begin
      i := 3; j := 2;
      k := ifthen({If}i < j, {Then}i, {Else}k);
    End;

Автор: feriman

Взято из <https://forum.sources.ru>
