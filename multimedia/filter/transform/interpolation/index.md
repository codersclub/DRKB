---
Title: Как качественно увеличить изображение при помощи билинейной интерполяции?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как качественно увеличить изображение при помощи билинейной интерполяции?
=========================================================================

При увеличении изображения нужно находить цвет точек,
находящихся между точками исходного изображения.

Функция CopyRect, встроенная в Delphi,
берет для этого цвет ближайшей точки.

Увеличенное изображение получается некрасивым.
Чтобы избежать этого, используют интерполяцию.

Существует несколько видов интерполяции изображения.
Наиболее простой из них - билинейный.

Изображение рассматривается как поверхность, цвет - третье измерение.

Если изображение цветное, то интерполяция проводится отдельно для трех
цветов.

Для каждой точки нового изображения с координатами (xo,yo)
нужно найти четыре ближайшие точки исходного изображения.

Эти точки образуют квадрат. Через две верхние точки проводится прямая
f1(x), через две нижние - f2(x).

Дальше находятся координаты для точек f1(xo) и f2(xo),
через которые проводится третья прямая f3(y).
Цвет искомой точки - это f3(yo).

Этот алгоритм хорошо работает при целых или больших коэффициентах
увеличения. Но резкие границы размываются.

Для уменьшения изображения этот алгоритм также не подходит.

Эта программа при нажатии на Button1 увеличивает часть изображения на
экране, а при нажатии на Button2 увеличивает открытое изображение.

    procedure Interpolate(var bm: TBitMap; dx, dy: single);
    var
      bm1: TBitMap;
      z1, z2: single;
      k, k1, k2: single;
      x1, y1: integer;
      c: array [0..1, 0..1, 0..2] of byte;
      res: array [0..2] of byte;
      x, y: integer;
      xp, yp: integer;
      xo, yo: integer;
      col: integer;
      pix: TColor;
    begin
      bm1 := TBitMap.Create;
      bm1.Width := round(bm.Width * dx);
      bm1.Height := round(bm.Height * dy);
      for y := 0 to bm1.Height - 1 do
      begin
        for x := 0 to bm1.Width - 1 do
        begin
          xo := trunc(x / dx);
          yo := trunc(y / dy);
          x1 := round(xo * dx);
          y1 := round(yo * dy);
     
          for yp := 0 to 1 do
            for xp := 0 to 1 do
            begin
              pix := bm.Canvas.Pixels[xo + xp, yo + yp];
              c[xp, yp, 0] := GetRValue(pix);
              c[xp, yp, 1] := GetGValue(pix);
              c[xp, yp, 2] := GetBValue(pix);
            end;
     
          for col := 0 to 2 do
          begin
            k1 := (c[1,0,col] - c[0,0,col]) / dx;
            z1 := x * k1 + c[0,0,col] - x1 * k1;
            k2 := (c[1,1,col] - c[0,1,col]) / dx;
            z2 := x * k2 + c[0,1,col] - x1 * k2;
            k := (z2 - z1) / dy;
            res[col] := round(y * k + z1 - y1 * k);
          end;
          bm1.Canvas.Pixels[x,y] := RGB(res[0], res[1], res[2]);
        end;
        Form1.Caption := IntToStr(round(100 * y / bm1.Height)) + '%';
        Application.ProcessMessages;
        if Application.Terminated then
          Exit;
      end;
      bm := bm1;
    end;
     
    const
      dx = 5.5;
      dy = 5.5;
     
    procedure TForm1.Button1Click(Sender: TObject);
    const
      w = 50;
      h = 50;
    var
      bm: TBitMap;
      can: TCanvas;
    begin
      bm := TBitMap.Create;
      can := TCanvas.Create;
      can.Handle := GetDC(0);
      bm.Width := w;
      bm.Height := h;
      bm.Canvas.CopyRect(Bounds(0, 0, w, h), can, Bounds(0, 0, w, h));
      ReleaseDC(0, can.Handle);
      Interpolate(bm, dx, dy);
      Form1.Canvas.Draw(0, 0, bm);
      Form1.Caption := 'x: ' + FloatToStr(dx) +
        ' y: ' + FloatToStr(dy) +
        ' width: ' + IntToStr(w) +
        ' height: ' + IntToStr(h);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
      bm: TBitMap;
    begin
      if OpenDialog1.Execute then
        bm.LoadFromFile(OpenDialog1.FileName);
      Interpolate(bm, dx, dy);
      Form1.Canvas.Draw(0, 0, bm);
      Form1.Caption := 'x: ' + FloatToStr(dx) +
        ' y: ' + FloatToStr(dy) +
        ' width: ' + IntToStr(bm.Width) +
        ' height: ' + IntToStr(bm.Height);
    end;

