---
Title: Array -> String
Date: 01.01.2007
---


Array -> String
===============

::: {.date}
01.01.2007
:::

    function ArrayToStr(str: TStrings; r: string): string;
    var
      i: integer;
    begin
      Result:='';
      if str = nil then
        Exit;
      for i := 0 to Str.Count-1 do
        Result := Result + Str.Strings[i] + r;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
