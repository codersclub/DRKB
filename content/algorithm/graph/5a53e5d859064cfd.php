<h1>Найти центр треугольника</h1>
<div class="date">01.01.2007</div>


<p>Determine the circum-center of a 2D triangle?</p>
<pre>
procedure Circumcenter(x1, y1, x2, y2, x3, y3: Double; var Px, Py: Double);
var 
  A, C, B, D, E, F, G: Double;
begin
  A := x2 - x1;
  B := y2 - y1;
  C := x3 - x1;
  D := y3 - y1;
  E := A * (x1 + x2) + B * (y1 + y3);
  F := C * (x1 + x2) + D * (y1 + y3);
  G := 2.0 * (A * (y3 - y2) - B * (x3 - x2));
  if G = 0 then
    Exit;
  Px := (D * E - B * F) / G;
  Py := (A * F - C * E) / G;
end;
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr /><p>Determine the incenter of a 2D triangle?</p>
<pre>
procedure Incenter(x1, y1, x2, y2, x3, y3: Double; var Px, Py: Double);
var
  Perim: Double;
  Side12: Double;
  Side23: Double;
  Side31: Double;
begin
  Side12 := Distance(x1, y1, x2, y2);
  Side23 := Distance(x2, y2, x3, y3);
  Side31 := Distance(x3, y3, x1, y1);
 
  { using Heron's S=UR }
  Perim := 1 / (Side12 + Side23 + Side31);
  Px := (Side23 * x1 + Side31 * x2 + Side12 * x3) * Perim;
  Py := (Side23 * y1 + Side31 * y2 + Side12 * y3) * Perim;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
