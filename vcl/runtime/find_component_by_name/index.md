---
Title: Как найти компонент по имени?
Author: Vit
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как найти компонент по имени?
=============================

Обратиться к компоненту по имени можно например так:
если стоит 10 CheckBox - от CheckBox1 до CheckBox10,
то

    For i:=1 to 10 do
      (FindComponent(Format('CheckBox%d',[i])) as TCheckBox).checked:=true;

