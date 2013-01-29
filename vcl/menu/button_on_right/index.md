---
Title: Кнопка в TMainMenu с правой стороны
Author: Smike
Date: 01.01.2007
---


Кнопка в TMainMenu с правой стороны
===================================

::: {.date}
01.01.2007
:::


    ModifyMenu(MainMenu.Handle, 3 { индекс меню, начиная слева с нуля}, 
        mf_ByPosition or mf_Popup or mf_Help, mnuHelp.Handle, 
        PChar('Help'));

 \

Автор: Smike

Взято из <https://forum.sources.ru>
