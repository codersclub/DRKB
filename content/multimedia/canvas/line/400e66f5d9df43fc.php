<h1>Рисование кривых в Delphi</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Dmitry Streblechenko </div>

<p>У кого-нибудь есть исходный код или какая-либо информация для рисования кривых Безье? Я должен использовать их в своем компоненте.</p>

<p>Я делал это недавно; мне было лениво разбираться с тем, как рисовать кривые Безье с помощью Win API, поэтому я использовал функцию Polyline(). </p>

<p class="note">Примечание: для координатных точек я использовал реальные величины типа floating (я применял некоторый тип виртуального экрана), округляя их до целого.</p>

<pre>
PBezierPoint = ^TBezierPoint;
TBezierPoint = record
  X, Y: double;   // основной узел
  Xl, Yl: double; // левая контрольная точка
  Xr, Yr: double; // правая контрольная точка
end;
 
// P1 и P2 - две точки TBezierPoint, расположенные между 0 и 1:
// когда t=0 X=P1.X, Y=P1.Y; когда t=1 X=P2.X, Y=P2.Y;
 
procedure BezierValue(P1, P2: TBezierPoint; t: double; var X, Y: double);
var
  t_sq, t_cb, r1, r2, r3, r4: double;
begin
  t_sq := t * t;
  t_cb := t * t_sq;
  r1 := (1 - 3 * t + 3 * t_sq - t_cb) * P1.X;
  r2 := (3 * t - 6 * t_sq + 3 * t_cb) * P1.Xr;
  r3 := (3 * t_sq - 3 * t_cb) * P2.Xl;
  r4 := (t_cb) * P2.X;
  X := r1 + r2 + r3 + r4;
  r1 := (1 - 3 * t + 3 * t_sq - t_cb) * P1.Y;
  r2 := (3 * t - 6 * t_sq + 3 * t_cb) * P1.Yr;
  r3 := (3 * t_sq - 3 * t_cb) * P2.Yl;
  r4 := (t_cb) * P2.Y;
  Y := r1 + r2 + r3 + r4;
end;
</pre>



<p>Для рисования кривой Безье разделяем интервал между P1 и P2 на несколько отрезков (их количество влияет на точность воспроизведения кривой, 3 - 4 точки вполне достаточно), затем в цикле создаем массив точек, используем описанную выше процедуру с параметром t от 0 до 1 и рисуем данный массив точек, используя функцию polyline(). </p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
