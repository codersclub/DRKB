---
Title: Как поместить курсор мышки в нужное место на форме?
Date: 01.01.2007
---


Как поместить курсор мышки в нужное место на форме?
===================================================

::: {.date}
01.01.2007
:::

    uses 
      Windows; 
     
    procedure PlaceMyMouse(Sender: TForm; X, Y: word); 
    var 
      MyPoint: TPoint; 
    begin 
      MyPoint := Sender.ClientToScreen(Point(X, Y)); 
      SetCursorPos(MyPoint.X, MyPoint.Y); 
    end;

Взято из <https://forum.sources.ru>
