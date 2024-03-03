---
Title: Фильтр посредством логического поля
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Фильтр посредством логического поля
===================================

>В таблице имеется поле Customer:Boolean.
>Я хочу чтобы таблица показывала
>только Customer или только не-customer.

Установите ключ (вы должны иметь индекс для этого поля) одним из
указанных способов:

    tablex.SetRange([False],[False])  // для всех не-customer...
    tablex.SetRange([True], [True]])  // для всех customer...
    tablex.SetRange([False],[True])   // для всех записей...

