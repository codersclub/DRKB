---
Title: Конвертация арабских цифр в римские
Date: 01.01.2007
Source: <https://www.lmc-mediaagentur.de/dpool>
---


Конвертация арабских цифр в римские
===================================

    function IntToRoman(num: Cardinal): String;  {returns num in capital roman digits}
    const
      Nvals = 13;
      vals: array [1..Nvals] of word = (1, 4, 5, 9, 10, 40, 50, 90, 100, 400, 500, 900, 1000);
      roms: array [1..Nvals] of string[2] = ('I', 'IV', 'V', 'IX', 'X', 'XL', 'L', 'XC', 'C', 'CD', 'D', 'CM', 'M');
    var
      b: 1..Nvals;
    begin
      result := '';
      b := Nvals;
      while num > 0 do
      begin
        while vals[b] > num do
          dec(b);
        dec (num, vals[b]);
        result := result + roms[b]
      end;
    end;

