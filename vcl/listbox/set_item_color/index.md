---
Title: Как в TListBox нарисовать Item своим цветом?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как в TListBox нарисовать Item своим цветом?
============================================

    procedure TForm1.ListBox1DrawItem(Control: TWinControl; Index: Integer; 
    Rect: TRect; State: TOwnerDrawState); 
    begin 
      With ListBox1 do 
      begin 
        If odSelected in State then 
          Canvas.Brush.Color:=clTeal { твой цвет } 
        else 
          Canvas.Brush.Color:=clWindow; 
        Canvas.FillRect(Rect); 
        Canvas.TextOut(Rect.Left+2,Rect.Top,Items[Index]); 
      end; 
    end; 

Hе забудьте установить свойство Style у своего ListBox в
`lbOwnerDrawFixed` или в `lbOwnerDrawVariable`.

