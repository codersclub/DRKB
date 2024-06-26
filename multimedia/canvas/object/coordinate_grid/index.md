---
Title: Координатная сетка
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Координатная сетка
==================

    unit grid_;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    type
      TForm1 = class(TForm)
        procedure FormPaint(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormPaint(Sender: TObject);
    var
      x0, y0: integer; // координаты начала координатных осей
      dx, dy: integer; // шаг координатной сетки (в пикселях)
      h, w: integer; // высота и ширина области вывода координатной сетки
      x, y: integer;
     
      lx, ly: real; // метки (оцифровка) линий сетки по X  Y
      dlx, dly: real; // шаг меток (оцифровки) линий сетки по X и Y
      cross: integer; // счетчик не оцифрованных линий сетки
      dcross: integer; // количество не оцифрованных линий между оцифрованными
    begin
      x0 := 30;
      y0 := 220; // оси начинаются в точке (40,250)
      dx := 40;
      dy := 40; // шаг координатной сетки 40 пикселей
      dcross := 1; // помечать линии сетки X:
      //                         1 - каждую;
      //                         2 - через одну;
      //                         3 - через две;
      dlx := 0.5; // шаг меток оси X
      dly := 1.0; // шаг меток оси Y, метками будут: 1, 2, 3 и т.д.
     
      h := 200;
      w := 300;
     
      with form1.Canvas do
      begin
        cross := dcross;
        MoveTo(x0, y0);
        LineTo(x0, y0 - h); // ось X
        MoveTo(x0, y0);
        LineTo(x0 + w, y0); // ось Y
     
        // засечки, сетка и оцифровка по оси X
        x := x0 + dx;
        lx := dlx;
        repeat
          MoveTo(x, y0 - 3);
          LineTo(x, y0 + 3); // засечка
          cross := cross - 1;
          if cross = 0 then //оцифровка
          begin
            TextOut(x - 8, y0 + 5, FloatToStr(lx));
            cross := dcross;
          end;
          Pen.Style := psDot;
          MoveTo(x, y0 - 3);
          LineTo(x, y0 - h); // линия сетки
          Pen.Style := psSolid;
          lx := lx + dlx;
          x := x + dx;
        until (x > x0 + w);
     
        // засечки, сетка и оцифровка по оси Y
        y := y0 - dy;
        ly := dly;
        repeat
          MoveTo(x0 - 3, y);
          LineTo(x0 + 3, y); // засечка
          TextOut(x0 - 20, y, FloatToStr(ly)); // оцифровка
          Pen.Style := psDot;
          MoveTo(x0 + 3, y);
          LineTo(x0 + w, y); // линия сетки
          Pen.Style := psSolid;
          y := y - dy;
          ly := ly + dly;
        until (y < y0 - h);
      end;
    end;
     
    end.


