---
Title: Как сделать, чтобы компоненты отбрасывали тень?
Date: 01.01.2007
---


Как сделать, чтобы компоненты отбрасывали тень?
===============================================

::: {.date}
01.01.2007
:::

    procedure ShadeIt(f: TForm; c: TControl; Width: Integer; Color: TColor); 
    var 
      rect: TRect; 
      old: TColor; 
    begin 
      if (c.Visible) then 
      begin 
        rect := c.BoundsRect; 
        rect.Left := rect.Left + Width; 
        rect.Top := rect.Top + Width; 
        rect.Right := rect.Right + Width; 
        rect.Bottom := rect.Bottom + Width; 
        old := f.Canvas.Brush.Color; 
        f.Canvas.Brush.Color := Color; 
        f.Canvas.fillrect(rect); 
        f.Canvas.Brush.Color := old; 
      end; 
    end; 
     
    procedure TForm1.FormPaint(Sender: TObject); 
    var 
      i: Integer; 
    begin 
      for i := 0 to Self.ControlCount - 1 do 
        ShadeIt(Self, Self.Controls[i], 3, clBlack); 
    end;

Взято с <https://delphiworld.narod.ru>
