---
Title: Изменение регистра букв
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---

Изменение регистра букв
=======================

В Delphi есть три функции для изменения регистра: upcase, lowercase,
uppercase. Но они работают только для латинского алфавита.

Чтобы сделать аналогичные функции для русского алфавита я
использовал то, что в кодировке Windows-1251 буквы расставлены по
алфавиту, как большие, так и маленькие.

То есть номер большой буквы связан с номером маленькой константой.
И в русском, и в английском алфавитах маленькие буквы находятся
за большими с разностью в 32 символа.

Здесь реализованы четыре функции: upcase и locase для
изменения регистра одного символа, и uppercase и lowercase для изменения
регистра строки

    function UpCase(ch: char): char;
    begin
      if (ch in ['a'..'z', 'а'..'я'])
        then result := chr(ord(ch) - 32)
        else result := ch;
    end;
     
    function LoCase(ch: char): char;
    begin
      if (ch in ['A'..'Z', 'А'..'Я'])
        then result := chr(ord(ch) + 32)
        else result := ch;
    end;
     
    function UpperCase(s: string): string;
    var
      i: integer;
    begin
      result := s;
      for i := 1 to length(result) do
        if (result[i] in ['a'..'z', 'а'..'я'])
          then result[i] := chr(ord(result[i]) - 32);
    end;
     
    function LowerCase(s: string): string;
    var
      i: integer;
    begin
      result := s;
      for i := 1 to length(result) do
        if (result[i] in ['A'..'Z', 'А'..'Я'])
          then result[i] := chr(ord(result[i]) + 32);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    const
      s = 'zZцЦ.';
    var
      i: integer;
    begin
      Form1.Caption := 'DownCase: ';
      for i := 1 to Length(s) do
        Form1.Caption := Form1.Caption + LoCase(s[i]);
      Form1.Caption := Form1.Caption + ' UpCase: ';
      for i := 1 to Length(s) do
        Form1.Caption := Form1.Caption + UpCase(s[i]);
      Form1.Caption := Form1.Caption + ' UpperCase: ' +
        UpperCase(s);
      Form1.Caption := Form1.Caption + ' LowerCase: ' +
        LowerCase(s);
    end;

