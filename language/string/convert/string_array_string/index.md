---
Title: Преобразование из строки в массив и наоборот
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Преобразование из строки в массив и наоборот
=============================

    function StrToArrays(str, r: string; out Temp: TStrings): Boolean;
    var
      j: integer;
    begin
      if temp <> nil then
      begin
        temp.Clear;
        while str <> '' do
        begin
          j := Pos(r,str);
          if j=0 then
            j := Length(str) + 1;
          temp.Add(Copy(Str,1,j-1));
          Delete(Str,1,j+length(r)-1);
        end;
        Result:=True;
      end
      else
        Result:=False;
    end;
     
    {----------------------------------------------------}

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

