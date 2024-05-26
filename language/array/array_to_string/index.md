---
Title: Array -> String
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Array -> String
===============

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

 
