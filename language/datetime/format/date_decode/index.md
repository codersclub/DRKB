---
Title: Преобразование даты, месяц прописью
Date: 01.01.2007
---


Преобразование даты, месяц прописью
===================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Преобразование даты (месяц прописью)
     
    Преобразование даты. Например: 23.02.02 преобразуется в 23 февраля 2002 года.
     
    Зависимости: DecodeDate
    Автор:       mukha, mukha@vistcom.ru, Волгоград
    Copyright:   mukha
    Дата:        17 ноября 2002 г.
    ***************************************************** }
     
    function Monthstr(S: string): string;
    const
      Mes: array[1..12] of string = ('января', 'февраля', 'марта', 'апреля',
        'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября',
          'декабря');
    var
      Year, Month, Day: Word;
    begin
      try
        StrToDate(S); // пр-ка правильности ввода даты
        DecodeDate(StrToDate(S), Year, Month, Day);
        Result := IntToStr(day);
        Result := Result + ' ' + Mes[Month];
        Result := result + ' ' + IntToStr(Year) + ' года';
      except
        raise
          Exception.Create('"' + s + '"' + ' - такой даты нет!');
      end;
    end;

 
