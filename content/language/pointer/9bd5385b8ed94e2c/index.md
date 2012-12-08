---
Title: Пример работы с указателями
Author: Baa
Date: 01.01.2007
---


Пример работы с указателями
===========================

::: {.date}
01.01.2007
:::


    var
      p1 : ^String;
      s1 : String;
    begin
      s1 := 'NotTest';
      new (p1);
      p1 := @s1;
      p1^ := 'Test';
      Label1.Caption := s1

 

 

Автор: Baa

Взято с Vingrad.ru <https://forum.vingrad.ru>

 
