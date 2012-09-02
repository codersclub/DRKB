<h1>Как использовать ChartFX?</h1>
<div class="date">01.01.2007</div>


<pre>
with ChartFX do begin 
    Visible := false; 
    { Устанавливаем режим ввода значений } 
    { 1 - количество серий (в нашем случае 1), 3 - количество значений } 
    OpenData [COD_VALUES] := MakeLong (1,3); 
    { Hомер текущей серии } 
    ThisSerie := 0; 
    { Value [i] - значение с индексом i } 
    { Legend [i] - комментарий к этому значению } 
    Value [0] := a; 
    Legend [0] := 'Значение переменной A'; 
    Value [1] := b; 
    Legend [1] := 'Значение переменной B'; 
    Value [2] := c; 
    Legend [2] := 'Значение переменной C'; 
    { Закрываем режим } 
    CloseData [COD_VALUES] := 0; 
    { Ширина поля с комментариями на экране (в пикселах) } 
    LegendWidth := 150; 
    Visible := true; 
  end; 
end;
</pre>

