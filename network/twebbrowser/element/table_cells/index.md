---
Title: Как работать со всеми ячейками \<table\>?
Date: 01.01.2007
---


Как работать со всеми ячейками \<table\>?
=========================================

::: {.date}
01.01.2007
:::

Взято из FAQ:<https://blackman.km.ru/myfaq/cont4.phtml>

Перевод материала с сайта members.home.com/hfournier/webbrowser.htm

Пример показывает как добавить содержимое каждой ячейки в TMemo:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      i, j: integer;
      ovTable: OleVariant;
    begin
    // Я использовал первую таблицу на странице в ка?естве примера
      ovTable := WebBrowser1.OleObject.Document.all.tags('TABLE').item(0); for i := 0 to (ovTable.Rows.Length - 1) do
        begin
          for j := 0 to (ovTable.Rows.Item(i).Cells.Length - 1) do
            begin
              Memo1.Lines.Add(ovTable.Rows.Item(i).Cells.Item(j).InnerText;
            end;
        end;
    end;
