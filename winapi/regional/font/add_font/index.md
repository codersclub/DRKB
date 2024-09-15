---
Title: Как использовать неустановленный шрифт?
Author: Alex101
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---

Как использовать неустановленный шрифт?
=======================================

Зарегистрировать шрифт:

    AddFontResource('путь к фонту\Algerian.ttf');
    
    Объект.Font.Name:="Algerian";

Удалить шрифт:

    RemoveFontResource('путь к фонту\Algerian.ttf');
