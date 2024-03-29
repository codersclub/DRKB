---
Title: Обмен данными с Excel
Author: Fernando Silva
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Обмен данными с Excel
=====================

В Delphi 5, для обмена данными между Вашим приложением и Excel можно
использовать компонент TExcelApplication, доступный на Servers Page в
Component Palette.

На форме находится TStringGrid, заполненный некоторыми данными и две
кнопки, с названиями To Excel и From Excel. Так же на форме находится
компонент TExcelApplication со свойством Name, содержащим XLApp и
свойством ConnectKind, содержащим ckNewInstance.

Когда нам необходимо работать с Excel, то обычно мы открываем
ExcelApplication, затем открываем WorkBook и в конце используем
WorkSheet.

Итак, несомненный интерес представляет для нас листы (WorkSheets) в
книге (WorkBook). Давайте посмотрим как всё это работает.

Посылка данных в Excel

Это можно сделать с помощью следующей процедуры :

    procedure TForm1.BitBtnToExcelOnClick(Sender: TObject);
    var
      WorkBk: _WorkBook; //  определяем WorkBook
      WorkSheet: _WorkSheet; //  определяем WorkSheet
      I, J, K, R, C: Integer;
      IIndex: OleVariant;
      TabGrid: Variant;
    begin
      if GenericStringGrid.Cells[0, 1] <> '' then
        begin
          IIndex := 1;
          R := GenericStringGrid.RowCount;
          C := GenericStringGrid.ColCount;
       // Создаём массив-матрицу
          TabGrid := VarArrayCreate([0, (R - 1), 0, (C - 1)], VarOleStr);
          I := 0;
       //  Определяем цикл для заполнения массива-матрицы
          repeat
            for J := 0 to (C - 1) do
              TabGrid[I, J] := GenericStringGrid.Cells[J, I];
            Inc(I, 1);
          until
            I > (R - 1);
     
       // Соединяемся с сервером TExcelApplication
          XLApp.Connect;
        // Добавляем WorkBooks в ExcelApplication
          XLApp.WorkBooks.Add(xlWBatWorkSheet, 0);
       // Выбираем первую WorkBook
          WorkBk := XLApp.WorkBooks.Item[IIndex];
       // Определяем первый WorkSheet
          WorkSheet := WorkBk.WorkSheets.Get_Item(1) as _WorkSheet;
       // Сопоставляем Delphi массив-матрицу с матрицей в WorkSheet
          Worksheet.Range['A1', Worksheet.Cells.Item[R, C]].Value := TabGrid;
       // Заполняем свойства WorkSheet
          WorkSheet.Name := 'Customers';
          Worksheet.Columns.Font.Bold := True;
          Worksheet.Columns.HorizontalAlignment := xlRight;
          WorkSheet.Columns.ColumnWidth := 14;
       // Заполняем всю первую колонку
          WorkSheet.Range['A' + IntToStr(1), 'A' + IntToStr(R)].Font.Color := clBlue;
          WorkSheet.Range['A' + IntToStr(1), 'A' + IntToStr(R)].HorizontalAlignment := xlHAlignLeft;
          WorkSheet.Range['A' + IntToStr(1), 'A' + IntToStr(R)].ColumnWidth := 31;
       // Показываем Excel
          XLApp.Visible[0] := True;
       // Разрываем связь с сервером
          XLApp.Disconnect;
       // Unassign the Delphi Variant Matrix
          TabGrid := Unassigned;
        end;
    end;

Получение данных из Excel

Это можно сделать с помощью следующей процедуры :

    procedure TForm1.BitBtnFromExcelOnClick(Sender: TObject);
    var
      WorkBk: _WorkBook;
      WorkSheet: _WorkSheet;
      K, R, X, Y: Integer;
      IIndex: OleVariant;
      RangeMatrix: Variant;
      NomFich: WideString;
    begin
      NomFich := 'C:\MyDirectory\NameOfFile.xls';
      IIndex := 1;
      XLApp.Connect;
    // Открываем файл Excel
      XLApp.WorkBooks.Open(NomFich, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam, EmptyParam,
        EmptyParam, EmptyParam, 0);
      WorkBk := XLApp.WorkBooks.Item[IIndex];
      WorkSheet := WorkBk.WorkSheets.Get_Item(1) as _WorkSheet;
    // Чтобы знать размер листа (WorkSheet), т.е. количество строк и количество
    // столбцов, мы активируем его последнюю непустую ячейку
      WorkSheet.Cells.SpecialCells(xlCellTypeLastCell, EmptyParam).Activate;
    // Получаем значение последней строки
      X := XLApp.ActiveCell.Row;
    // Получаем значение последней колонки
      Y := XLApp.ActiveCell.Column;
    // Определяем количество колонок в TStringGrid
      GenericStringGrid.ColCount := Y;
    // Сопоставляем матрицу WorkSheet с нашей Delphi матрицей
      RangeMatrix := XLApp.Range['A1', XLApp.Cells.Item[X, Y]].Value;
    // Выходим из Excel и отсоединяемся от сервера
      XLApp.Quit;
      XLApp.Disconnect;
    //  Определяем цикл для заполнения TStringGrid
      K := 1;
      repeat
        for R := 1 to Y do
          GenericStringGrid.Cells[(R - 1), (K - 1)] := RangeMatrix[K, R];
        Inc(K, 1);
        GenericStringGrid.RowCount := K + 1;
      until
        K > X;
    // Unassign the Delphi Variant Matrix
      RangeMatrix := Unassigned;
    end;

