---
Title: Как работать со всеми ячейками html таблицы?
Date: 01.01.2007
Source: FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>
---


Как работать со всеми ячейками html таблицы?
=========================================


_Перевод материала с сайта members.home.com/hfournier/webbrowser.htm_

Пример показывает как добавить содержимое каждой ячейки в TMemo:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      i, j: integer;
      ovTable: OleVariant;
    begin
      // Я использовал первую таблицу на странице в качестве примера
      ovTable := WebBrowser1.OleObject.Document.all.tags('TABLE').item(0);
      for i := 0 to (ovTable.Rows.Length - 1) do
        begin
          for j := 0 to (ovTable.Rows.Item(i).Cells.Length - 1) do
            begin
              Memo1.Lines.Add(ovTable.Rows.Item(i).Cells.Item(j).InnerText;
            end;
        end;
    end;
