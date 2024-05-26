---
Title: Универсальная функция возврата значения элемента даты
Author: Галимарзанов Фанис
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Универсальная функция возврата значения элемента даты
=====================================================

Универсальная функция возврата значения элемента даты (год, месяц, день,
квартал):

    function RetDate(inDate: TDateTime; inTip: integer): integer;
    var
      xYear, xMonth, xDay: word;
    begin
      Result := 0;
      DecodeDate(inDate, xYear, xMonth, xDay);
      case inTip of
        1: Result := xYear;  // год
        2: Result := xMonth; // месяц
        3: Result := xDay;   // день
        4: if xMonth < 4 then
             Result := 1
           else // квартал
           if xMonth < 7 then
             Result := 2
           else
           if xMonth < 10 then
             Result := 3
           else
             Result := 4;
      end;
    end; 


