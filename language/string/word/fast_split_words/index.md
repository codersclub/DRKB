---
Title: Быстрая функция для разбивки строки на части (слова) в один цикл
Author: ДЫМ
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Быстрая функция для разбивки строки на части (слова) в один цикл
================================================================

    type TDelim=set of Char;
         TArrayOfString=Array of String;
     
     
    //*******************
    //
    // Разбивает строку с разделителями на части
    // и возвращает массив частей
    //
    // fcToParts
    //
     
    function fcToParts(sString:String;tdDelim:TDelim):TArrayOfString
    var iCounter,iBegin:Integer;
    begin//fc
    if length(sString)>0 then
     begin
      include(tdDelim,#0);iBegin:=1; SetLength(Result,0);
      For iCounter:=1 to Length(sString)+1 do
       begin//for
        if (sString[iCounter] in tdDelim) then
         begin
          SetLength(Result,Length(Result)+1);
          Result[Length(Result)-1]:=Copy(sString,iBegin,iCounter-iBegin);
          iBegin:=iCounter+1;
         end;
      end;//for
     end;//if
    end;//fc

Пример использования:

    var
    StrArr:TArrayOfString
     
    StrArr:=fcToParts('строка1-строка2@строка3',['-','@']):

