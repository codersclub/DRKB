---
Title: Преобразование даты и времени в строковый вид YYYYMMDDHHNNSS и обратно
Author: mfender, mfender@fromru.com
Date: 10.08.2003
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Преобразование даты и времени в строковый вид YYYYMMDDHHNNSS и обратно
======================================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Преобразование даты-времени в строковый вид и обратно (yyyymmddhhnnss)
     
    Иногда становится нужно хранить дату и время в виде yyyymmddhhnnss.
    Так, по некоторым причинам, с ними порой легче общаться и сортировать.
     
    Зависимости: Windows, StdCtrls, SysUtils
    Автор:       mfender, mfender@fromru.com, Майкоп
    Copyright:   mfender
    Дата:        10 августа 2003 г.
    ***************************************************** }
     
    function mfStringToDateTime(const mfDTStr: string): TDateTime;
    //Возвращает значение TDateTime из входящей строки mfDTStr
    //в формате YYYYMMDDHHMMSS
    var
      Safe: string;
    begin
      Safe := ShortDateFormat; //сохраняем формат даты
      ShortDateFormat := 'dd.mm.yyyy hh:nn:ss'; //придаем произвольный вид
      //формату даты-времени
      mfStringToDateTime := StrToDateTime(Copy(mfDTStr, 7, 2) + '.' +
        Copy(mfDTStr, 5, 2) + '.' +
        Copy(mfDTStr, 1, 4) + ' ' +
        Copy(mfDTStr, 9, 2) + ':' +
        Copy(mfDTStr, 11, 2) + ':' +
        Copy(mfDTStr, 13, 2));
      //Преобразуем, собственно, части строки в соответствующие
      //детали даты и времени
      ShortDateFormat := Safe; //возвращаем дате первоначальный вид
    end;
     
    function mfDateTimeToString(const Date: TDateTime): string;
    //Возвращает строку в формате YYYYMMDDHHNNSS из входящей DateTime
    begin
      mfDateTimeToString := FormatDateTime('yyyymmddhhnnss', Date); //No comments
    end;


