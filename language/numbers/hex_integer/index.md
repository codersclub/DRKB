---
Title: Hex -> Integer
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---


Hex -> Integer
==============

Вариант 1:

    var
      i: integer
      s: string;
    begin
      s := '$' + ThatHexString;
      i := StrToInt(a);
    end;

------------------------------------------------------------------------

Вариант 2:

    const HEX: array['A'..'F'] of INTEGER = (10, 11, 12, 13, 14, 15);
    var str: string;
        Int, i: integer;
    begin
      READLN(str);
      Int := 0;
      for i := 1 to Length(str) do
        if str[i] < 'A' then
          Int := Int * 16 + ORD(str[i]) - 48
        else
          Int := Int * 16 + HEX[str[i]];
      WRITELN(Int);
      READLN;
    end.

