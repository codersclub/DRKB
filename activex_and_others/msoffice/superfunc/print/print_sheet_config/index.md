---
Title: Некоторые общие параметры для листа
Date: 01.01.2007
---


Некоторые общие параметры для листа
===================================

::: {.date}
01.01.2007
:::


Фоновый рисунок листа устанавливается процедурой SetBackgroundPicture,
коллекции Sheets или объекта ActiveSheet. Если аргумент FileName этой
функции равен пустой строке, то это отменяет установленный ранее фоновый
рисунок. Реализация этой возможности на Delphi представлена в виде
функции SetBackgroundPicture.

    Function SetBackgroundPicture(sheet:variant;
      file_:string):boolean;
    begin
     SetBackgroundPicture:=true;
     try
      E.ActiveWorkbook.Sheets.Item
       [sheet].SetBackgroundPicture(FileName:=file_);
     except
      SetBackgroundPicture:=false;
     end;
    End;


Сетку активной страницы можно сделать видимой или невидимой, используя
свойство DisplayGridlines объекта ActiveWindow. Если перед этим
необходимо выбрать определенный лист, то используйте метод Select,
например, Sheets(\"Лист1\").Select.

    Function DisplayGridlines(display:boolean):boolean;
    begin
     DisplayGridlines:=true;
     try
      E.ActiveWindow.DisplayGridlines:=display;
     except
      DisplayGridlines:=false;
     end;
    End;

