---
Title: Кнопка в TMainMenu с правой стороны
Author: Smike
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Кнопка в TMainMenu с правой стороны
===================================

    ModifyMenu(MainMenu.Handle, 3 { индекс меню, начиная слева с нуля}, 
        mf_ByPosition or mf_Popup or mf_Help, mnuHelp.Handle, 
        PChar('Help'));

