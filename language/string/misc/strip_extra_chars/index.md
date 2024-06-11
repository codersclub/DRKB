---
Title: Быстрые функции сжатия пробелов и управляющих символов в строке
Author: Александр Шарахов, alsha@mailru.com
Date: 02.02.2003
---


Быстрые функции сжатия пробелов и управляющих символов в строке
===============================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Быстрые функции сжатия пробелов и управляющих символов в строке.
     
    Функции удаляют из строки начальные и конечные пробелы и управляющие
    символы (меньшие пробела). Идущие подряд пробелы и управляющие символы
    в середине строки заменяются одним пробелом.
     
    Зависимости: нет
    Автор:       Александр Шарахов, alsha@mailru.com, Москва
    Copyright:   Александр Шарахов
    Дата:        2 февраля 2003 г.
    ***************************************************** }
     
    // Sha_SpaceCompress удаляет из Ansi-строки начальные и конечные пробелы
    // и управляющие символы (меньшие пробела). Идущие подряд пробелы
    // и управляющие символы в середине строки заменяются одним пробелом.
    // Исходная строка при этом не изменяется. Эта функция работает
    // медленнее, чем Sha_SpaceCompressInplace. С целью ускорения работы
    // освобождение неиспользуемой памяти за пределами строки не производится.
    // Если это критично, после вызова данной функции можно освободить память
    // следующим образом: s2:=Sha_SpaceCompress(s1); SetLength(s2,Length(s2));
    // Функция не работает, если нарушен формат Ansi-строки, в частности,
    // если в конце строки отсутствует терминатор.
     
    function Sha_SpaceCompress(const s: string): string;
    var
      p, q, t: pchar;
      ch: char;
    label
      rt;
    begin
      ;
      p := pointer(s);
      q := nil;
      if p <> nil then
      begin
        ;
        t := p + (pinteger(p - 4))^;
        if p < t then
        begin
          ;
          repeat;
            dec(t);
            if p > t then
              goto rt;
          until (t^ > ' ');
          SetString(Result, nil, (t - p) + 1);
          q := pchar(pointer(Result));
          repeat;
            repeat;
              ch := p^;
              inc(p);
            until ch > ' ';
            repeat;
              q^ := ch;
              ch := p^;
              inc(q);
              inc(p);
            until ch <= ' ';
            q^ := ' ';
            inc(q);
          until p > t;
        end;
      end;
      rt:
      if q <> nil then
      begin
        ;
        dec(q);
        q^ := #0;
        (pinteger(pchar(pointer(Result)) - 4))^ := q - pointer(Result);
      end
      else
        Result := '';
    end;
     
    // Sha_SpaceCompressInplace удаляет из Ansi-строки начальные и конечные пробелы
    // и управляющие символы (меньшие пробела). Идущие подряд пробелы
    // и управляющие символы в середине строки заменяются одним пробелом.
    // Результат замещает исходную строку. С целью ускорения работы
    // освобождение неиспользуемой памяти за пределами строки не производится.
    // Если это критично, после вызова данной функции можно освободить память
    // следующим образом: Sha_SpaceCompressInpace(s); SetLength(s,Length(s));
    // Процедура не работает, если нарушен формат Ansi-строки, в частности,
    // если в конце строки отсутствует терминатор.
     
    procedure Sha_SpaceCompressInplace(var s: string);
    var
      p, q, t: pchar;
      ch: char;
    label
      rt;
    begin
      ;
      UniqueString(s);
      p := pointer(s);
      if p <> nil then
      begin
        ;
        t := p + (pinteger(p - 4))^;
        if p < t then
        begin
          ;
          q := p;
          repeat;
            dec(t);
            if p > t then
              goto rt;
          until (t^ > ' ');
          repeat;
            repeat;
              ch := p^;
              inc(p);
            until ch > ' ';
            repeat;
              q^ := ch;
              ch := p^;
              inc(q);
              inc(p);
            until ch <= ' ';
            q^ := ' ';
            inc(q);
          until p > t;
          dec(q);
          rt: q^ := #0;
          (pinteger(pchar(pointer(s)) - 4))^ := q - pointer(s);
        end;
      end;
    end;
     
    // Sha_SpaceCompressPChar удаляет из null-terminated строки начальные
    // и конечные пробелы и управляющие символы (меньшие пробела), за исключением
    // терминатора. Идущие подряд пробелы и управляющие символы в середине строки
    // заменяются одним пробелом. Результат замещает исходную строку.
    // Никакое перераспределения памяти не производится.
    // Функция не работает с read-only строкой.
     
    function Sha_SpaceCompressPChar(p: pchar): pchar;
    var
      q: pchar;
      ch: char;
    label
      rt;
    begin
      ;
      Result := p;
      if (p <> nil) and (p^ <> #0) then
      begin
        ;
        q := p - 1;
        repeat;
          repeat;
            ch := p^;
            inc(p);
            if ch = #0 then
              goto rt;
          until ch > ' ';
          inc(q);
          repeat;
            q^ := ch;
            ch := p^;
            inc(q);
            inc(p);
          until ch <= ' ';
          q^ := ' ';
        until ch = #0;
        rt: if q < Result then
          inc(q);
        q^ := #0;
      end;
    end;

Пример использования: 
     
    s2 := Sha_SpaceCompress(s1);
    Sha_SpaceCompressInpace(s);
    Sha_SpaceCompressPChar(pch); 

