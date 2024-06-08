---
Title: Расширенные строковые функции
Author: Bob Swart [100434,2072]
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Расширенные строковые функции
=============================

LTrim()     - Удаляем все пробелы в левой части строки

RTrim()     - Удаляем все пробелы в правой части строки

Trim()      - Удаляем все пробелы по краям строки

RightStr()  - Возвращаем правую часть стоки заданной длины

LeftStr()   - Возвращаем левую часть стоки заданной длины

MidStr()    - Возвращаем центральную часть строки

squish()    - возвращает строку со всеми белыми пробелами и с удаленными
повторяющимися апострофами.

before()    - возвращает часть стоки, находящейся перед первой найденной
подстроки Find в строке Search. Если Find не найдена, функция возвращает
Search.

after()     - возвращает часть строки, находящейся после первой
найденной подстроки Find в строке Search. Если Find не найдена, функция
возвращает NULL.

RPos()      - возвращает первый символ последней найденной подстроки
Find в строке Search. Если Find не найдена, функция возвращает 0.
Подобна реверсированной Pos().

inside()    - возвращает подстроку, вложенную между парой подстрок Front ... Back.

leftside()  - возвращает левую часть "отстатка" inside() или Search.

rightside() - возвращает правую часть "остатка" inside() или Null.

trim()      - возвращает строку со всеми удаленными по краям белыми пробелами.

Ниже приведён исходный код этих функций:
     
    unit TrimStr;
    {$B-}
    {
    Файл: TrimStr
    Автор: Bob Swart [100434,2072]
    Описание: программы для удаления конечных/начальных пробелов
    и левых/правых частей строк (аналог Basic-функций).
    Версия: 2.0
     
    LTrim()    - Удаляем все пробелы в левой части строки
    RTrim()    - Удаляем все пробелы в правой части строки
    Trim()     - Удаляем все пробелы по краям строки
    RightStr() - Возвращаем правую часть стоки заданной длины
    LeftStr()  - Возвращаем левую часть стоки заданной длины
    MidStr()   - Возвращаем центральную часть строки
     
    }
    interface
    const
      Space = #$20;
     
    function LTrim(const Str: string): string;
    function RTrim(Str: string): string;
    function Trim(Str: string): string;
    function RightStr(const Str: string; Size: Word): string;
    function LeftStr(const Str: string; Size: Word): string;
    function MidStr(const Str: string; Size: Word): string;
     
    implementation
     
    function LTrim(const Str: string): string;
    var
      len: Byte absolute Str;
      i: Integer;
    begin
      i := 1;
      while (i <= len) and (Str[i] = Space) do
        Inc(i);
      LTrim := Copy(Str, i, len)
    end {LTrim};
     
    function RTrim(Str: string): string;
    var
      len: Byte absolute Str;
    begin
      while (Str[len] = Space) do
        Dec(len);
      RTrim := Str
    end {RTrim};
     
    function Trim(Str: string): string;
    begin
      Trim := LTrim(RTrim(Str))
    end {Trim};
     
    function RightStr(const Str: string; Size: Word): string;
    var
      len: Byte absolute Str;
    begin
      if Size > len then
        Size := len;
      RightStr := Copy(Str, len - Size + 1, Size)
    end {RightStr};
     
    function LeftStr(const Str: string; Size: Word): string;
    begin
      LeftStr := Copy(Str, 1, Size)
    end {LeftStr};
     
    function MidStr(const Str: string; Size: Word): string;
    var
      len: Byte absolute Str;
    begin
      if Size > len then
        Size := len;
      MidStr := Copy(Str, ((len - Size) div 2) + 1, Size)
    end {MidStr};
     
    end.
     
    // *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
     
    const
      BlackSpace = [#33..#126];
     
      {
      squish() возвращает строку со всеми белыми пробелами и с удаленными
      повторяющимися апострофами.
      }
     
    function squish(const Search: string): string;
    var
     
      Index: byte;
      InString: boolean;
    begin
     
      InString := False;
      Result := '';
      for Index := 1 to Length(Search) do
      begin
        if InString or (Search[Index] in BlackSpace) then
          AppendStr(Result, Search[Index]);
        InString := ((Search[Index] = '''') and (Search[Index - 1] <> '\'))
          xor InString;
      end;
    end;
     
    {
     
    before() возвращает часть стоки, находящейся перед
    первой найденной подстроки Find в строке Search. Если
    Find не найдена, функция возвращает Search.
    }
     
    function before(const Search, Find: string): string;
    var
     
      index: byte;
    begin
     
      index := Pos(Find, Search);
      if index = 0 then
        Result := Search
      else
        Result := Copy(Search, 1, index - 1);
    end;
     
    {
     
    after() возвращает часть строки, находящейся после
    первой найденной подстроки Find в строке Search. Если
    Find не найдена, функция возвращает NULL.
    }
     
    function after(const Search, Find: string): string;
    var
     
      index: byte;
    begin
     
      index := Pos(Find, Search);
      if index = 0 then
        Result := ''
      else
        Result := Copy(Search, index + Length(Find), 255);
    end;
     
    {
     
    RPos() возвращает первый символ последней найденной
    подстроки Find в строке Search. Если Find не найдена,
    функция возвращает 0. Подобна реверсированной Pos().
    }
     
    function RPos(const Find, Search: string): byte;
    var
     
      FindPtr, SearchPtr, TempPtr: PChar;
    begin
     
      FindPtr := StrAlloc(Length(Find) + 1);
      SearchPtr := StrAlloc(Length(Search) + 1);
      StrPCopy(FindPtr, Find);
      StrPCopy(SearchPtr, Search);
      Result := 0;
      repeat
        TempPtr := StrRScan(SearchPtr, FindPtr^);
        if TempPtr <> nil then
          if (StrLComp(TempPtr, FindPtr, Length(Find)) = 0) then
          begin
            Result := TempPtr - SearchPtr + 1;
            TempPtr := nil;
          end
          else
            TempPtr := #0;
      until TempPtr = nil;
    end;
     
    {
     
    inside() возвращает подстроку, вложенную между парой
    подстрок Front ... Back.
    }
     
    function inside(const Search, Front, Back: string): string;
    var
     
      Index, Len: byte;
    begin
     
      Index := RPos(Front, before(Search, Back));
      Len := Pos(Back, Search);
      if (Index > 0) and (Len > 0) then
        Result := Copy(Search, Index + 1, Len - (Index + 1))
      else
        Result := '';
    end;
     
    {
     
    leftside() возвращает левую часть "отстатка" inside() или Search.
    }
     
    function leftside(const Search, Front, Back: string): string;
    begin
     
      Result := before(Search, Front + inside(Search, Front, Back) + Back);
    end;
     
    {
     
    rightside() возвращает правую часть "остатка" inside() или Null.
    }
     
    function rightside(const Search, Front, Back: string): string;
    begin
     
      Result := after(Search, Front + inside(Search, Front, Back) + Back);
    end;
     
    {
     
    trim() возвращает строку со всеми удаленными по краям белыми пробелами.
    }
     
    function trim(const Search: string): string;
    var
     
      Index: byte;
    begin
     
      Index := 1;
      while (Index <= Length(Search)) and not (Search[Index] in BlackSpace) do
        Index := Index + 1;
      Result := Copy(Search, Index, 255);
      Index := Length(Result);
      while (Index > 0) and not (Result[Index] in BlackSpace) do
        Index := Index - 1;
      Result := Copy(Result, 1, Index);
    end;


