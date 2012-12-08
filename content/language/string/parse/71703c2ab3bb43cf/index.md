---
Title: Поиск n-ого вхождения подстроки в строку
Date: 01.01.2007
---


Поиск n-ого вхождения подстроки в строку
========================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Поиск N-ого вхождения подстроки в строку
     
    Зависимости: SysUtils
    Автор:       panov, panov@hotbox.ru, Екатеринбург
    Copyright:   panov
    Дата:        19 апреля 2002 г.
    ***************************************************** }
     
    function SearchString(const FindStr, SourceString: string; Num: Integer):
      Integer;
    var
      FirstSym: PChar; //Ссылка на первый символ
     
      function MyPos(const FindStr, SourceString: PChar; Num: Integer): PChar;
      begin
        Result := AnsiStrPos(SourceString, FindStr);
          //Поиск вхождения подстроки в строку
        if (Result = nil) then
          Exit; //Подстрока не найдена
        Inc(Result); //Смещаем указатель на следующий символ
        if Num = 1 then
          Exit; //Если нужно первое вхождение - заканчиваем
        if num > 1 then
          Result := MyPos(FindStr, Result, num - 1);
        //Рекурсивный поиск следующего вхождения
      end;
     
    begin
      FirstSym := PChar(SourceString);
      //Присваиваем адрес первого символа исходной строки
      Result := MyPos(PChar(FindStr), PChar(SourceString), Num) - FirstSym;
      //Номер позиции в строке
      if Result < 0 then
        Result := 0; //Возвращаем номер позиции
    end;
    //Пример использования: 
     
    var
      StrF, StrSrc: string;
      n: Integer;
    begin
      ...
      StrF := 'стр';
      StrSrc := 'Поиск подстроки в строке';
      n := SearchString(StrF, StrSrc, 2); //n будет равна 19
    end;
