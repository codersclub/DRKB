---
Title: Область данных диаграммы
Date: 16.06.2003
Author: Василий КОРНЯКОВ (_kvn@mail.ru)
---


Область данных диаграммы
========================

Данные для построения диаграммы должны быть расположены на любом листе
рабочей книги и представлять собой прямоугольную область. Для
определения рабочей области данных используется метод SetSourceData,
первый аргумент которого - ссылка на лист и область ячеек, второй -
определяет способ использования данных (по строкам/столбцам).

    Function SetSourceData(Name,Sheet:variant;
      Range:string;XlRowCol:integer):boolean;
    begin
     SetSourceData:=true;
     try
      E.ActiveWorkbook.Charts.Item[name].SetSourceData
       (Source:=E.ActiveWorkbook.Sheets.Item [Sheet].Range[Range],PlotBy:=XlRowCol);
     except
      SetSourceData:=false;
     end;
    End;

