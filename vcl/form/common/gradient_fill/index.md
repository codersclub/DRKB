---
Title: Пример градиентной заливки формы
Date: 01.01.2007
---


Пример градиентной заливки формы
================================

Вариант 1:

Author: Mischka

Иногда бывает нужно сложить два или более цветов для получения что-то
типа переходного цвета. Делается это весьма просто. Координаты
получаемого цвета будут равны среднему значению соответствующих
координат всех цветов.

Например, нужно сложить красный и синий. Получаем

    (255,0,0)+(0,0,255) = ((255+0) div 2, (0+0) div 2, (0+255) div 2) = (127,0,127).

В результате получаем сиреневый цвет. Также надо поступать, если цветов
более чем 2: сложить соответствующие координаты, потом каждую сумму
разделить нацело на количество цветов.

Поговорим теперь о градиентной заливке. Градиентная заливка - это
заливка цветом с плавным переходом от одного цвета к другому.

Итак, пусть заданы 2 цвета своими координатами ((A1, A2, A3) и (B1, B2,
B3)) и линия (длиной h пикселов), по которой нужно залить. Тогда каждый
цвет каждого пиксела, находящегося на расстоянии x пикселов от начала
будет равен (A1-(A1-B1)/h\*x, A2-(A2-B2)/h\*x, A3-(A3-B3)/h\*x).

Теперь, имея линию с градиентной заливкой, можно таким образом залить совершенно
любую фигуру: будь то прямоугольник, круг или просто произвольная
фигура.

Вот как выглядит описанный алгоритм:

     
    {Считается, что координаты первого цвета равны (A1, A2, A3), а второго (B1, B2, B3) 
     Кроме того, линия начинается в координатах (X1,Y1), а заканчивается в (X2,Y1)} 
     
    var h, i: integer; 
    begin 
      h:=X2-X1-1; 
      for i:=0 to h do 
        with PaintBox1.Canvas do 
          begin 
            Pen.Color:=RGB(A1-(A1-B1)/h*i, A2-(A2-B2)/h*i, A3-(A3-B3)/h*i); 
            Rectangle(I,Y1,I+1,Y1); 
          end; 
    end.

-------------------------------------------------

Вариант 2:

Author: Kostas

> feriman, 13.09.04, 15:14:  
> Подкиньте примерчик градиентной заливки формы.

Вот посмотри:


    unit Graph32;
     
    interface
     
    uses
     Windows, Graphics;
     
    type
     TRGB = record
      B, G, R: byte;
     end;
     
     ARGB = array [0..1] of TRGB;
     
     PARGB = ^ARGB;
     
    procedure HGradientRect(Canvas: TCanvas; X1, Y1, X2, Y2: integer; Color1, Color2: TColor);
    procedure VGradientRect(Canvas: TCanvas; X1, Y1, X2, Y2: integer; Color1, Color2: TColor);
    procedure RGradientRect(Canvas: TCanvas; X1, Y1, X2, Y2: integer; Color1, Color2: TColor);
     
    var
     Bitmap: TBitmap;
     p: PARGB;
     
    implementation
     
    procedure HGradientRect(Canvas: TCanvas; X1, Y1, X2, Y2: integer; Color1, Color2: TColor);
    var
     x, y, c1, c2, r1, g1, b1: integer;
     dr, dg, db: real;
    begin
     Bitmap.Width:=abs(X1-X2);
     Bitmap.Height:=abs(Y1-Y2);
     c1:=ColorToRGB(Color1);
     r1:=getRValue(c1);
     g1:=getGValue(c1);
     b1:=getBValue(c1);
     c2:=ColorToRGB(Color2);
     dr:=(getRValue(c2)-r1)/Bitmap.Width;
     dg:=(getGValue(c2)-g1)/Bitmap.Width;
     db:=(getBValue(c2)-b1)/Bitmap.Width;
     for y:=0 to Bitmap.Height-1 do
     begin
      p:=Bitmap.ScanLine[y];
      for x:=0 to Bitmap.Width-1 do
      begin
       p[x].R:=round(r1+x*dr);
       p[x].G:=round(g1+x*dg);
       p[x].B:=round(b1+x*db)
      end
     end;
     Canvas.Draw(X1, Y1, Bitmap)
    end;
     
    procedure VGradientRect(Canvas: TCanvas; X1, Y1, X2, Y2: integer; Color1, Color2: TColor);
    var
     x, y, c1, c2, r1, g1, b1: integer;
     dr, dg, db: real;
    begin
     Bitmap.Width:=abs(X1-X2);
     Bitmap.Height:=abs(Y1-Y2);
     c1:=ColorToRGB(Color1);
     r1:=getRValue(c1);
     g1:=getGValue(c1);
     b1:=getBValue(c1);
     c2:=ColorToRGB(Color2);
     dr:=(getRValue(c2)-r1)/Bitmap.Height;
     dg:=(getGValue(c2)-g1)/Bitmap.Height;
     db:=(getBValue(c2)-b1)/Bitmap.Height;
     for y:=0 to Bitmap.Height-1 do
     begin
      p:=Bitmap.ScanLine[y];
      for x:=0 to Bitmap.Width-1 do
      begin
       p[x].R:=round(r1+y*dr);
       p[x].G:=round(g1+y*dg);
       p[x].B:=round(b1+y*db)
      end
     end;
     Canvas.Draw(X1, Y1, Bitmap)
    end;
     
    procedure RGradientRect(Canvas: TCanvas; X1, Y1, X2, Y2: integer; Color1, Color2: TColor);
    var
     x, y, c1, c2, r1, g1, b1: integer;
     dr, dg, db, d: real;
    begin
     Bitmap.Width:=abs(X1-X2);
     Bitmap.Height:=abs(Y1-Y2);
     c1:=ColorToRGB(Color1);
     r1:=getRValue(c1);
     g1:=getGValue(c1);
     b1:=getBValue(c1);
     c2:=ColorToRGB(Color2);
     d:=sqrt(Bitmap.Width*Bitmap.Width+Bitmap.Height*Bitmap.Height)/2;
     dr:=(getRValue(c2)-r1)/d;
     dg:=(getGValue(c2)-g1)/d;
     db:=(getBValue(c2)-b1)/d;
     for y:=0 to Bitmap.Height-1 do
     begin
      p:=Bitmap.ScanLine[y];
      for x:=0 to Bitmap.Width-1 do
      begin
       d:=sqrt(((Bitmap.Width-2*x)*(Bitmap.Width-2*x)+(Bitmap.Height-2*y)*(Bitmap.Height-2*y))/4);
       p[x].R:=round(r1+d*dr);
       p[x].G:=round(g1+d*dg);
       p[x].B:=round(b1+d*db)
      end
     end;
     Canvas.Draw(X1, Y1, Bitmap)
    end;
     
    initialization
     
    begin
     Bitmap:=TBitmap.create();
     Bitmap.PixelFormat:=pf24bit
    end;
     
    finalization
     
    begin
     Bitmap.free()
    end;
     
    end.


------------------------------------------------------------------------

Вариант 3:

Author: Rouse\_

Source: <https://forum.sources.ru>

Еще, как вариант, воспользоваться стандартной функцией GradientFill:

    uses ..., Math;
     
    procedure TForm1.Button1Click(Sender: TObject);
     
      function GetWRValue(Color: TColor): word;
      begin
       Result := Round(GetRValue(Color) /255 * 65535)
      end;
     
      function GetWGValue(Color: TColor): word;
      begin
       Result := Round(GetGValue(Color) / 255 * 65535)
      end;
     
      function GetWBValue(Color: TColor): word;
      begin
       Result := Round(GetBValue(Color) / 255 * 65535)
      end;
     
      type
       TRIVERTEX_NEW = packed record
         X,Y:Integer;
         R,G,B,Alpha: Word;
       end;
       TGradDirect = (gdVert, gdHorz);
     
    const
      FColorBegin = clRed; // Начальный цвет
      FColorEnd = clBlue; // Конечный цвет
      FGradDirect = gdHorz; // Направление заливки
     
    var
      _vertex: array [0..1] of TRIVERTEX_NEW;
      _rect  : _GRADIENT_RECT;
      _r     : TRect;
    begin
      FillChar(_vertex, SizeOf(TRIVERTEX_NEW)*2, 0);
      _r := GetClientRect;
      AdjustClientRect(_r);
      _vertex[0].x    := _r.Left;
      _vertex[0].y    := _r.Top;
      _vertex[0].R    := GetWRValue(FColorBegin);
      _vertex[0].G    := GetWGValue(FColorBegin);
      _vertex[0].B    := GetWBValue(FColorBegin);
      _vertex[1].x    := _r.Right;
      _vertex[1].y    := _r.Bottom;
      _vertex[1].R    := GetWRValue(FColorEnd);
      _vertex[1].G    := GetWGValue(FColorEnd);
      _vertex[1].B    := GetWBValue(FColorEnd);
      _rect.UpperLeft := 0;
      _rect.LowerRight:= 1;
      GradientFill(Canvas.Handle, PTriVertex(@_vertex)^, 2, @_rect, 1,
                   IfThen(FGradDirect = gdVert, GRADIENT_FILL_RECT_V, GRADIENT_FILL_RECT_H));
      Canvas.Brush.Style := bsClear;
      Canvas.Pen.Color   := Font.Color;
      Canvas.Font.Assign(Font);
      Canvas.TextOut(Round(Width/2 - Canvas.TextWidth(Text)/2),
                     Round(Height/2 - Canvas.TextHeight(Text)/2), Text)
    end;

