---
Title: Замена подстрок
Author: Сергей Шамайтис
Date: 01.01.2007
---


Замена подстрок
===============

::: {.date}
01.01.2007
:::

Автор: Сергей Шамайтис

    function ReplaceSub(str, sub1, sub2: string): string;
    var
      aPos: Integer;
      rslt: string;
    begin
      aPos := Pos(sub1, str);
      rslt := '';
      while (aPos <> 0) do
      begin
        rslt := rslt + Copy(str, 1, aPos - 1) + sub2;
        Delete(str, 1, aPos + Length(sub1) - 1);
        aPos := Pos(sub1, str);
      end;
      Result := rslt + str;
    end; 

 

------------------------------------------------------------------------

    function ReplaceStr(const S, Srch, Replace: string): string;
    {замена подстроки в строке}
    var
      I: Integer;
      Source: string;
    begin
      Source := S;
      Result := '';
      repeat
        I := Pos(Srch, Source);
        if I &gt;
        0 then
        begin
          Result := Result + Copy(Source, 1, I - 1) + Replace;
          Source := Copy(Source, I + Length(Srch), MaxInt);
        end
        else
          Result := Result + Source;
      until I&lt;
      = 0;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 

 

------------------------------------------------------------------------

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Замена в строке всех вхождений одной подстроки, на другую
     
    Зависимости: -
    Автор:       Евгений Валяев (RhinoFC), rhinofc@sniiggims.ru, ICQ:55263922, Новосибирск
    Copyright:   RhinoFC
    Дата:        5 июня 2002 г.
    ***************************************************** }
     
    function StrReplace(const Str, Str1, Str2: string): string;
    // str - исходная строка
    // str1 - подстрока, подлежащая замене
    // str2 - заменяющая строка
    var
      P, L: Integer;
    begin
      Result := str;
      L := Length(Str1);
      repeat
        P := Pos(Str1, Result); // ищем подстроку
        if P > 0 then
        begin
          Delete(Result, P, L); // удаляем ее
          Insert(Str2, Result, P); // вставляем новую
        end;
      until P = 0;
    end;
     

 

------------------------------------------------------------------------

А стандартная функция StringReplace чем не устраивает?

Автор: Vit
