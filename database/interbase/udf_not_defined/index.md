---
Title: При попытке регистрации UDF возникает ошибка - udf not defined
Author: Nomadic 
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


При попытке регистрации UDF возникает ошибка - udf not defined
===============================================================

Располагайте DLL в каталоге Interbase/Bin, или в одном из каталогов, в
которых ОС обязательно будет произведен поиск этой библиотеки (для
Windows это %SystemRoot% и %Path%);

При декларировании функции не следует указывать расширение модуля (в
Windows по умолчанию DLL):

    declare external function f_SubStr
    cstring(254), integer, integer
    returns
    cstring(254)
    entry_point "Substr" module_name "UDF1"

Где UDF1 - UDF1.DLL.

