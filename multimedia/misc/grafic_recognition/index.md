---
Title: Как построить график, используя модуль Recognition?
Author: Smike
Date: 01.01.2007
---


Как построить график, используя модуль Recognition?
==============================

Эта программа строит заданные графики, используя модуль Recognition.
От констант left и right зависит диапазон x, от YScale зависит масштаб по y,
а от k зависит качество прорисовки.

    uses Recognition;
     
    procedure TForm1.Button1Click(Sender: TObject);
    const
      left = -10;
      right = 10;
      YScale = 50;
      k = 10;
    var
      i: integer;
      Num: extended;
      s: String;
      XScale: single;
      col: TColor;
    begin
      s := Edit1.Text;
      preparation(s, ['x']);
      XScale := PaintBox1.Width / (right - left);
      randomize;
      col := RGB(random(100), random(100), random(100));
      for i := round(left * XScale * k) to round(right * XScale * k) do
        if recogn(ChangeVar(s, 'x', i / XScale / k), Num) then
          PaintBox1.Canvas.Pixels[round(i / k - left * XScale),
            round(PaintBox1.Height / 2 - Num * YScale)] := col;
    end;

Взято с сайта <https://blackman.wp-club.net/>
