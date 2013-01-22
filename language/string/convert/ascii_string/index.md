---
Title: ASCII -> String
Date: 01.01.2007
---


ASCII -> String
===============

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Преобразование набора чисел, предопределённых символом "#" в строку
     
    Функция преобразует набор чисел, предопределённых символом "#" в
    соответствующую строку. Каждое число в наборе чисел должно представлять из
    себя код символа по ASCII таблице.
    Например, если AsciiString '#72#101#108#108#111', то Result = 'Hello';
     
    Зависимости: sysutils, system
    Автор:       VID, vidsnap@mail.ru, ICQ:132234868, Махачкала
    Copyright:   VID
    Дата:        26 апреля 2002 г.
    ***************************************************** }
     
    function ASCIIToStr(AsciiString: string): string;
    var
      I, X, L, Lastpos: Integer;
      CurDIGChar, CurrAddChar, RS: string;
    begin
      RESULT := '';
      L := Length(AsciiString);
      if L = 0 then
        Exit;
      X := 0;
      LASTPOS := 1;
      repeat
        I := X;
        CurDIGChar := '';
        repeat
          I := I + 1;
          if AsciiString[I] <> '#' then
            CurDIGChar := CurDIGChar + AsciiString[I];
        until (AsciiString[I] = '#') or (i = l);
        X := I;
        if CurDIGChar <> '' then
        begin
          try
            CurrAddChar := CHR(STRTOINT(CurDIGChar));
          except CurrAddChar := '';
          end;
          Insert(CurrAddChar, RS, lastpos);
          LastPos := LastPos + Length(CurrAddChar);
        end;
      until (X >= L) or (I >= L);
      Result := RS;
    end;
     
