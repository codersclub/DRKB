---
Title: Добавление строк в Memo
Date: 01.01.2007
---


Добавление строк в Memo
=======================

::: {.date}
01.01.2007
:::

    Memo1.Perform( WM_SETREDRAW, 0, 0 );
    // ... здесь можно добавлять строки
    Memo1.Perform( WM_SETREDRAW, 1, 0 );
    Memo1.Refresh;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
