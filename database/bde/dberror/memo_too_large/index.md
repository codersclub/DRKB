---
Title: Memo too large
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Memo too large
==============

В BDE есть крутая ошибка, достаточно известная всем, кроме Borland'a.
Поскольку они ее еще с 1й Delphi не исправили.

Этот баг проявляется как
Access Violation в программе при обращении к таблице IB, которая
содержит более одного поля типа VARCHAR (или CHAR) размером \> 255.
Причем, первое поле меньшего, а второе большего размера.

Если поменять местами поля или сделать их одного размера, то все нормально.

Эффект имеет место только с IB, вроде.

