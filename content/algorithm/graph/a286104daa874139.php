<h1>Проверка попадания точки в треугольник</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Проверка попадания точки в треугольник
 
Проверяет попадает ли точка P в треугольник ABC.
Вершины должны быть перечислены против часовой стрелки.
 
Зависимости: нет
Автор:       Fenik, fenik@nm.ru, Новоуральск
Copyright:   Николай Федоровских
Дата:        8 октября 2004 г.
********************************************** }
 
function PtInTriang(const P, A, B, C: TPoint): Boolean;
{Внимание!! Вершины должны быть заданы против часовой стрелки!
        A
       / \
      / \
     B----C }
begin
  Result := False;
  if (P.x-A.x)*(A.y-B.y) - (P.y-A.y)*(A.x-B.x) &gt;= 0 then
  if (P.x-B.x)*(B.y-C.y) - (P.y-B.y)*(B.x-C.x) &gt;= 0 then
  if (P.x-C.x)*(C.y-A.y) - (P.y-C.y)*(C.x-A.x) &gt;= 0 then
    Result := True;
end;
</pre>

