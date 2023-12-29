---
Title: Как экспортировать содержимое TDBGrid в Excel или Clipboard?
Date: 01.01.2007
---


Как экспортировать содержимое TDBGrid в Excel или Clipboard?
============================================================

::: {.date}
01.01.2007
:::

Пример dbgrid (DBGrid1) имеет всплывающее меню, которое позволяет две
опции "Send to Excel" и "Copy"

// ЗАМЕЧАНИЕ: этот метод должен включать COMObj, Excel97 units

// ОБНОВЛЕНИЕ: если Вы используете Delphi 4, то замените xlWBatWorkSheet
на 1 (один)

    //----------------------------------------------------------- 
    // если toExcel = false, то экспортируем содержимое dbgrid в Clipboard 
    // если toExcel = true, то экспортируем содержимое dbgrid в Microsoft Excel 
    procedure ExportDBGrid(toExcel: Boolean); 
    var 
      bm: TBookmark; 
      col, row: Integer; 
      sline: String; 
      mem: TMemo; 
      ExcelApp: Variant; 
    begin 
      Screen.Cursor := crHourglass; 
      DBGrid1.DataSource.DataSet.DisableControls; 
      bm := DBGrid1.DataSource.DataSet.GetBookmark; 
      DBGrid1.DataSource.DataSet.First; 
     
      // создаём объект Excel
      if toExcel then 
      begin 
        ExcelApp := CreateOleObject('Excel.Application'); 
        ExcelApp.WorkBooks.Add(xlWBatWorkSheet); 
        ExcelApp.WorkBooks[1].WorkSheets[1].Name := 'Grid Data'; 
      end; 
     
      // Сперва отправляем данные в memo 
      // работает быстрее, чем отправлять их напрямую в Excel
      mem := TMemo.Create(Self); 
      mem.Visible := false; 
      mem.Parent := MainForm; 
      mem.Clear; 
      sline := ''; 
     
      // добавляем информацию для имён колонок
      for col := 0 to DBGrid1.FieldCount-1 do 
        sline := sline + DBGrid1.Fields[col].DisplayLabel + #9; 
      mem.Lines.Add(sline); 
     
      // получаем данные из memo 
      for row := 0 to DBGrid1.DataSource.DataSet.RecordCount-1 do 
      begin 
        sline := ''; 
        for col := 0 to DBGrid1.FieldCount-1 do 
          sline := sline + DBGrid1.Fields[col].AsString + #9; 
        mem.Lines.Add(sline); 
        DBGrid1.DataSource.DataSet.Next; 
      end; 
     
      // копируем данные в clipboard 
      mem.SelectAll; 
      mem.CopyToClipboard; 
     
      // если необходимо, то отправляем их в Excel
      // если нет, то они уже в буфере обмена
      if toExcel then 
      begin 
        ExcelApp.Workbooks[1].WorkSheets['Grid Data'].Paste; 
        ExcelApp.Visible := true; 
      end; 
     
      FreeAndNil(ExcelApp); 
      DBGrid1.DataSource.DataSet.GotoBookmark(bm); 
      DBGrid1.DataSource.DataSet.FreeBookmark(bm); 
      DBGrid1.DataSource.DataSet.EnableControls; 
      Screen.Cursor := crDefault; 
    end;

Взято из <https://forum.sources.ru>
