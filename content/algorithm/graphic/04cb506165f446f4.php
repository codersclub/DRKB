<h1>Центр вписанной в треугольник окружности</h1>
<div class="date">01.01.2007</div>


<pre>
 {**** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Центр вписанной в треугольник окружности
 
P1, P2, P3 - вершины треугольника.
 
Зависимости: Windows
Автор:       Fenik, fenik@nm.ru, Новоуральск
Copyright:   Николай Федоровских
Дата:        29 сентября 2004 г.
********************************************** }
 
function CenterCircleInTriang(const P1, P2, P3: TPoint): TPoint;
 
  function LineLength(P1, P2: TPoint): Double;
  begin
    Result := Sqrt(Sqr(P1.X - P2.X) + Sqr(P1.Y - P2.Y));
  end;
 
var a, b, c, Perim: Double;
begin
  a := LineLength(P1, P2);
  b := LineLength(P2, P3);
  c := LineLength(P3, P1);
  Perim := 1 / (a + b + c);
  Result := Point(Round((b * P1.x + c * P2.x + a * P3.x) * Perim),
                  Round((b * P1.y + c * P2.y + a * P3.y) * Perim));
end; 
 
 
 Пример использования:
function Distance(const P, P1, P2: TPoint): Integer;
{ Расстояние от точки P до прямой P1-P2 }
begin 
  Result := Abs(Round(
    ((P1.Y - P2.Y) * P.X +
     (P2.X - P1.X) * P.Y +
     (P1.X * P2.Y - P2.X * P1.Y)) /
    Sqrt(Sqr(P1.X - P2.X) + Sqr(P2.Y - P1.Y))));
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var P1, P2, P3, C: TPoint;
    L: Integer;
begin
  P1 := Point(60, 160);
  P2 := Point(250, 110);
  P3 := Point(365, 350);
  C := CenterCircleInTriang(P1, P2, P3);
  L := Distance(C, P1, P2);
  with Canvas do begin
    Brush.Color := clWhite;
    Polygon([P1, P2, P3]);
    Brush.Color := clRed;
    Ellipse(C.X - L, C.Y - L, C.X + L, C.Y + L);
  end;
end; 
</pre>

