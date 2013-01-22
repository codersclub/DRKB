---
Title: Hex -> Char
Date: 01.01.2007
---


Hex -> Char
===========

::: {.date}
01.01.2007
:::

    var
      Str: Char;
    begin
      Str := 'В';
      Form1.Caption := Format('%x', [Ord(Str)]);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
