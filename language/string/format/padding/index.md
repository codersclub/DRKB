---
Title: Дополнение строки пробелами
Author: Anatoly Podgoretsky, anatoly@podgoretsky.com
Date: 26.04.2002
---


Дополнение строки пробелами
===========================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Дополнение строки пробелами слева
     
    Дополненяет строку слева пробелами до указанной длины
     
    Зависимости: нет
    Автор:       Anatoly Podgoretsky, anatoly@podgoretsky.com, Johvi
    Copyright:
    Дата:        26 апреля 2002 г.
    ***************************************************** }
     
    function PADL(Src: string; Lg: Integer): string;
    begin
      Result := Src;
      while Length(Result) < Lg do
        Result := ' ' + Result;
    end;
    
    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Дополнение строки пробелами справа
     
    Дополняет строку пробелами справа до указанной длины.
     
    Зависимости: нет
    Автор:       Anatoly Podgoretsky, anatoly@podgoretsky.com, Johvi
    Copyright:   Anatoly Podgoretsky
    Дата:        26 апреля 2002 г.
    ***************************************************** }
     
    function PADR(Src: string; Lg: Integer): string;
    begin
      Result := Src;
      while Length(Result) < Lg do
        Result := Result + ' ';
    end;
    
    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Дополнение строки пробелами с обоих сторон
     
    Дополнение строки пробелами с обоих сторон до указанной длины
     
    Зависимости: нет
    Автор:       Anatoly Podgoretsky, anatoly@podgoretsky.com, Johvi
    Copyright:
    Дата:        26 апреля 2002 г.
    ***************************************************** }
     
    function PADC(Src: string; Lg: Integer): string;
    begin
      Result := Src;
      while Length(Result) < Lg do
      begin
        Result := Result + ' ';
        if Length(Result) < Lg then
        begin
          Result := ' ' + Result;
        end;
      end;
    end;
     
Пример использования: 
     
    S := PADL(S,32); 
     
