---
Title: Градиентная заливка
Date: 01.01.2007
---


Градиентная заливка
===================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Иногда бывает нужно сложить два или более цветов для получения что-то
типа переходного цвета. Делается это весьма просто. Координаты
получаемого цвета будут равны среднему значению соответствующих
координат всех цветов.

Например, нужно сложить красный и синий. Получаем

    (255,0,0)+(0,0,255)=((255+0) div 2,(0+0) div 2,(0+255) div 2)=(127,0,127).

В результате получаем сиреневый цвет. Также надо поступать, если цветов
более чем 2: сложить соответствующие координаты, потом каждую сумму
разделить нацело на количество цветов.

Поговорим теперь о градиентной заливке. Градиентная заливка - это
заливка цветом с плавным переходом от одного цвета к другому.

Итак, пусть заданы 2 цвета своими координатами ((A1, A2, A3) и (B1, B2,
B3)) и линия (длиной h пикселов), по которой нужно залить. Тогда каждый
цвет каждого пиксела, находящегося на расстоянии x пикселов от начала
будет равен

    (A1-(A1-B1)/h*x, A2-(A2-B2)/h*x, A3-(A3-B3)/h*x).

Теперь,
имея линию с градиентной заливкой, можно таким образом залить совершенно
любую фигуру: будь то прямоугольник, круг или просто произвольная
фигура.

Вот как выглядит описанный алгоритм:

    {Считается, что координаты первого цвета
    равны (A1, A2, A3), а второго (B1, B2, B3)
    Кроме того, линия начинается в координатах
    (X1,Y1), а заканчивается в (X2,Y1)}
     
    var
      h, i: integer;
    begin
      h:=X2-X1-1;
      for i:=0 to h do
        with PaintBox1.Canvas do
        begin
          Pen.Color:=RGB(A1-(A1-B1)/h*i, A2-(A2-B2)/h*i, A3-(A3-B3)/h*i);
          Rectangle(I,Y1,I+1,Y1);
        end;
    end.

------------------------------------------------------------------------

Вариант 2:

    { 
      The following code allows you to draw a gradient on a canvas with 
      an arbitrary number of colors (minimum 2). 
      To draw a gradient on a form's canvas, 
      call the DrawGradient() in the OnPaint and OnResize-event handlers. 
    }
     
    { 
      Mit dieser Prozedur kann man auf einen Canvas einen Farbverlauf mit 
      beliebig vielen Farben (min. 2) zeichnen. 
      Z.B. wenn auf eine Form ein Farbverlauf gezeichnet werden soll, 
      rufe die DrawGradient() Funktion im OnPaint-Ereignis und 
      im OnResize-Ereignis der Form auf. 
    }
     
    procedure DrawGradient(ACanvas: TCanvas; Rect: TRect;
      Horicontal: Boolean; Colors: array of TColor);
    type
      RGBArray = array[0..2] of Byte;
    var
      x, y, z, stelle, mx, bis, faColorsh, mass: Integer;
      Faktor: double;
      A: RGBArray;
      B: array of RGBArray;
      merkw: integer;
      merks: TPenStyle;
      merkp: TColor;
    begin
      mx := High(Colors);
      if mx > 0 then
      begin
        if Horicontal then
          mass := Rect.Right - Rect.Left
        else
          mass := Rect.Bottom - Rect.Top;
        SetLength(b, mx + 1);
        for x := 0 to mx do
        begin
          Colors[x] := ColorToRGB(Colors[x]);
          b[x][0] := GetRValue(Colors[x]);
          b[x][1] := GetGValue(Colors[x]);
          b[x][2] := GetBValue(Colors[x]);
        end;
        merkw := ACanvas.Pen.Width;
        merks := ACanvas.Pen.Style;
        merkp := ACanvas.Pen.Color;
        ACanvas.Pen.Width := 1;
        ACanvas.Pen.Style := psSolid;
        faColorsh := Round(mass / mx);
        for y := 0 to mx - 1 do
        begin
          if y = mx - 1 then
            bis := mass - y * faColorsh - 1
          else
            bis := faColorsh;
          for x := 0 to bis do
          begin
            Stelle := x + y * faColorsh;
            faktor := x / bis;
            for z := 0 to 3 do
              a[z] := Trunc(b[y][z] + ((b[y + 1][z] - b[y][z]) * Faktor));
            ACanvas.Pen.Color := RGB(a[0], a[1], a[2]);
            if Horicontal then
            begin
              ACanvas.MoveTo(Rect.Left + Stelle, Rect.Top);
              ACanvas.LineTo(Rect.Left + Stelle, Rect.Bottom);
            end
            else
            begin
              ACanvas.MoveTo(Rect.Left, Rect.Top + Stelle);
              ACanvas.LineTo(Rect.Right, Rect.Top + Stelle);
            end;
          end;
        end;
        b := nil;
        ACanvas.Pen.Width := merkw;
        ACanvas.Pen.Style := merks;
        ACanvas.Pen.Color := merkp;
      end
      else
        // Please specify at least two colors 
       raise EMathError.Create('Es mussen mindestens zwei Farben angegeben werden.');
    end;
     
    // Example Calls: 
    // Aufrufbeispiele: 
     
    DrawGradient(Image1.Canvas, Rect(0, 0, 100, 200), False, [clRed, $00FFA9B4]);
     
    DrawGradient(Canvas, GetClientRect, True, [121351, clBtnFace, clBlack, clWhite]);

------------------------------------------------------------------------

Вариант 3:

Source: <https://www.swissdelphicenter.ch>

    procedure FillGradientRect(Canvas: TCanvas; Recty: TRect; fbcolor, fecolor: TColor; fcolors: Integer);
     var
       i, j, h, w, fcolor: Integer;
       R, G, B: Longword;
       beginRGBvalue, RGBdifference: array[0..2] of Longword;
     begin
       beginRGBvalue[0] := GetRvalue(colortoRGB(FBcolor));
       beginRGBvalue[1] := GetGvalue(colortoRGB(FBcolor));
       beginRGBvalue[2] := GetBvalue(colortoRGB(FBcolor));
     
       RGBdifference[0] := GetRvalue(colortoRGB(FEcolor)) - beginRGBvalue[0];
       RGBdifference[1] := GetGvalue(colortoRGB(FEcolor)) - beginRGBvalue[1];
       RGBdifference[2] := GetBvalue(colortoRGB(FEcolor)) - beginRGBvalue[2];
     
       Canvas.pen.Style := pssolid;
       Canvas.pen.mode := pmcopy;
       j := 0;
       h := recty.Bottom - recty.Top;
       w := recty.Right - recty.Left;
     
       for i := fcolors downto 0 do
       begin
         recty.Left  := muldiv(i - 1, w, fcolors);
         recty.Right := muldiv(i, w, fcolors);
         if fcolors1 then
         begin
           R := beginRGBvalue[0] + muldiv(j, RGBDifference[0], fcolors);
           G := beginRGBvalue[1] + muldiv(j, RGBDifference[1], fcolors);
           B := beginRGBvalue[2] + muldiv(j, RGBDifference[2], fcolors);
         end;
         Canvas.Brush.Color := RGB(R, G, B);
         patBlt(Canvas.Handle, recty.Left, recty.Top, Recty.Right - recty.Left, h, patcopy);
         Inc(j);
       end;
     end;
     
     // Case 1 
     
    procedure TForm1.FormPaint(Sender: TObject);
     begin
       FillGradientRect(Form1.Canvas, rect(0, 0, Width, Height), $FF0000, $00000, $00FF);
     end;
     
     
     // Case 2 
    procedure TForm1.FormPaint(Sender: TObject);
     var
       Row, Ht: Word;
       IX: Integer;
     begin
       iX := 200;
       Ht := (ClientHeight + 512) div 256;
       for Row := 0 to 512 do
       begin
         with Canvas do
         begin
           Brush.Color := RGB(Ix, 0, row);
           FillRect(Rect(0, Row * Ht, ClientWidth, (Row + 1) * Ht));
           IX := (IX - 1);
         end;
       end;
     end;
     
     
    { 
      Note, that the OnResize event should also call the FormPaint 
      method if this form is allowed to be resizable. 
      This is because if it is not called then when the 
      window is resized the gradient will not match the rest of the form. 
    }



------------------------------------------------------------------------

Вариант 4:

Source: <https://www.swissdelphicenter.ch>

    {***********************************************************}
     
     {2. Another function}
     
     
     procedure TForm1.Gradient(Col1, Col2: TColor; Bmp: TBitmap);
     type
       PixArray = array [1..3] of Byte;
     var
       i, big, rdiv, gdiv, bdiv, h, w: Integer;
       ts: TStringList;
       p: ^PixArray;
     begin
       rdiv := GetRValue(Col1) - GetRValue(Col2);
       gdiv := GetgValue(Col1) - GetgValue(Col2);
       bdiv := GetbValue(Col1) - GetbValue(Col2);
     
       bmp.PixelFormat := pf24Bit;
     
       for h := 0 to bmp.Height - 1 do
       begin
         p := bmp.ScanLine[h];
         for w := 0 to bmp.Width - 1 do
         begin
           p^[1] := GetBvalue(Col1) - Round((w / bmp.Width) * bdiv);
           p^[2] := GetGvalue(Col1) - Round((w / bmp.Width) * gdiv);
           p^[3] := GetRvalue(Col1) - Round((w / bmp.Width) * rdiv);
           Inc(p);
         end;
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       BitMap1: TBitMap;
     begin
       BitMap1 := TBitMap.Create;
       try
         Bitmap1.Width := 300;
         bitmap1.Height := 100;
         Gradient(clred, clBlack, bitmap1);
         // So konnte man das Bild dann zB in einem TImage anzeigen 
         // To show the image in a TImage: 
         Image1.Picture.Bitmap.Assign(bitmap1);
       finally
         Bitmap1.Free;
       end;
     end;

