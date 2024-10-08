---
Title: Как прочитать русский текст MS DOS?
Date: 01.01.2007
---

Как прочитать русский текст MS DOS?
===================================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Для перекодировки из Win(1251) кодовой страницы в Dos(866) кодовую
страницу и обратно используются функции:

- CharToOEM
- OEMToChar
- CharToOEMBuff
- OEMToCharBuff
- OemToAnsi
- AnsiToOem

Пример чтения текста dos из файла в memo

    procedure TForm1.FormCreate(Sender: TObject);
    var
      N: PChar;
    begin
      memo1.Lines.LoadFromFile('c:\file.txt');
      N := Memo1.Lines.GetText;
      OemToAnsi(N, N);
      Memo1.Lines.Text := StrPas(N);
    end;


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    procedure TForm1.FormCreate(Sender: TObject);
    var
      i, j: integer;
      s: string;
      c: set of char;
    begin
      c := ['А'..'Я', 'а'..'я'];
      memo1.Lines.LoadFromFile('c:\11.txt');
      for i:=0 to memo1.Lines.Count do
      begin
        s:=memo1.Lines.Strings[i];
        for j:=1 to length(s) do
          if chr(ord(S[j])+64) in c then
            s[j]:=chr(ord(S[j])+64);
        memo1.Lines.Strings[i]:=s;
      end;
    end;


------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Один из вариантов кодировщика слегка громоздкий, но работает быстро,
изменяя таблицу можно отключить пропуск непечатаемых символов

    const
      ConvertSet: array[0..255] of byte =
      {таблица перекодировки ASCII с альтернативной кодовой страницой 866 в
      WIN 1251. Украинские символы - по кодовой таблице PRINTFXU. Непечатные
      символы заменяются пробелами}
      {основная таблица}
      { 00 01 02 03 04 05 06 07 08 09 0A 0B 0C 0D 0E 0F }
      {00} ( 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32,
      {10} 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32,
      {20} 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47,
      {30} 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63,
      {40} 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79,
      {50} 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95,
      {60} 96, 97, 98, 99,100,101,102,103,104,105,106,107,108,109,110,111,
      {70} 112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,
      {дополнительная таблица}
      {80} 192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,
      {90} 208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,
      {A0} 224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,
      {B0} 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32,
      {C0} 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32,
      {B0} 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32,
      {E0} 240,241,242,243,244,245,246,247,248,249,250,251,252,253,254,255,
      {F0} 168,184,178,179, 32, 32,175,191,170,186, 32,177,185, 32, 32, 32);
     
    var
      TextString : string[250];
      TextTmpArr : array[0..250] of byte absolute TextString;
      WinString : string[250];
      WinTmpArr : array[0..250] of byte absolute WinString;
     
      DosFile : Text;
      TextFName : string;
      TextFDir : string;
      WinFName : string;
     
    procedure TMainFm.ConvertFile;
    var
      I: Integer;
    begin
      AssignFile(DosFile,TextFName);
      ReSet(DosFile);
      while not(EOF(DosFile)) do
      begin
        ReadLn(DosFile,TextString);
        WinTmpArr[0] := TextTmpArr[0];
        for I := 1 to TextTmpArr[0] do
          WinTmpArr[I] := ConvertSet[TextTmpArr[I]];
        Memo.Lines.Add(WinString);
      end;
    end;


------------------------------------------------------------------------

Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
     
    function ConvertAnsiToOem(const S: string): string;
    { ConvertAnsiToOem translates a string into the OEM-defined character set }
    {$IFNDEF WIN32}
    var
      Source, Dest : array[0..255] of Char;
    {$ENDIF}
    begin
      {$IFDEF WIN32}
      SetLength(Result, Length(S));
      if Length(Result) > 0 then
        AnsiToOem(PChar(S), PChar(Result));
      {$ELSE}
      if Length(Result) > 0 then
      begin
        AnsiToOem(StrPCopy(Source, S), Dest);
        Result := StrPas(Dest);
      end;
      {$ENDIF}
    end; { ConvertAnsiToOem }
     
    function ConvertOemToAnsi(const S: string): string;
    { ConvertOemToAnsi translates a string from the OEM-defined
    character set into either an ANSI or a wide-character string }
    {$IFNDEF WIN32}
    var
      Source, Dest : array[0..255] of Char;
    {$ENDIF}
    begin
      {$IFDEF WIN32}
      SetLength(Result, Length(S));
      if Length(Result) > 0 then
        OemToAnsi(PChar(S), PChar(Result));
      {$ELSE}
      if Length(Result) > 0 then
      begin
        OemToAnsi(StrPCopy(Source, S), Dest);
        Result := StrPas(Dest);
      end;
      {$ENDIF}
    end; { ConvertOemToAnsi }

