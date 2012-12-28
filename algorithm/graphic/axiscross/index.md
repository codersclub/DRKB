---
Title: Поиск пересечений графика с осью абсцисс
Date: 01.01.2007
---


Поиск пересечений графика с осью абсцисс
========================================

::: {.date}
01.01.2007
:::

Для поиска пересечений графика заданной функции с осью абсцисс очень
удобен метод хорд.

Он основан на линейной интерполяции. По двум точкам, лежащим по разные
стороны от оси OX,

строится прямая. Поскольку точка пересечения этой прямой с осью OX уже
ближе к искомому x,

то при повторении этой операции точность резко увеличивается.

Если функция задана массивом точек, то можно произвести только одну
операцию приближения.

    function F(x: double): double;
    begin
      result := sin(x);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    const
      left = -10;
      right = 10;
    var
      x1, x2: double;
      y1, y2: double;
      k, b: double;
      x, y: double;
      d1, d2: double;
    begin
      x1 := left;
      y1 := f(x1);
      repeat
        x2 := x1 + 0.1;
        y2 := f(x2);
        if y1 * y2 < 0 then begin
          repeat
            y1 := f(x1);
            y2 := f(x2);
            k := (y1 - y2) / (x1 - x2);
            b := y1 - k * x1;
            x := -b / k;
            y := k * x + b;
            d1 := sqr(x1 - x) + sqr(y1 - y);
            d2 := sqr(x2 - x) + sqr(y2 - y);
            if d1 > d2 then begin
              d1 := d2;
              x1 := x;
            end else x2 := x;
          until d1 < 1E-20;
          ListBox1.Items.Add(FloatToStr(x1));
        end;
        x1 := x2;
        y1 := y2;
      until x2 > right;
    end;

Взято с сайта <https://blackman.wp-club.net/>
