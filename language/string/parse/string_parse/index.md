---
Title: Парсинг строк
Author: Song
Date: 01.01.2007
---


Парсинг строк
=============

Вариант 1:

Author: Song

Source: <https://forum.sources.ru>

    unit splitfns;
    interface
    uses Classes, Sysutils;
    function GetNextToken(Const S: string; Separator: TSysCharSet; var StartPos: integer): String;

    {Returns the next token (substring) from string S, starting at index StartPos and ending 1 character
    before the next occurrence of Separator (or at the end of S, whichever comes first).}

    {StartPos returns the starting position for the next token, 1 more than the position in S of
    the end of this token}

    procedure Split(const S: String; Separator: TSysCharSet; MyStringList: TStringList);

    {Splits a string containing designated separators into tokens and adds them to MyStringList NOTE: MyStringList must be Created before being passed to this procedure and Freed after use}

    function AddToken (const aToken, S: String; Separator: Char; StringLimit: integer): String;

    {Used to join 2 strings with a separator character between them and can be used in a Join function}
    {The StringLimit parameter prevents the length of the Result String from exceeding a preset maximum}

    implementation

    function GetNextToken(Const S: string; Separator: TSysCharSet; var StartPos: integer): String;
    var Index: integer;
    begin
       Result := '';
    {Step over repeated separators}
       While (S[StartPos] in Separator) and (StartPos <= length(S)) do  StartPos := StartPos + 1;

       if StartPos > length(S) then Exit;

    {Set Index to StartPos}
       Index := StartPos;

    {Find the next Separator}
       While not (S[Index] in Separator) and (Index <= length(S))do Index := Index + 1;

    {Copy the token to the Result}
       Result := Copy(S, StartPos, Index - StartPos);

    {SetStartPos to next Character after the Separator}
       StartPos := Index + 1;
    end;

    procedure Split(const S: String; Separator: TSysCharSet; MyStringList: TStringList);
    var Start: integer;
    begin
       Start := 1;
       While Start <= Length(S) do MyStringList.Add(GetNextToken(S, Separator, Start));
    end;

    function AddToken (const aToken, S: String; Separator: Char; StringLimit: integer): String;
    begin
       if Length(aToken) + Length(S) < StringLimit then
         begin
           {Add a separator unless the Result string is empty}
           if S = '' then Result := '' else Result := S + Separator;

           {Add the token}
           Result := Result + aToken;
         end
       else
       {if the StringLimit would be
       exceeded, raise an exception}
         Raise Exception.Create('Cannot add token');
    end;
    end. 


пример использования:

    ...
    data:= TStringList.Create;
    splited:=TStringList.Create;
    data.LoadFromFile(s);
    Split(data.Text,[',',' ',#10,#13,';','"','.','!','-','+','*','/','\',
    '(',')','[',']','{','}','<','>','''','"','?','"','#',#0],splited);
    for i:= 0 to splited.Count-1 do
    begin
       if not words.Find(splited.Strings,adr) then
          words.Add(splited.Strings[i]);
       application.processmessages;[i]//make program to respond to user 
          //commands while processing in case of very long string.
    end;
    ...

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Некоторое время назад одна любезная душа прислала мне этот модуль. Я
нашел его весьма полезным, но применять его вам надлежит с некоторой
долей осторожности, ибо тэг %s иногда приводит к исключительным
ситуациям.

    unit Scanf;
     
    interface
    uses SysUtils;
     
    type
     
      EFormatError = class(ExCeption);
     
    function Sscanf(const s: string; const fmt: string;
      const Pointers: array of Pointer): Integer;
    implementation
     
    { Sscanf выполняет синтаксический разбор входной строки. Параметры...
     
    s - входная строка для разбора
    fmt - 'C' scanf-форматоподобная строка для управления разбором
    %d - преобразование в Long Integer
    %f - преобразование в Extended Float
    %s - преобразование в строку (ограничено пробелами)
    другой символ - приращение позиции s на "другой символ"
    пробел - ничего не делает
    Pointers - массив указателей на присваиваемые переменные
     
    результат - количество действительно присвоенных переменных
     
    Например, ...
    Sscanf('Name. Bill   Time. 7:32.77   Age. 8',
           '. %s . %d:%f . %d', [@Name, @hrs, @min, @age]);
     
    возвратит ...
    Name = Bill  hrs = 7  min = 32.77  age = 8 }
     
    function Sscanf(const s: string; const fmt: string;
     
      const Pointers: array of Pointer): Integer;
    var
     
      i, j, n, m: integer;
      s1: string;
      L: LongInt;
      X: Extended;
     
    function GetInt: Integer;
    begin
      s1 := '';
      while (s[n] = ' ') and (Length(s) > n) do
        inc(n);
      while (s[n] in ['0'..'9', '+', '-'])
        and (Length(s) >= n) do
      begin
        s1 := s1 + s[n];
        inc(n);
      end;
      Result := Length(s1);
    end;
   
    function GetFloat: Integer;
    begin
      s1 := '';
      while (s[n] = ' ') and (Length(s) > n) do
        inc(n);
      while (s[n] in ['0'..'9', '+', '-', '.', 'e', 'E'])
        and (Length(s) >= n) do
      begin
        s1 := s1 + s[n];
        inc(n);
      end;
      Result := Length(s1);
    end;
   
    function GetString: Integer;
    begin
      s1 := '';
      while (s[n] = ' ') and (Length(s) > n) do
        inc(n);
      while (s[n] <> ' ') and (Length(s) >= n) do
      begin
        s1 := s1 + s[n];
        inc(n);
      end;
      Result := Length(s1);
    end;
   
    function ScanStr(c: Char): Boolean;
    begin
      while (s[n] <> c) and (Length(s) > n) do
        inc(n);
      inc(n);
   
      if (n <= Length(s)) then
        Result := True
      else
        Result := False;
    end;
   
    function GetFmt: Integer;
    begin
      Result := -1;
   
      while (TRUE) do
      begin
        while (fmt[m] = ' ') and (Length(fmt) > m) do
          inc(m);
        if (m >= Length(fmt)) then
          break;
   
        if (fmt[m] = '%') then
        begin
          inc(m);
          case fmt[m] of
            'd': Result := vtInteger;
            'f': Result := vtExtended;
            's': Result := vtString;
          end;
          inc(m);
          break;
        end;
   
        if (ScanStr(fmt[m]) = False) then
          break;
        inc(m);
      end;
    end;
     
    begin
     
      n := 1;
      m := 1;
      Result := 0;
     
      for i := 0 to High(Pointers) do
      begin
        j := GetFmt;
     
        case j of
          vtInteger:
            begin
              if GetInt > 0 then
              begin
                L := StrToInt(s1);
                Move(L, Pointers[i]^, SizeOf(LongInt));
                inc(Result);
              end
              else
                break;
            end;
     
          vtExtended:
            begin
              if GetFloat > 0 then
              begin
                X := StrToFloat(s1);
                Move(X, Pointers[i]^, SizeOf(Extended));
                inc(Result);
              end
              else
                break;
            end;
     
          vtString:
            begin
              if GetString > 0 then
              begin
                Move(s1, Pointers[i]^, Length(s1) + 1);
                inc(Result);
              end
              else
                break;
            end;
     
        else
          break;
        end;
      end;
    end;
     
    end.


------------------------------------------------------

Вариант 3:

Source: <https://www.swissdelphicenter.ch>

    // Parse a string, for example: 
    // How do I get the "B" from "A|B|C|D|E|F"? 
     
    function Parse(Char, S: string; Count: Integer): string;
     var
       I: Integer;
       T: string;
     begin
       if S[Length(S)] <> Char then
         S := S + Char;
       for I := 1 to Count do
       begin
         T := Copy(S, 0, Pos(Char, S) - 1);
         S := Copy(S, Pos(Char, S) + 1, Length(S));
       end;
       Result := T;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       ShowMessage(Parse('|', 'A|B|C|D|E|F', 2));
     end;
     
     { 
      Parameters: 
     
      Parse([Character, for example "|"], [The string], 
      [The number, the "B" is the 2nd part of the string]); 
     
      This function is handy to use when sending data over the internet, 
      for example a chat program: Name|Text. Note: Be sure there's no "Char" in the string! 
      Use a unused character like "|" or "?". 
    }

