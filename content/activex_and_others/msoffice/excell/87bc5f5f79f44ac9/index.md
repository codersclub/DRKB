---
Title: Как вывести данные в Excel?
Author: Кулюкин Олег
Date: 01.01.2007
---


Как вывести данные в Excel?
===========================

::: {.date}
01.01.2007
:::

Можно выводить данные последовательно в каждую ячейку, но это очинь
сильно замедляет работу. Лучше сформировать вариантный массив, и
выполнить присвоение области (Range) этого массива.

    var
        ExcelApp, Workbook, Range, Cell1, Cell2, ArrayData  : Variant;
        TemplateFile : String;
        BeginCol, BeginRow, i, j : integer;
        RowCount, ColCount : integer;
    begin
      // Координаты левого верхнего угла области, в которую будем выводить данные
      BeginCol := 1;
      BeginRow := 5;
     
      // Размеры выводимого массива данных
      RowCount := 100;
      ColCount := 50;
     
      // Создание Excel
      ExcelApp := CreateOleObject('Excel.Application');
     
      // Отключаем реакцию Excel на события, чтобы ускорить вывод информации
      ExcelApp.Application.EnableEvents := false;
     
      //  Создаем Книгу (Workbook)
      //  Если заполняем шаблон, то Workbook := ExcelApp.WorkBooks.Add('C:\MyTemplate.xls');
      Workbook := ExcelApp.WorkBooks.Add;
     
      // Создаем Вариантный Массив, который заполним выходными данными
      ArrayData := VarArrayCreate([1, RowCount, 1, ColCount], varVariant);
     
      // Заполняем массив
      for I := 1 to RowCount do
        for J := 1 to ColCount do
          ArrayData[I, J] := J * 10 + I;
     
      // Левая верхняя ячейка области, в которую будем выводить данные
      Cell1 := WorkBook.WorkSheets[1].Cells[BeginRow, BeginCol];
      // Правая нижняя ячейка области, в которую будем выводить данные
      Cell2 := WorkBook.WorkSheets[1].Cells[BeginRow  + RowCount - 1, BeginCol +
    ColCount - 1];
     
      // Область, в которую будем выводить данные
      Range := WorkBook.WorkSheets[1].Range[Cell1, Cell2];
     
      // А вот и сам вывод данных
      // Намного быстрее поячеечного присвоения
      Range.Value := ArrayData;
     
      // Делаем Excel видимым
      ExcelApp.Visible := true;

Автор: Кулюкин Олег

Взято с сайта <https://www.delphikingdom.ru/>
