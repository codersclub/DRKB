---
Title: Функция возвращающая n-ое слово в строке
Author: TP@MB@Y
Date: 01.01.2007
---


Функция возвращающая n-ое слово в строке
========================================

::: {.date}
01.01.2007
:::

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

Автор: TP@MB@Y

Взято с Vingrad.ru <https://forum.vingrad.ru>

 

------------------------------------------------------------------------

    function GetToken(aString, SepChar: string; TokenNum: Byte): string;
    {
    параметры: aString : полная строка
     
    SepChar : единственный символ, служащий
    разделителем между словами (подстроками)
    TokenNum: номер требуемого слова (подстроки))
    result    : искомое слово или пустая строка, если количество слов
     
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
    parameters: aString : полная строка
     
    SepChar : единственный символ, служащий
    разделителем между словами (подстроками)
    result    : количество найденных слов (подстрок)
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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 

------------------------------------------------------------------------

    function CopyColumn(const s_string: string; c_fence: char; i_index: integer):
      string;
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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 

------------------------------------------------------------------------

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
    //Пример использования: 
     
    GetWord('Здесь ваш текст',' ',3); // Возвращает -> 'текст'
     
