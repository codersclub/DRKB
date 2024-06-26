---
Title: Очистка строки слева и справа от указанного символа
Date: 02.06.2002
---


Очистка строки слева и справа от указанного символа
===================================================

Вариант 1:

Author: VID, vidsnap@mail.ru
Date: 25.04.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Очистка строки слева и справа от указанных символов
     
    Функция возвращает word, очищеный от начальных и конечных символов, которые
    попадают в строку TrimSymbols.
    Например, ShowMessage (TrimEx('<MegaTeg>', '<>')), выведет сообщение "MegaTeg"
    (без кавычек).
     
    Зависимости: system, sysutils
    Автор:       VID, vidsnap@mail.ru, ICQ:132234868, Махачкала
    Copyright:   VID
    Дата:        25 апреля 2002 г.
    ***************************************************** }
     
    function TrimEX(Word, TrimSymbols: string): string;
    var
      x, a, b: Integer;
    begin
      Result := Word;
      if TrimSymbols = '' then
        exit;
      Word := Trim(word);
      if length(word) = 0 then
        exit;
     
      x := 0;
      repeat
        x := x + 1;
      until (pos(ansiuppercase(word[x]), ansiuppercase(TrimSymbols)) = 0)
        or (x = length(word));
      a := x;
     
      x := length(word) + 1;
      repeat
        x := x - 1;
      until (pos(ansiuppercase(word[x]), ansiuppercase(TrimSymbols)) = 0)
        or (x = 1);
      b := x;
     
      word := copy(word, a, b - a + 1);
      result := word;
    end;

-----------------------------------------------------------

Вариант 2:

Author: lipskiy, lipskiy@mail.ru

Date: 02.06.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Очистка строки слева и справа от указанного символа
     
    Функция возвращает строку Str, очищенную слева и справа от указанного символа Symbol.
    Работает быстрее аналогичной функции UBPFD.TrimEx, так как не использует функцию
    поиска Pos, имеет более компактный код.
     
    Зависимости: System, SysUtils
    Автор:       lipskiy, lipskiy@mail.ru, ICQ:51219290, Санкт-Петербург
    Copyright:   Собственное написание (lipskiy)
    Дата:        2 июня 2002 г.
    ***************************************************** }
     
    function TrimString(Str: string; Symbol: char): string;
    begin
      Result := Str;
      if Str = '' then
        exit;
      Str := Trim(Str);
      // Удаляем в начале строки
      while (length(Str) > 0) and
        (AnsiUpperCase(Str[1]) = AnsiUpperCase(Symbol)) do
        Delete(Str, 1, 1);
      // Удаляем в конце строки
      while (length(Str) > 0) and
        (AnsiUpperCase(Str[length(Str)]) = AnsiUpperCase(Symbol)) do
        Delete(Str, length(Str), 1);
      Result := Str;
    end;

