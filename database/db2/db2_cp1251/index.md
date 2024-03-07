---
Title: Как создать БД в кодировке CP1251?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как создать БД в кодировке CP1251?
==================================

Нужно просто в запросе указать правильный codset и territory:

    CREATE DATABASE Efes2
    USING CODESET 1251 TERRITORY RU
    COLLATE USING IDENTITY;

