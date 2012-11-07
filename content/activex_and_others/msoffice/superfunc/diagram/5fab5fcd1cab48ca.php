<h1>Наклон и поворот</h1>
<div class="date">01.01.2007</div>

<p>Наклон и поворот</p>
Наклон диаграммы можно выполнить на угол от -90&#176; до +90&#176;. Значения, выходящие за эти пределы, вызывают ошибку. Выбор угла поворота осуществляется записью значения угла в свойство Elevation объекта Chart. Поворот диаграммы осуществляется записью в поле Rotation объекта Chart значения угла поворота. Этот угол может иметь значения от 0&#176; до 360&#176;. Для задания углов наклона и поворота в приложениях на Delphi можно использовать функции ElevationChart и RotationChart.</p>

<pre class="delphi">
Function ElevationChart (Name:variant;Elevation:real):boolean;
begin
 ElevationChart:=true;
 try
  E.Charts.Item[name].Elevation:=Elevation;
 except
  ElevationChart:=false;
 end;
End;
Function RotationChart(Name:variant;Rotation:real):boolean;
begin
 RotationChart:=true;
 try
  E.Charts.Item[name].Rotation:=Rotation;
 except
  RotationChart:=false;
 end;
End;
</pre>
</p>
