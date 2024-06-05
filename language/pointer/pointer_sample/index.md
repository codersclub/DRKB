---
Title: Пример работы с указателями
Author: Baa
Source: Vingrad.ru <https://forum.vingrad.ru>
Date: 01.01.2007
---


Пример работы с указателями
===========================

    var
      p1 : ^String;
      s1 : String;
    begin
      s1 := 'NotTest';
      new (p1);
      p1 := @s1;
      p1^ := 'Test';
      Label1.Caption := s1


 
