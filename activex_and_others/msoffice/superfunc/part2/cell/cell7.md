---
Title: Формат заливки ячейки
Date: 16.06.2003
Author: Василий КОРНЯКОВ (_kvn@mail.ru)
---


Формат заливки ячейки
=====================

Заливка ячейки определяется цветом, фоновым рисунком и цветом фонового
рисунка. Доступ к этим полям осуществляется через объект Interior,
который является свойством объекта Range. Цвет заливки может выбираться
из определенной палитры цветов, в этом случае индекс цвета записывается
в поле ColorIndex. Если необходимо задать цвет, отличный от цветов
палитры, используется поле Color, в которое записывается значение
комбинации трех основных цветов RGB. Фоновый рисунок заливки выбирается
путем записи в поле Pattern константы из списка (смотрите исходный текст
на домашней странице). Цвет фонового рисунка выбирается из цветовой
палитры с записью в переменную PatternColorIndex цветового индекса или
записью непосредственно значения RGB в поле PatternColor. Функция
SetPatternRange реализует в среде Delphi управление форматом заливки
ячеек. В этой функции, как и во всех предыдущих, действия могут
выполняться как над одной ячейкой так и над множеством, все определяется
форматом аргумента функции range:string.

    Function SetPatternRange(sheet:variant;range:string;
      Pattern,ColorIndex,PatternColorIndex,Color,PatternColor:integer):boolean;
    begin
     SetPatternRange:=true;
     try
      E.ActiveWorkbook.Sheets.Item[sheet].Range[range].Interior.Pattern:=Pattern;
      if ColorIndex>0
       then E.ActiveWorkbook.Sheets.Item[sheet].Range
        [range].Interior.ColorIndex:=ColorIndex
       else E.ActiveWorkbook.Sheets.Item[sheet].Range
        [range].Interior.Color:=color;
      if PatternColorIndex>0
       then E.ActiveWorkbook.Sheets.Item[sheet].Range
        [range].Interior.PatternColorIndex:=PatternColorIndex
       else E.ActiveWorkbook.Sheets.Item[sheet].Range
        [range].Interior.PatternColor:=PatternColor;
     except
      SetPatternRange:=false;
     end;
    End;

