---
Title: Вращать изображение вокруг точки
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Вращать изображение вокруг точки
================================

    // Vector from FromP to ToP 
     
    function TForm1.Vektor(FromP, Top: TPoint): TPoint;
    begin
      Result.x := Top.x - FromP.x;
      Result.y := Top.y - FromP.y;
    end;
     
    // neue x Komponente des Verktors 
    // new x-component of the vector 
    function TForm1.xComp(Vektor: TPoint; Angle: Extended): Integer;
    begin
      Result := Round(Vektor.x * cos(Angle) - (Vektor.y) * sin(Angle));
    end;
     
    // neue Y-Komponente des Vektors 
    // new y-component of the vector 
    function TForm1.yComp(Vektor: TPoint; Angle: Extended): Integer;
    begin
      Result := Round((Vektor.x) * (sin(Angle)) + (vektor.y) * cos(Angle));
    end;
     
     
    function TForm1.RotImage(srcbit: TBitmap; Angle: Extended; FPoint: TPoint;
       Background: TColor): TBitmap;
    { 
    srcbit: TBitmap; // Bitmap dass gedreht werden soll ; Bitmap to be rotated 
    Angle: extended; // Winkel in Bogenma?, angle 
    FPoint: TPoint;  // Punkt um den gedreht wird ; Point to be rotated around 
    Background: TColor): TBitmap;  // Hintergrundfarbe des neuen Bitmaps ; 
                                   // Backgroundcolor of the new bitmap 
    }
    var
      highest, lowest, mostleft, mostright: TPoint;
      topoverh, leftoverh: integer;
      x, y, newx, newy: integer;
    begin
      Result := TBitmap.Create;
    
      // Drehwinkel runterrechnen auf eine Umdrehung, wenn notig 
      // Calculate angle down on one rotation, if necessary 
      while Angle >= (2 * pi) do
       begin
         angle := Angle - (2 * pi);
       end;
     
      // neue Ausma?e festlegen 
      // specify new size 
      if (angle <= (pi / 2)) then
       begin
        highest := Point(0,0);                        //OL 
        Lowest := Point(Srcbit.Width, Srcbit.Height); //UR 
        mostleft := Point(0,Srcbit.Height);           //UL 
        mostright := Point(Srcbit.Width, 0);          //OR 
       end
      else if (angle <= pi) then
       begin
         highest := Point(0,Srcbit.Height);
         Lowest := Point(Srcbit.Width, 0);
         mostleft := Point(Srcbit.Width, Srcbit.Height);
         mostright := Point(0,0);
       end
      else if (Angle <= (pi * 3 / 2)) then
       begin
         highest := Point(Srcbit.Width, Srcbit.Height);
         Lowest := Point(0,0);
         mostleft := Point(Srcbit.Width, 0);
         mostright := Point(0,Srcbit.Height);
       end
      else
       begin
         highest := Point(Srcbit.Width, 0);
         Lowest := Point(0,Srcbit.Height);
         mostleft := Point(0,0);
         mostright := Point(Srcbit.Width, Srcbit.Height);
       end;
     
      topoverh := yComp(Vektor(FPoint, highest), Angle);
      leftoverh := xComp(Vektor(FPoint, mostleft), Angle);
      Result.Height := Abs(yComp(Vektor(FPoint, lowest), Angle)) + Abs(topOverh);
      Result.Width  := Abs(xComp(Vektor(FPoint, mostright), Angle)) + Abs(leftoverh);
    
      // Verschiebung des FPoint im neuen Bild gegenuber srcbit 
      // change of FPoint in the new picture in relation on srcbit 
      Topoverh := TopOverh + FPoint.y;
      Leftoverh := LeftOverh + FPoint.x;
     
      // erstmal mit Hintergrundfarbe fullen 
      // at first fill with background color 
      Result.Canvas.Brush.Color := Background;
      Result.Canvas.pen.Color   := background;
      Result.Canvas.Fillrect(Rect(0,0,Result.Width, Result.Height));
     
      // Start des eigentlichen Rotierens 
      // Start of actual rotation 
      for y := 0 to srcbit.Height - 1 do
       begin                       // Zeilen  ; Rows 
        for x := 0 to srcbit.Width - 1 do
         begin                    // Spalten ; Columns 
          newX := xComp(Vektor(FPoint, Point(x, y)), Angle);
           newY := yComp(Vektor(FPoint, Point(x, y)), Angle);
           newX := FPoint.x + newx - leftoverh;
           // Verschieben wegen der neuen Ausma?e 
           newy := FPoint.y + newy - topoverh;
           // Move beacause of new size 
           Result.Canvas.Pixels[newx, newy] := srcbit.Canvas.Pixels[x, y];
           // auch das Pixel daneben fullen um Leerpixel bei Drehungen zu verhindern 
           // also fil lthe pixel beside to prevent empty pixels 
           if ((angle < (pi / 2)) or
             ((angle > pi) and
             (angle < (pi * 3 / 2)))) then
            begin
             Result.Canvas.Pixels[newx, newy + 1] := srcbit.Canvas.Pixels[x, y];
            end
           else
            begin
             Result.Canvas.Pixels[newx + 1,newy] := srcbit.Canvas.Pixels[x, y];
            end;
         end;
       end;
     end;
     
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       mybitmap, newbit: TBitMap;
     begin
       if OpenDialog1.Execute then
       begin
         mybitmap := TBitmap.Create;
         mybitmap.LoadFromFile(OpenDialog1.FileName);
         newbit := RotImage(mybitmap, DegToRad(45),
           Point(mybitmap.Width div 2, mybitmap.Height div 2), clBlack);
         Image1.Canvas.Draw(0,0, newBit);
       end;
     end;
     
     end;

