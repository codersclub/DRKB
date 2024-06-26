---
Title: Получение размера памяти выделенный под Pointer
Author: Мироводин Дмитрий, mirovodin@mail.ru
Date: 16.10.2003
---


Получение размера памяти выделенный под Pointer
===============================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Получение размера памяти выделенный под Pointer
     
    Функция возвращает количество байт выделенных под Pointer.
    Размер округляется в большую сторону до DWORD (4 байт).
     
    Зависимости: Windows
    Автор:       Мироводин Дмитрий, mirovodin@mail.ru
    Copyright:   Мироводин Дмитрий
    Дата:        16 октября 2003 г.
    ***************************************************** }
     
    function GetPointerSize(const P: Pointer): Integer;
    begin
      if P = nil then
        Result := -1
      else
        Result := Integer(Pointer((Integer(p) - 4))^) and $7FFFFFFC - 4;
    end;
    Пример использования: 
     
    var
      P: pointer;
      PSize: integer;
    begin
      GetMem(P, 1024); // Размер кратен 4
      PSize := GetPointerSize(P);
      ShowMessage(inttostr(PSize)); // Результат 1024 байта
      FreeMem(P);
    end;
     
    ...
     
    var
      P: pointer;
      PSize: integer;
    begin
      // Размер НЕ КРАТЕН 4
      GetMem(P, 6);
      PSize := GetPointerSize(P);
      // Результат 8 байта т.к. идет округление
      ShowMessage(inttostr(PSize));
      FreeMem(P);
    end;

