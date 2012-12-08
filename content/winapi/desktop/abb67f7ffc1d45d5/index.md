---
Title: Получить цвет пикселя на рабочем столе
Date: 01.01.2007
---


Получить цвет пикселя на рабочем столе
======================================

::: {.date}
01.01.2007
:::

    function DesktopColor(const X, Y: Integer): TColor;
     var
       c: TCanvas;
     begin
       c := TCanvas.Create;
       try
         c.Handle := GetWindowDC(GetDesktopWindow);
         Result   := GetPixel(c.Handle, X, Y);
       finally
         c.Free;
       end;
     end;
     
     procedure TForm1.Timer1Timer(Sender: TObject);
     var
       Pos: TPoint;
     begin
       GetCursorPos(Pos);
       Panel1.Color := DesktopColor(Pos.X, Pos.Y);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
