<h1>Вычисление площади одноконтурного несамопересекающегося многоугольника</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Вычисление площади одноконтурного несамопересекающегося многоугольника
 
1.Для многоконтурных или самопересекающихся многоугольников функция вернет неверный результат.
2.Площадь всегда положительна (т.е. не зависит от направления обхода).
 
Зависимости: нет
Автор:       Виктор Щербаков, shherbakov@yandex.ru, Нижний Новгород
Copyright:   Виктор Щербаков
Дата:        18 апреля 2002 г.
********************************************** }
 
// Точка
type TFloatPoint = record
   X, Y: Double;
 end;
 
// Точки полигона
type TPolygonPoints = array of TFloatPoint;
 
// Сама функция
function PolygonSquare(Poly: TPolygonPoints): Double;
 var
   I, J, HP: Integer;
begin
  Result := 0;
  HP := High(Poly);
  for I := Low(Poly) to HP do
  begin
    if I = HP then J := 0
      else J := I + 1;
    Result := Result + (Poly[I].X + Poly[J].X) * (Poly[I].Y - Poly[J].Y);
  end;
  Result := Abs(Result) / 2;
end;
</pre>

