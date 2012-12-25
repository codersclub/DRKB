---
Title: Эффект разбрызгивания
Date: 01.01.2007
---


Эффект разбрызгивания
=====================

::: {.date}
01.01.2007
:::

    procedure Spray(Canvas: TCanvas; x, y, r: Integer; Color: TColor);
     var
       rad, a: Single;
       i: Integer;
     begin
       for i := 0 to 100 do
       begin
         a   := Random * 2 * pi;
         rad := Random * r;
         Canvas.Pixels[x + Round(rad * Cos(a)), y + Round(rad * Sin(a))] := Color;
       end;
     end;
     
     procedure TForm1.Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
       Y: Integer);
     begin
       if ssLeft in Shift then Spray(Image1.Canvas, x, y, 40, clRed);
     end;
     
     procedure TForm1.Image1MouseDown(Sender: TObject; Button: TMouseButton;
       Shift: TShiftState; X, Y: Integer);
     begin
       if ssLeft in Shift then Spray(Image1.Canvas, x, y, 40, clRed);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
