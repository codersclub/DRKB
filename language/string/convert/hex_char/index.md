---
Title: Hex -> Char
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Hex -> Char
===========

    var
      Str: Char;
    begin
      Str := 'В';
      Form1.Caption := Format('%x', [Ord(Str)]);
    end;



 
