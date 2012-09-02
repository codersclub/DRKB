<h1>Размещение диаграммы</h1>
<div class="date">01.01.2007</div>

<p>Диаграмма может размещаться совместно с данными или на отдельном листе. Размещение диаграммы лучше совмещать с процессом ее создания, но можно выполнить эту процедуру и самостоятельно. При этом необходимо учитывать, что при изменении размещения меняется и имя диаграммы (не путать с названием). Для размещения диаграммы используйте функцию SetChartLocation, аргумент xlLocation которой может иметь одно из двух значений (xlLocationAsNewSheet или xlLocationAsObject).</p>
<pre>
Function SetChartLocation (var name:variant;sheet:variant;
  xlLocation:integer):boolean;
begin
 SetChartLocation:=true;
 try
  name:=E.Charts.Item[name].Location(Where:=
   xlLocationAsObject,Name:=sheet).name;
 except
 SetChartLocation:=false;
 end;
End;
</pre>

