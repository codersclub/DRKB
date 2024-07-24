---
Title: Как поместить курсор мышки в нужное место на форме?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как поместить курсор мышки в нужное место на форме?
===================================================

    uses 
      Windows; 
     
    procedure PlaceMyMouse(Sender: TForm; X, Y: word); 
    var 
      MyPoint: TPoint; 
    begin 
      MyPoint := Sender.ClientToScreen(Point(X, Y)); 
      SetCursorPos(MyPoint.X, MyPoint.Y); 
    end;

