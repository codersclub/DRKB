---
Title: Высота и ширина ячейки Excel
Date: 01.01.2007
---


Высота и ширина ячейки Excel
============================

::: {.date}
01.01.2007
:::

Высота и ширина ячейки

Чтобы формировать вид документа в процессе его создания, недостаточно
только функций записи информации в ячейки, необходимо также изменять ее
визуальные параметры. Самое простое, с чего можно начать, - изменение
ширины столбцов и высоты строк. Доступ к ширине столбцов можно получить,
используя коллекцию Columns. Используя номер колонки в буквенном или
числовом формате и свойство коллекции ColumnWidth, можно изменить ширину
столбца или назначить ее. Определенная ниже функция, реализованная на
Delphi, устанавливает ширину столбца.

    Function SetColumnWidth (sheet:variant;
      column:variant;width:real):boolean;
    begin
     SetColumnWidth:=true;
     try
      E.ActiveWorkbook.Sheets.Item[sheet].Columns
       [column].ColumnWidth:=width;
     except
      SetColumnWidth:=false;
     end;
    End;

Для определения ширины столбца используйте следующий оператор:

    width:=E.ActiveWorkbook.Sheets.Item[sheet].Columns[column].ColumnWidth;

Доступ к высоте строк можно получить, используя коллекцию Rows. Назначая
номер строки и свойство коллекции RowHeight, можно изменить высоту
строки или назначить ее. Определенная ниже функция, реализованная на
Delphi, устанавливает высоту строки.

    Function SetRowHeight (sheet:variant;row:variant;
      height:real):boolean;
    begin
     SetRowHeight:=true;
     try
      E.ActiveWorkbook.Sheets.Item[sheet].Rows[row].RowHeight:=height;
     except
      SetRowHeight:=false;
     end;
    End;

 

Для определения высоты строки используйте следующий оператор:

    height:=E.ActiveWorkbook.Sheets.Item[sheet].Rows[row].RowHeight;
