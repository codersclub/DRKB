---
Title: Числовой формат ячейки Excel
Date: 16.06.2003
Author: Василий КОРНЯКОВ (_kvn@mail.ru)
---


Числовой формат ячейки Excel
============================

Данные в ячейках таблицы могут отображаться различным образом (число,
дата, время, строка), способ отображения данных называется числовым
форматом. Значение числового формата ячейки хранится в свойстве
NumberFormat объекта Range, имеет тип строка и может содержать,
например, такие значения: \'General\', \'hh:mm:ss\', \'0,000\'. Они
соответствуют общему формату, формату времени и формату числа с тремя
знаками после запятой. Опытным путем можно получить значения всех
форматов, для этого в Delphi используем функцию GetFormatRange.

    Function GetFormatRange (sheet:variant;
      range:string):string;
    begin
     try
      GetFormatRange:=E.ActiveWorkbook.Sheets.Item
       [sheet].Range[range].NumberFormat;
     except
      GetFormatRange:='';
     end;
    End;


Для установки числового формата ячейки можем использовать функцию
SetFormatRange, которая записывает значение числового формата в свойстве
NumberFormat объекта Range.

    Function SetFormatRange(sheet:variant;range:string;
      format:string):boolean;
    begin
     SetFormatRange:=true;
     try
      E.ActiveWorkbook.Sheets.Item[sheet].Range
       [range].NumberFormat:=format;
     except
      SetFormatRange:=false;
     end;
    End;


Данная функция изменяет числовой формат не только в одной отдельно
взятой ячейке, а также в группе ячеек. Это определяется значением
аргумента range:string. Смотрите примеры: \'A:A\' - изменение формата во
всех ячейках столбца A, \'2:5\' - изменение формата во всех ячейках
столбцов со второй по пятую включительно, \'A:C\' - изменение формата во
всех ячейках столбцов с A по C включительно; \'A1:C5\' - изменение
формата во всех ячейках области, ограниченной колонками A...C и
строками 1...5 включительно.