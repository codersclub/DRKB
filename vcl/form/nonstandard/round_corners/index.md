---
Title: Создание форм с закругленными краями
Author: winsoft
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Создание форм с закругленными краями
====================================

    { 
      Die CreateRoundRectRgn lasst eine Form mit abgerundeten Ecken erscheinen. 
     
      The CreateRoundRectRgn function creates a rectangular 
      region with rounded corners 
    }
     
     procedure TForm1.FormCreate(Sender: TObject);
     var
       rgn: HRGN;
     begin
       Form1.Borderstyle := bsNone;
       rgn := CreateRoundRectRgn(0,// x-coordinate of the region's upper-left corner 
        0,            // y-coordinate of the region's upper-left corner 
        ClientWidth,  // x-coordinate of the region's lower-right corner 
        ClientHeight, // y-coordinate of the region's lower-right corner 
        40,           // height of ellipse for rounded corners 
        40);          // width of ellipse for rounded corners 
      SetWindowRgn(Handle, rgn, True);
     end
     
     
     { The CreatePolygonRgn function creates a polygonal region. }
     
     procedure TForm1.FormCreate(Sender: TObject);
     const
       C = 20;
     var
       Points: array [0..7] of TPoint;
       h, w: Integer;
     begin
       h := Form1.Height;
       w := Form1.Width;
       Points[0].X := C;     Points[0].Y := 0;
       Points[1].X := 0;     Points[1].Y := C;
       Points[2].X := 0;     Points[2].Y := h - c;
       Points[3].X := C;     Points[3].Y := h;
     
       Points[4].X := w - c; Points[4].Y := h;
       Points[5].X := w;     Points[5].Y := h - c;
     
       Points[6].X := w;     Points[6].Y := C;
       Points[7].X := w - C; Points[7].Y := 0;
     
       SetWindowRgn(Form1.Handle, CreatePolygonRgn(Points, 8, WINDING), True);
     end;

