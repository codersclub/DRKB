---
Title: Первая буква каждого слова в верхнем регистре
Date: 01.01.2007
---


Первая буква каждого слова в верхнем регистре
=============================================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    function LowCase(ch: CHAR): CHAR;
    begin
      case ch of
        'A'..'Z': LowCase := CHR(ORD(ch) + 31);
      else
        LowCase := ch;
      end;
    end;
     
    function proper(s: string): string;
    var
      t: string;
      i: integer;
      newWord: boolean;
    begin
      if s = '' then
        exit;
      s := lowercase(s);
      t := uppercase(s);
      newWord := true;
      for i := 1 to length(s) do
      begin
        if newWord and (s[i] in ['a'..'z']) then
        begin
          s[i] := t[i];
          newWord := false;
          continue;
        end;
        if s[i] in ['a'..'z', ''''] then
          continue;
        newWord := true;
      end;
      result := s;
    end;


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    function TfrmLoadProtocolTable.ToMixCase(InString: string): string;
    var
      I: Integer;
    begin
      Result := LowerCase(InString);
      Result[1] := UpCase(Result[1]);
      for I := 1 to Length(InString) - 1 do
      begin
        if (Result[I] = ' ') or (Result[I] = '''') or (Result[I] = '"')
          or (Result[I] = '-') or (Result[I] = '.') or (Result[I] = '(') then
          Result[I + 1] := UpCase(Result[I + 1]);
      end;
    end;


------------------------------------------------------------------------

Вариант 3:

Author: VID, vidsnap@mail.ru

Date: 30.04.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Установка для каждого слова строки верхнего регистра для
    первого символа и нижнего регистра для всех остальных
     
    Пусть S = 'hello WOrLd, how aRe YOU?';
    При передаче функции в качестве параметра переменной S,
    Result = 'Hello World, How Are You?'
     
    Зависимости: sysutils, system
    Автор:       VID, vidsnap@mail.ru, ICQ:132234868, Махачкала
    Copyright:   VID
    Дата:        30 апреля 2002 г.
    ***************************************************** }
     
    function PROPER(S: string): string;
    const
      Symbols = ' _;.,1234567890';
    var
      X: Integer;
    begin
      Result := '';
      if Length(s) = 0 then
        exit;
      S[1] := AnsiUpperCase(s[1])[1];
      for X := 1 to length(s) do
        if POS(S[x], Symbols) <> 0 then
        begin
          if X <> Length(s) then
            S[x + 1] := AnsiUpperCase(s[x + 1])[1];
        end
        else
          S[x + 1] := AnsiLowerCase(S[x + 1])[1];
      Result := S;
    end;

 
