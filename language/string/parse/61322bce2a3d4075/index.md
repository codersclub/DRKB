---
Title: Количество вхождений подстроки в строку
Author: \_\_\_Nikolay
Date: 01.01.2007
---


Количество вхождений подстроки в строку
=======================================

::: {.date}
01.01.2007
:::

    function CountPos(const subtext: string; Text: string): Integer;
    begin
      if (Length(subtext) = 0) or (Length(Text) = 0) or (Pos(subtext, Text) = 0) then
        Result := 0
      else
        Result := (Length(Text) - Length(StringReplace(Text, subtext, '', [rfReplaceAll]))) div
          Length(subtext);
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Подсчёт количества вхождений символа в строке
     
    Функцийка считает количество повторений
    символа заданного InputSubStr в строке InputStr.
     
    Зависимости: Стандартные модули
    Автор:       Ru, DiVo_Ru@rambler.ru, Одесса (Украина)
    Copyright:   DiVo 2003 creator Ru
    Дата:        18 ноября 2003 г.
    ***************************************************** }
     
    function CntChRepet(InputStr: string; InputSubStr: char): integer;
    var
      i: integer;
    begin
      result := 0;
      for i := 1 to length(InputStr) do
        if InputStr[i] = InputSubStr then
          inc(result);
    end;

------------------------------------------------------------------------

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Подсчитать количество вхождений подстроки в строке
     
    Понадобилось подсчитать количество вхождений подстроки в строку,
    вот и появилась эта функция. Возможно в ней и нет изюминки,
    но может кому и пригодится.
     
    Зависимости: System
    Автор:       Дмитрий, bestonix@mail.ru, ICQ:155133146, Тольятти
    Copyright:   Дмитрий
    Дата:        17 октября 2002 г.
    ***************************************************** }
     
    function CntRecurrences(substr, str: string): integer;
    var
      cnt, p: integer;
    begin
      cnt := 0;
      while str <> '' do
      begin
        p := Pos(substr, str);
        if p > 0 then
          inc(cnt)
        else
          p := 1;
        Delete(str, 1, (p + Length(substr) - 1));
      end;
      Result := cnt;
    end;

------------------------------------------------------------------------

Автор: \_\_\_Nikolay

    // Кол-во вхождений символа в строку
    function SymbolEntersCount(s: string; ch: char): integer;
    var
      i: integer;
    begin
      Result := 0;
      if Trim(s) <> '' then
        for i := 1 to Length(s) do
          if s[i] = ch then
            inc(Result);
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
