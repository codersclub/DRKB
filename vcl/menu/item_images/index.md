---
Title: Как сделать пункты меню с картинками?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как сделать пункты меню с картинками?
=====================================

Следующий код показывает, как добавить картинку в виде объекта TImage в
объект TMenuItem.

    var 
       hHandle: THandle; 
       x: integer; 
       // visual controls: 
       hMenu: TMenuItem; 
       Image1: TImage; 
     
    ... 
     
      x:= 10; // десятый пункт меню
      hHandle := GetMenuItemID(hMenu.handle, x); 
      ModifyMenu(hMenu.handle, hHandle, MF_BYCOMMAND Or MF_BITMAP, hHandle, 
                 PChar(Image1.picture.bitmap.handle)) 

