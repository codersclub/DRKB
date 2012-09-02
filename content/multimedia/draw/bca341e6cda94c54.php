<h1>Как изменить размеры полигона?</h1>
<div class="date">01.01.2007</div>



<pre>
{ ... }
type
  TPolygon = array of TPoint;
 
procedure ZoomPolygon(var Polygon: TPolygon; const Center: TPoint; const Scale: Double);
var
  I: Integer;
begin
  for I := 0 to High(Polygon) do
  begin
    Polygon[I].X := Round(Scale * (Polygon[I].X - Center.X) + Center.X);
    Polygon[I].Y := Round(Scale * (Polygon[I].Y - Center.Y) + Center.Y);
  end;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
