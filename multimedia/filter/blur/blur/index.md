---
Title: Размыть изображение
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Размыть изображение
===================

Вариант 1:

В этом способе цвету каждой точки присваивается среднее значение цветов
соседних точек.

    procedure TForm1.Button1Click(Sender: TObject);
    const
      width = 100;
      height = 60;
      d = 2;
    var
      x, y: integer;
      i, j: integer;
      c: integer;
      Pix: array [0..width-1, 0..height-1] of byte;
    begin
      randomize;
      with Form1.Canvas do begin
        Font.Name := 'Arial';
        Font.Size := 30;
        TextOut(d, d, 'Text');
     
        for y := 0 to height - 1 do
          for x := 0 to width - 1 do
            Pix[x,y] := GetRValue(Pixels[x,y]);
        for y := d to height - d - 1 do begin
          for x := d to width - d - 1 do begin
            c := 0;
            for i := -d to d do
              for j := -d to d do
                c := c + Pix[x+i,y+j];
            c := round(c / sqr(2 * d + 1));
     
            Pixels[x,y] := RGB(c, c, c);
          end;
          Application.ProcessMessages;
        end;
      end;
    end;

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)
