---
Title: Как подсчитать количество слов в строке?
Date: 01.01.2007
---


Как подсчитать количество слов в строке?
========================================

::: {.date}
01.01.2007
:::

    function Seps(As_Arg: Char): Boolean; 
    begin 
      Seps := As_Arg in 
        [#0..#$1F, ' ', '.', ',', '?', ':', ';', '(', ')', '/', '\']; 
    end; 
     
    function WordCount(CText: string): Longint; 
    var 
      Ix: Word; 
      Work_Count: Longint; 
    begin 
      Work_Count := 0; 
      Ix         := 1; 
      while Ix <= Length(CText) do 
      begin 
        while (Ix <= Length(CText)) and (Seps(CText[Ix])) do 
          Inc(Ix); 
        if Ix <= Length(CText) then 
        begin 
          Inc(Work_Count); 
     
          while (Ix <= Length(CText)) and (not Seps(CText[Ix])) do 
            Inc(Ix); 
        end; 
      end; 
      Word_Count := Work_Count; 
    end; 
     
    { 
      To count the number opf words in a TMemo Component, 
      call: WordCount(Memo1.Text) 
    }

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Подсчет количества слов в строке.
     
    Возвращает количество слов в строке, границы слов определяются в
    соответствие с набором разделителей.
     
    Описание параметров:
    s - строка, в которой происходит подсчет слов;
     
    Delimiters множество, содержащее символы-разделители слов;
     
    Возвращаемое значение - количество слов
     
    Зависимости: SysUtils, UBPFD.WordScan
    Автор:       vuk, vuk@fcenter.ru
    Copyright:   Алексей Вуколов
    Дата:        18 апреля 2002 г.
    ***************************************************** }
     
    function CountWords(const s: string; Delimiters: TSysCharSet): integer;
    var
      wStart, wLen: integer;
    begin
      Result := 0;
      wStart := 1;
      while WordScan(s, wStart, wLen, Delimiters) do
      begin
        inc(Result);
        inc(wStart, wLen);
      end;
    end;
    //Пример использования: 
     
    WordCount := CountWords('This is a sample', [' ']);
