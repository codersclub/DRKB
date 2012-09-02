<h1>Отрисовка стрелки</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Отрисовка стрелки с заданными параметрами
 
// рисует стрелку с заданными параметрами
// X_Line, Y_Line - координаты "неподвижного" конца линии стрелки;
// Length_Line, Length_Arrow - длина линии и бокового ребра стрелки;
// Angle_Line, Angle_Arrow - углы между линией стрелки и горизонтальной
// осью и между линией стрелки и боковым ребром стрелки;
// IsAllTriangle - если True, то "подвижные" концы боковых рёбер стрелки
// соединяются отрезком прямой(и не рисуется высота равнобедренного треугольника стрелки);
// DrawSurface - поверхность на которой будет рисоваться стрелка
 
Зависимости: ничего неожиданного
Автор:       Александр
Copyright:   default
Дата:        14 февраля 2004 г.
***************************************************** }
 
procedure DrawArrow(X_Line, Y_Line, Length_Line, Length_Arrow: Integer;
  Angle_Line, Angle_Arrow: Extended;
  IsAllTriangle: Boolean; DrawSurface: TCanvas);
var
  XB, YB, XE, YE, XM, YM: Integer;
begin
 
  XB := Round(X_Line + Cos(Angle_Line) * Length_Line);
  YB := Round(Y_Line - Sin(Angle_Line) * Length_Line);
  XM := Round(XB - Cos(Angle_Arrow - Angle_Line) * Length_Arrow);
  YM := Round(YB - Sin(Angle_Arrow - Angle_Line) * Length_Arrow);
  XE := Round(XB + Sin(Angle_Arrow + Angle_Line - Pi / 2) * Length_Arrow);
  YE := Round(YB + Cos(Angle_Arrow + Angle_Line - Pi / 2) * Length_Arrow);
  DrawSurface.MoveTo(X_Line, Y_Line);
  if IsAllTriangle then
  begin
    DrawSurface.LineTo(Round((XM + XE) / 2), Round((YM + YE) / 2));
    DrawSurface.MoveTo(XB, YB);
  end
  else
    DrawSurface.LineTo(XB, YB);
  DrawSurface.LineTo(XM, YM);
  if IsAllTriangle then
    DrawSurface.LineTo(XE, YE)
  else
    DrawSurface.MoveTo(XE, YE);
  DrawSurface.LineTo(XB, YB)
 
end;
</pre>


