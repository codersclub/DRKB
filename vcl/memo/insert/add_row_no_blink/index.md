---
Title: Добавление строк в Memo без мерцания
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Добавление строк в Memo без мерцания
=======================

    Memo1.Perform( WM_SETREDRAW, 0, 0 );
    // ... здесь можно добавлять строки
    Memo1.Perform( WM_SETREDRAW, 1, 0 );
    Memo1.Refresh;

