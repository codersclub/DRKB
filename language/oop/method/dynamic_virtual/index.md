---
Title: Динамические и виртуальные методы
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
Date: 01.01.2007
---


Динамические и виртуальные методы
=================================

Согласно онлайновой документации, динамические и виртуальные методы
семантически идентичны, единственно различие заключается в их
реализации, нижеследующий код генерирует указанную ошибку компиляции:

    type t = class
        function a: integer; {статический}
        function b: integer; virtual;
        function c: integer; dynamic;
        property i: integer read a; { ok }
        property j: integer read b; { ok }
        property k: integer read c;{ ОШИБКА: type mismatch (не совпадение типа) }
      end;



