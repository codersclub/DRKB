---
Title: Разбивка строки на слова
Date: 01.01.2007
---


Разбивка строки на слова
========================

Вариант 1:

Приведу несколько простых функций, позволяющих работать с отдельными
словами в строке. Возможно они пригодятся вам для разбивки текстовых
полей на отдельные слова  
(`for i := 1 to NumToken do ...`)  
с последующим сохранением их в базе данных.

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    function GetToken(aString, SepChar: string; TokenNum: Byte): string;
    {
    параметры:
    aString : полная строка
    SepChar : единственный символ,
              служащий разделителем между словами (подстроками)
    TokenNum: номер требуемого слова (подстроки))
    result  : искомое слово или пустая строка, если количество слов
              меньше значения 'TokenNum'
    }
    var
     
      Token: string;
      StrLen: Byte;
      TNum: Byte;
      TEnd: Byte;
     
    begin
     
      StrLen := Length(aString);
      TNum := 1;
      TEnd := StrLen;
      while ((TNum <= TokenNum) and (TEnd <> 0)) do
      begin
        TEnd := Pos(SepChar, aString);
        if TEnd <> 0 then
        begin
          Token := Copy(aString, 1, TEnd - 1);
          Delete(aString, 1, TEnd);
          Inc(TNum);
        end
        else
        begin
          Token := aString;
        end;
      end;
      if TNum >= TokenNum then
      begin
        GetToken1 := Token;
      end
      else
      begin
        GetToken1 := '';
      end;
    end;
     
    function NumToken(aString, SepChar: string): Byte;
    {
    parameters:
    aString : полная строка
    SepChar : единственный символ,
              служащий разделителем между словами (подстроками)
    result  : количество найденных слов (подстрок)
    }
     
    var
     
      RChar: Char;
      StrLen: Byte;
      TNum: Byte;
      TEnd: Byte;
     
    begin
     
      if SepChar = '#' then
      begin
        RChar := '*'
      end
      else
      begin
        RChar := '#'
      end;
      StrLen := Length(aString);
      TNum := 0;
      TEnd := StrLen;
      while TEnd <> 0 do
      begin
        Inc(TNum);
        TEnd := Pos(SepChar, aString);
        if TEnd <> 0 then
        begin
          aString[TEnd] := RChar;
        end;
      end;
      Result := TNum;
    end;


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    function CopyColumn(const s_string: string; c_fence: char; i_index: integer): string;
    var
      i, i_left: integer;
    begin
     
      result := EmptyStr;
      if i_index = 0 then
      begin
        exit;
      end;
      i_left := 0;
      for i := 1 to Length(s_string) do
      begin
        if s_string[i] = c_fence then
        begin
          Dec(i_index);
          if i_index = 0 then
          begin
            result := Copy(s_string, i_left + 1, i - i_left - 1);
            exit;
          end
          else
          begin
            i_left := i;
          end;
        end;
      end;
      Dec(i_index);
      if i_index = 0 then
      begin
        result := Copy(s_string, i_left + 1, Length(s_string));
      end;
    end;

**P.S.**
Я знаю что в GetToken параметр SepChar (в моем случае c\_fence) строка,
не символ, но комментарий гласит, что функция ожидает единственный
символ в этой строке, и это очевидно, поскольку если вы пошлете более
одного символа, функция попросту несработает. ( Delete(aString,1,TEnd)
будет ошибкой, если Length( SepChar ) \> 1 ).

------------------------------------------------------------------------

Вариант 3:

Author: Separator, separator@mail.kz

Date: 13.11.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Разбивка строки на отдельные слова
     
    function StringToWords(const DelimitedText: string; ResultList: TStrings;
    Delimiters: TDelimiter = []): boolean - разбивает отдельную строку на
    состовляющие ее слова и результат помещает в TStringList
     
    function StringsToWords(const DelimitedStrings: TStrings; ResultList: TStrings;
    Delimiters: TDelimiter = []): boolean - разбивает любое количество строк на
    состовляющие их слова и все помещяет в один TStringList
     
    Delimiters - список символов являющихся разделителями слов,
    например такие как пробел, !, ? и т.д.
     
    Зависимости: Classes
    Автор:       Separator, separator@mail.kz, Алматы
    Copyright:   Separator
    Дата:        13 ноября 2002 г.
    ***************************************************** }
     
    unit spUtils;
     
    interface
     
    uses Classes;
     
    type
      TDelimiter = set of #0..'я' ;
     
    const
      StandartDelimiters: TDelimiter = [' ', '!', '@', '(', ')', '-', '|', '\', ';',
        ':', '"', '/', '?', '.', '>', ',', '<'];
     
    //Преобразование в набор слов
    function StringToWords(const DelimitedText: string; ResultList: TStrings;
      Delimiters: TDelimiter = []; ListClear: boolean = true): boolean;
     
    function StringsToWords(const DelimitedStrings: TStrings; ResultList: TStrings;
      Delimiters: TDelimiter = []; ListClear: boolean = true): boolean;
     
    implementation
     
    function StringToWords(const DelimitedText: string; ResultList: TStrings;
      Delimiters: TDelimiter = []; ListClear: boolean = true): boolean;
    var
      i, Len, Prev: word;
      TempList: TStringList;
     
    begin
      Result := false;
      if (ResultList <> nil) and (DelimitedText <> '') then
      try
        TempList := TStringList.Create;
        if Delimiters = [] then
          Delimiters := StandartDelimiters;
        Len := 1;
        Prev := 0;
        for i := 1 to Length(DelimitedText) do
        begin
          if Prev <> 0 then
          begin
            if DelimitedText[i] in Delimiters then
            begin
              if Len = 0 then
                Prev := i + 1
              else
              begin
                TempList.Add(copy(DelimitedText, Prev, Len));
                Len := 0;
                Prev := i + 1
              end
            end
            else
              Inc(Len)
          end
          else if not (DelimitedText[i] in Delimiters) then
            Prev := i
        end;
        if Len > 0 then
          TempList.Add(copy(DelimitedText, Prev, Len));
        if TempList.Count > 0 then
        begin
          if ListClear then
            ResultList.Assign(TempList)
          else
            ResultList.AddStrings(TempList);
          Result := true
        end;
      finally
        TempList.Free
      end
    end;
     
    function StringsToWords(const DelimitedStrings: TStrings; ResultList: TStrings;
      Delimiters: TDelimiter = []; ListClear: boolean = true): boolean;
    begin
      if Delimiters = [] then
        Delimiters := StandartDelimiters + [#13, #10]
      else
        Delimiters := Delimiters + [#13, #10];
      Result := StringToWords(DelimitedStrings.Text, ResultList, Delimiters,
        ListClear)
    end;
     
    end.

Пример использования:
     
    StringToWords(Edit1.Text, Memo1.Lines);
    StringToWords(Edit1.Text, Memo1.Lines, [' ', '.', ',']);
    StringsToWords(Memo1.Lines, Memo2.Lines);
    StringsToWords(Memo1.Lines, Memo2.Lines, [' ', '.', ',']); 


------------------------------------------------------------------------

Вариант 4:

Author: 777, nix@rbcmail.ru

Date: 15.06.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Разбиение текста на слова + получение количества слов в тексте
     
    T   : Собственно строка, которая будет разбиваться на слова
    Mode: Режим, может быть
          0: получение английских и русских слов
          1: только русских
          2: только английских
    List: Здесь хранятся найденые слова (по умолчанию = nil)
     
    возвращаемое значение: количество слов.
     
    P/S
    По идейным соображениям специальные символы, цифры
    и пробелы игнорируются.
     
    Зависимости: Windows, Classes
    Автор:       777, nix@rbcmail.ru, Архангельск
    Copyright:   777
    Дата:        15 июня 2002 г.
    ***************************************************** }
     
    function StringToWords(T: string; Mode: Short; List: Tstrings = nil): integer;
    var
      i, z: integer;
      s: string;
      c: Char;
     
      procedure Check;
      begin
        if (s > '') and (List <> nil) then
        begin
          List.Add(S);
          z := z + 1;
        end;
        s := '';
      end;
     
    begin
      i := 0;
      z := 0;
      s := '';
      if t > '' then
      begin
        while i <= Length(t) + 1 do
        begin
          c := t[i];
          case Mode of
            0: {русские и английские слова}
              if (c in ['a'..'z']) or (c in ['A'..'Z']) or (c in ['а'..'я']) or
                (c in ['А'..'Я']) and (c <> ' ') then
                s := s + c
              else
                Check;
            1: {только русские слова}
              if (c in ['а'..'я']) or (c in ['А'..'Я']) and (c <> ' ') then
                s := s + c
              else
                Check;
            2: {только английские слова}
              if (c in ['a'..'z']) or (c in ['A'..'Z']) and (c <> ' ') then
                s := s + c
              else
                check;
          end;
          i := i + 1;
        end;
      end;
      result := z;
    end;

Пример использования: 
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Source, Dest: Tstrings;
      i: integer;
    begin
      Source := TstringList.Create;
      Dest := TstringList.Create;
      Source.LoadFromFile('c:\MyText.txt');
      for i := 0 to Source.Count - 1 do
      begin
        StringToWords(Source[i], 2, Dest);
        Application.ProcessMessages;
      end;
      Dest.SaveToFile('c:\MyWords.txt');
      ShowMessage('Найдено ' + IntToStr(Dest.Count) + ' слов');
    end;


------------------------------------------------------------------------

Вариант 5:

Source: <https://www.swissdelphicenter.ch>

    procedure SplitTextIntoWords(const S: string; words: TstringList);
    var
      startpos, endpos: Integer;
    begin
      Assert(Assigned(words));
      words.Clear;
      startpos := 1;
      while startpos <= Length(S) do
      begin
        // skip non-letters 
        while (startpos <= Length(S)) and not IsCharAlpha(S[startpos]) do
          Inc(startpos);
        if startpos <= Length(S) then
        begin
          // find next non-letter 
          endpos := startpos + 1;
          while (endpos <= Length(S)) and IsCharAlpha(S[endpos]) do
            Inc(endpos);
          words.Add(Copy(S, startpos, endpos - startpos));
          startpos := endpos + 1;
        end; { If }
      end; { While }
    end; { SplitTextIntoWords }
     
    function StringMatchesMask(S, mask: string;
      case_sensitive: Boolean): Boolean;
    var
      sIndex, maskIndex: Integer;
    begin
      if not case_sensitive then
      begin
        S    := AnsiUpperCase(S);
        mask := AnsiUpperCase(mask);
      end; { If }
      Result    := True; // blatant optimism 
      sIndex    := 1;
      maskIndex := 1;
      while (sIndex <= Length(S)) and (maskIndex <= Length(mask)) do
      begin
        case mask[maskIndex] of
          '?':
            begin
              // matches any character 
              Inc(sIndex);
              Inc(maskIndex);
            end; { case '?' }
          '*':
            begin
              // matches 0 or more characters, so need to check for 
              // next character in mask 
              Inc(maskIndex);
              if maskIndex > Length(mask) then
                // * at end matches rest of string 
                Exit
              else if mask[maskindex] in ['*', '?'] then
                raise Exception.Create('Invalid mask');
              // look for mask character in S 
              while (sIndex <= Length(S)) and
                (S[sIndex] <> mask[maskIndex]) do
                Inc(sIndex);
              if sIndex > Length(S) then
              begin
                // character not found, no match 
                Result := False;
                Exit;
              end;
              { If }
            end; { Case '*' }
          else if S[sIndex] = mask[maskIndex] then
            begin
              Inc(sIndex);
              Inc(maskIndex);
            end { If }
            else
              begin
                // no match 
                Result := False;
                Exit;
              end;
        end; { Case }
      end; { While }
      // if we have reached the end of both S and mask we have a complete 
      // match, otherwise we only have a partial match 
      if (sIndex <= Length(S)) or (maskIndex <= Length(mask)) then
        Result := False;
    end; { stringMatchesMask }
    
    procedure FindMatchingWords(const S, mask: string;
      case_sensitive: Boolean; matches: Tstrings);
    var
      words: TstringList;
      i: Integer;
    begin
      Assert(Assigned(matches));
      words := TstringList.Create;
      try
        SplitTextIntoWords(S, words);
        matches.Clear;
        for i := 0 to words.Count - 1 do
        begin
          if stringMatchesMask(words[i], mask, case_sensitive) then
            matches.Add(words[i]);
        end; { For }
      finally
        words.Free;
      end;
    end;
    
    { 
    The Form has one TMemo for the text to check, one TEdit for the mask, 
    one TCheckbox (check = case sensitive), one TListbox for the results, 
    one Tbutton 
    }
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      FindMatchingWords(memo1.Text, edit1.Text, checkbox1.Checked, listbox1.Items);
    end;


------------------------------------------------------------------------

Вариант 6:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Расщепить строку в слова и обратно

    unit StrFuncs;
     
    interface 
     
    uses SysUtils, Classes; 
     
    function StrToArrays(str, r: string; out temp: TStrings): Boolean; 
    function ArrayToStr(str: TStrings; r: string): string; 
     
    implementation 
     
    function StrToArrays(str, r: string; out temp: TStrings): Boolean; 
    var 
      j: Integer; 
    begin 
      if temp <> nil then  
      begin 
        temp.Clear; 
        while str <> '' do  
        begin 
          j := Pos(r, str); 
          if j = 0 then j := Length(str) + 1; 
          temp.Add(Copy(Str, 1, j - 1)); 
          Delete(Str, 1, j + Length(r) - 1); 
        end; 
        Result := True; 
        else  
          Result := False; 
      end; 
    end; 
     
     
    function ArrayToStr(str: TStrings; r: string): string; 
    var 
      i: Integer; 
    begin 
      Result := ''; 
      for i := 0 to Str.Count - 1 do 
      begin 
        Result := Result + Str.Strings[i] + r; 
      end; 
    end; 
    end.


---------------------------------------------------------

Вариант 7:

Author: Gua, fbsdd@ukr.net

Date: 02.05.2002

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Получение N-го слова из строки
     
    Зависимости: System
    Автор:       Gua, fbsdd@ukr.net, ICQ:141585495, Simferopol
    Copyright:   Gua
    Дата:        02 мая 2002 г.
    ***************************************************** }
     
    {
      Str: Строка
      Smb: Разгранечительный символ
      WordNmbr: Номер нужного сова
    }
     
    function GetWord(Str, Smb: string; WordNmbr: Byte): string;
    var
      SWord: string;
      StrLen, N: Byte;
    begin
     
      StrLen := SizeOf(Str);
      N := 1;
     
      while ((WordNmbr >= N) and (StrLen <> 0)) do
      begin
        StrLen := Pos(Smb, str);
        if StrLen <> 0 then
        begin
          SWord := Copy(Str, 1, StrLen - 1);
          Delete(Str, 1, StrLen);
          Inc(N);
        end
        else
          SWord := Str;
      end;
     
      if WordNmbr <= N then
        Result := SWord
      else
        Result := '';
    end;

Пример использования: 
     
    GetWord('Здесь ваш текст',' ',3); // Возвращает -> 'текст'
     
------------------------------------------------------------------------

Вариант 8:

Author: TP@MB@Y

Source: Vingrad.ru <https://forum.vingrad.ru>

    //Функция возвращающая N-ое слово в строке
    //Если N=0, то функция возвращает подстоку начиная с первого разделителя
    function GetWord(str:string;n:word;sep:char):string;
    var i,space,l,j:integer;
        buf:string;
    begin
     l:=length(str);
     if n=0 then begin  //особый параметр
                  j:=pos(GetWord(str,2,sep),str);
                  GetWord:=copy(str,j,l-j+1);
                  exit
                 end;
     space:=0;
     i:=0;
     while (space<>(n-1))and(i<=l) do
      begin
       i:=i+1;
       if str[i]=sep then space:=space+1
      end;
     i:=i+1;
     buf:='';
     while (i<=l)and(str[i]<>sep) do
      begin
       buf:=buf+str[i];
       i:=i+1
      end;
     GetWord:=buf;
    end;

