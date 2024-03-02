---
Title: Обновление вычисляемых полей
Author: OAmiry (Borland)
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Обновление вычисляемых полей
============================

Разместите строчку типа нижеприведенной в конце кода обработчика события
OnCalcFields:

    {предположим, что вы используете DBGrid1}
    if DBGrid1.Showing then
      DBGrid1.Invalidate ;


