---
Title: Обновление вычисляемых полей
Author: OAmiry (Borland)
Date: 01.01.2007
---


Обновление вычисляемых полей
============================

::: {.date}
01.01.2007
:::

Обновление вычисляемых полей



 

Автор: OAmiry (Borland)

Разместите строчку типа нижеприведенной в конце кода обработчика события
OnCalcFields:

    {предположим, что вы используете DBGrid1}
    if DBGrid1.Showing then
      DBGrid1.Invalidate ;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
