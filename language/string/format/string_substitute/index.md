---
Title: Форматирование строки с использованием подстановочных символов
Author: Dimka Maslov, mainbox@endimus.ru
Date: 15.05.2002
---


Форматирование строки с использованием подстановочных символов
==============================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Форматирование строки с использованием подстановочных символов %1, %2 и т.д.
     
    Функция заменяет в строке Str все подстроки '%1', '%2', и т.д. На
    соответсвующие значения из массива Values. При этом значения этого массива
    не должны содержать подстановочных подстрок, в противном случае возможно
    зависание функции.
     
    Зависимости: SysUtils
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        15 мая 2002 г.
    ***************************************************** }
     
    {Эта функция работает неверно, если в строке, на которую надо
    заменить %1,%2,… содержится одна из строк %1,%2,…
    ( она зависнет в бесконечном цикле )}
     
    function FmtString(const Str: string; const Values: array of string): string;
     
      function InternalPos(SubStr: string; Str: PChar; out P: Integer): Integer;
      var
        Ptr: PChar;
      begin
        Ptr := StrPos(Str, PChar(SubStr));
        if Ptr = nil then
          Result := -1
        else
          Result := Integer(Ptr) - Integer(Str);
        P := Result;
      end;
     
      function InternalReplace(const Str, OldSub, NewSub: string): string;
      var
        PrePos: Integer;
        CurPos: Integer;
        OldLen, NewLen: Integer;
      begin
        PrePos := 1;
        Result := Str;
        OldLen := Length(OldSub);
        NewLen := Length(NewSub);
        while InternalPos(OldSub, @Result[PrePos], CurPos) >= 0 do
        begin
          Inc(PrePos, CurPos);
          Delete(Result, PrePos, OldLen);
          Insert(NewSub, Result, PrePos);
          Inc(PrePos, NewLen);
        end;
      end;
     
    var
      i: Integer;
    begin
      Result := Str;
      for i := High(Values) downto Low(Values) do
        Result := InternalReplace(Result, '%' + IntToStr(i + 1), Values[i]);
    end;

Пример использования: 
     
    FmtString('%1 %2', ['Пример', 'использования']);

