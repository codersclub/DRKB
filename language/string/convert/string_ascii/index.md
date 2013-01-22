---
Title: String -> ASCII
Date: 01.01.2007
---


String -> ASCII
===============

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Преобразование строки S в набор её чисел,
    где каждое число представляет каждый символ строки
     
    Получив строку S функция преобразует её в набор чисел, каждое из которых
    обозначает код текущего символа, а перед каждым числом располагается символ "#".
    Пусть, например, S = 'Hello';
    Тогда Result = '#72#101#108#108#111';
     
    Зависимости: system
    Автор:       VID, vidsnap@mail.ru, ICQ:132234868, Махачкала
    Copyright:   VID
    Дата:        25 апреля 2002 г.
    ***************************************************** }
     
    function StrToAscii(S: string): string;
    var
      I, X: Integer;
      RS: string;
      CurChar: string;
    begin
      Result := '';
      if Length(S) = 0 then
        Exit;
      X := 1;
      for I := 1 to Length(S) do
      begin
        CurChar := '#' + Inttostr(Ord(S[I]));
        Insert(CurChar, RS, X);
        X := X + Length(CurChar);
      end;
      Result := RS;
    end;

 
