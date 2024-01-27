---
Title: Как определить установлен ли Excel?
Author: Кулюкин Олег
Date: 01.01.2007
Source: <https://www.delphikingdom.ru/>
---


Как определить установлен ли Excel?
===================================

Функция возвращает True если найден OLE-объект

Пример использования

      if not IsOLEObjectInstalled('Excel.Application') then
        ShowMessage('Класс не зарегистрирован')
      else
        ShowMessage('Класс найден');
     
     
    function IsOLEObjectInstalled(Name: String): boolean;
    var
      ClassID: TCLSID;
      Rez : HRESULT;
    begin
      // Ищем CLSID OLE-объекта
      Rez := CLSIDFromProgID(PWideChar(WideString(Name)), ClassID);
     
      if Rez = S_OK then  // Объект найден
        Result := true
      else
        Result := false;
    end;

Если нужна более подробная информация об объекте, можно почитать хелп по
функции API CLSIDFromProgID.

