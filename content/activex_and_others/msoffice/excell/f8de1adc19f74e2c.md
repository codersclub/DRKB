Через СОМ интерфейс
===================

::: {.date}
01.01.2007
:::

    var Excel, WorkBook, Sheet: Variant;
    begin
    Excel := CreateOleObject('Excel.Application');
    Excel.WorkBooks.Open(FileName,False);
    WorkBook := Excel.WorkBooks.Item[1];
    Sheet := Workbook.Sheets.Item[3];
    Sheet.Cells[1,2]:='ASDFG';
    Sheet.Cells[2,2]:=230;

Все объекты и методы Офиса можно посмотреть в help\'е Офиса.

Автор: Fantasist

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Ниже представлен пример создания новой таблице в Excel 2000:

    uses
      ComObj, ActiveX;
     
    var
      Row, Col: integer;
      DestRange: OleVariant;
      Excel: Variant;
     
    begin
      Excel := CreateOleObject('Excel.Application.9');
      Excel.Visible := True;
      Excel.WorkBooks.Add; //Создать новую таблицу
     
      //Можно помещать текст и значения в диапазон ячеек
      //Поместить     слово тест в диапазон ячеек
      Excel.ActiveSheet.Range['A2', 'B3'].Value := 'Тест';
      //Или число
      Excel.ActiveSheet.Range['A4', 'B5'].Value := 42;
     
      //А вот так задаётся формула
      Excel.ActiveSheet.Range['A10', 'A11'].Formula := '=RAND()';
     
      //Можно задавать номера ячеек и столбцов
      Excel.ActiveSheet.Cells.Item[1, 1].Value := 'Первая ячейка';
     
      Row:=1;
      Col:=3;
      Excel.ActiveSheet.Cells.Item[Row, Col].Value := 'Другая ячейка';
     
      //Можно скопировать данный из одного диапазона ячеек в другой
      DestRange := Excel.Range['D6', 'F10'];
      Excel.Range['A1', 'C5'].Copy(DestRange);
     
      //Можно задавать параметры шрифта в определённой ячейке
      Excel.Range['A2', 'A2'].Font.Size := 20;
      Excel.Range['A2', 'A2'].Font.FontStyle := 'Bold';
      Excel.Range['A2', 'A2'].Font.Color := clFuchsia;
      Excel.Range['A2', 'A2'].Font.Name := 'Arial';
     
      //Можно ещё и так изменить цвет диапазона ячеек
      Excel.Range['B2', 'C6'].Interior.Color := RGB(223, 123, 123);
     
    end;

Далее представлен пример открытия и закрытия таблицы:

    uses
      ComObj, ActiveX;
     
    var
      Excel: Variant;
      WBk : OleVariant;
      SaveChanges: OleVariant;
     
    begin
      Excel := CreateOleObject('Excel.Application.9');
      Excel.Visible := True;
     
      //Открыть существующую таблицу
      WBk := Excel.WorkBooks.Open('C:\Test.xls');
     
      ...
     
      WBk.Close(SaveChanges := True);
      Excel.Quit;
     
    end;

Взято из <https://forum.sources.ru>
