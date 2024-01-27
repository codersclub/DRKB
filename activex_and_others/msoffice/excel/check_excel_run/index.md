---
Title: Как определить запущен ли Excel?
Author: Кулюкин Олег
Date: 01.01.2007
Source: <https://www.delphikingdom.ru/>
---


Как определить запущен ли Excel?
================================

Данный пример ищет активный экземпляр Excel и делает его видимым

    var
        ExcelApp : Variant;
    begin
      try
        // Ищем запущеный экземплят Excel, если он не найден, вызывается исключение
        ExcelApp := GetActiveOleObject('Excel.Application');
     
        // Делаем его видимым
        ExcelApp.Visible := true;
      except
      end;

