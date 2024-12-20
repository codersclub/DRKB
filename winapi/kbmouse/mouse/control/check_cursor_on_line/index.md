---
Title: Проверить, находится ли курсор на линии
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Проверить, находится ли курсор на линии
=======================================

    { 
      Check if a Point(X,Y) (e.g a Cursor) is on a Linie (x1,y1) ; (x2,y2) 
      d = line width (min. 1) 
    }
     
    function CursorOnLinie(X, Y, x1, y1, x2, y2, d: Integer): Boolean;
    var
      sine, cosinus: Double;
      dx, dy, len: Integer;
    begin
      if d = 0 then d := 1;
      asm
        fild(y2)
        fisub(y1) // Y-Difference 
        fild(x2)
        fisub(x1) // X-Difference 
        fpatan    // Angle of the line in st(0) 
        fsincos   // Cosinus in st(0), Sinus in st(1) 
        fstp cosinus
        fstp sine
      end;
      dx  := Round(cosinus * (x - x1) + sine * (y - y1));
      dy  := Round(cosinus * (y - y1) - sine * (x - x1));
      len := Round(cosinus * (x2 - x1) + sine * (y2 - y1)); // length of line 
      if (dy > -d) and (dy < d) and (dx > -d) and (dx < len + d) then Result := True
      else
        Result := False;
    end;
     
    procedure TForm1.FormPaint(Sender: TObject);
    begin
      Canvas.Pen.Width := 1;
      Canvas.MoveTo(0, 0);
      Canvas.LineTo(Width, Weight);
    end;
    
    procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
    var
      p: TPoint;
    begin
      GetCursorPos(p);
      p := ScreenToClient(p);
      if CursorOnLinie(p.x, p.y, 0, 0, Width, Height, 1) then
        Caption := 'Mouse on line.'
      else
        Caption := 'Mouse not on line.'
    end;

