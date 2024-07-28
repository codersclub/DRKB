---
Title: Подсчет слов в TRichEdit
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Подсчет слов в TRichEdit
========================

    function GetWord: boolean;
    var
      s: string; {предположим что слова не содержат>255 символов}
      c: char;
    begin
      result := false;
      s := ' ';
      while not eof(f) do
      begin
        read(f, c);
        if not (c in ['a'..'z', 'A'..'Z' {,... и т.д, и т.п.}]) then
          break;
        s := s + c;
      end;
      result := (s <> ' ');
    end;
     
    procedure GetWordCount(TextFile: string);
    begin
      Count := 0;
      assignfile(f, TextFile);
      reset(f);
      while not eof(f) do
        if GetWord then
          inc(Count);
      closefile(f);
    end;

