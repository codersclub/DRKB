---
Title: Просмотр печати
Date: 01.01.2007
---


Просмотр печати
===============

::: {.date}
01.01.2007
:::

Просмотр печати

Когда документ сформирован и выполнены настройки печати, можно
переходить к просмотру информации, выводимой на печать. Для этого
используем метод PrintPreview объекта \"лист\". Для применения его в
приложениях Delphi можно воспользоваться следующей функцией
PrintPreview, где в качестве аргумента применяется номер или имя
страницы.

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"}
    Function PrintPreview (sheet:variant):boolean;
    begin
     PrintPreview:=true;
     try
      E.ActiveWorkbook.Sheets.Item[sheet].PrintPreview;
     except
      PrintPreview:=false;
     end;
    End;

 

Можно воспользоваться альтернативным способом для просмотра печати. Он
заключается в вызове обычного диалога. Используйте для этого
Dialogs.Item(xlDialogPrintPreview).Show, где константа
xlDialogPrintPreview=222.

::: {style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"}
    Function PrintPreviewEx:boolean;
    begin
     PrintPreviewEx:=true;
     try
      E.Dialogs.Item[xlDialogPrintPreview].Show;
     except
      PrintPreviewEx:=false;
     end;
    End;

 
:::
:::
