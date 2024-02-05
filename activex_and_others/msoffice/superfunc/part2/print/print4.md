---
Title: Просмотр печати
Date: 16.06.2003
Author: Василий КОРНЯКОВ (_kvn@mail.ru)
---


Просмотр печати
===============

Когда документ сформирован и выполнены настройки печати, можно
переходить к просмотру информации, выводимой на печать. Для этого
используем метод PrintPreview объекта "лист". Для применения его в
приложениях Delphi можно воспользоваться следующей функцией
PrintPreview, где в качестве аргумента применяется номер или имя
страницы.

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

Dialogs.Item(xlDialogPrintPreview).Show

где константа xlDialogPrintPreview=222.

    Function PrintPreviewEx:boolean;
    begin
     PrintPreviewEx:=true;
     try
      E.Dialogs.Item[xlDialogPrintPreview].Show;
     except
      PrintPreviewEx:=false;
     end;
    End;

