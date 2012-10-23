<h1>Создание PolyPolygon, используя массив точек</h1>
<div class="date">01.01.2007</div>



<p>Polygon - метод компонента TCanvas получает в качестве параметра динамический массив точек. Функция PolyPolygon() из Windows GDI получает указатель на массив точек.</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  ptArray: array[0..9] of TPOINT;
  PtCounts: array[0..1] of integer;
begin
  PtArray[0] := Point(0, 0);
  PtArray[1] := Point(0, 100);
  PtArray[2] := Point(100, 100);
  PtArray[3] := Point(100, 0);
  PtArray[4] := Point(0, 0);
  PtCounts[0] := 5;
  PtArray[5] := Point(25, 25);
  PtArray[6] := Point(25, 75);
  PtArray[7] := Point(75, 75);
  PtArray[8] := Point(75, 25);
  PtArray[9] := Point(25, 25);
  PtCounts[1] := 5;
  PolyPolygon(Form1.Canvas.Handle,PtArray, PtCounts, 2);
end;
</pre>

