---
Title: Получить цвет пикселя на рабочем столе
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Получить цвет пикселя на рабочем столе
======================================

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

