---
Title: Настройка сетки графика по оси ординат
Author: lookin
Date: 25.12.2002
---


Настройка сетки графика по оси ординат
======================================

//для использования в Delphi:

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Настройка оси
     
    Настройка сетки графика по оси ординат. Имеет смысл при 
    передаче данных в другие пакеты, использующие графическое 
    представление данных (например, в Excel).
     
    Зависимости: uses Chart, TeEngine, Math;
    Автор:       lookin
    Copyright:   lookin
    Дата:        25 декабря 2002 г.
    ********************************************** }
     
    //для использования в Delphi
    procedure CalcAxis(NChart: TChart);
    var step,ymx,ymn,rmx,rmn,raz: double;
        i,n,m,d: integer;
    begin
      with NChart do begin ymx:=-10000000000; ymn:=10000000000; m:=0; n:=0;
      for i:=0 to SeriesCount-1 do if Series[i].XValues.Count<>0 then begin
      if Series[i].YValues.MaxValue>ymx then ymx:=Series[i].YValues.MaxValue;
      if Series[i].YValues.MinValue<ymn then ymn:=Series[i].YValues.MinValue; end;
      rmx:=ymx; rmn:=ymn;
      while ymn<0 do begin ymn:=ymn+100; ymx:=ymx+100; Inc(m); end; raz:=ymx-ymn;
      while raz<100 do begin ymn:=ymn*10; ymx:=ymx*10; raz:=ymx-ymn; Inc(n); end;
      ymx:=Ceil(ymx); ymn:=Floor(ymn);
      d:=trunc(ymx) div 100; ymx:=(d+1)*100;
      d:=trunc(ymn) div 100; ymn:=d*100; raz:=ymx-ymn; step:=raz/5;
      ymx:=ymx/(Power(10,n))-m*100; ymn:=ymn/(Power(10,n))-m*100;
      step:=step/(Power(10,n)); d:=0;
      for i:=1 to 5 do if (d=0) and (ymn+step*i>rmx) then d:=i;
      if d<>0 then ymx:=ymn+step*d; d:=0;
      for i:=1 to 5 do if (d=0) and (ymn+step*i<rmn) then d:=i;
      if d<>0 then ymn:=ymn+step*d;
      with LeftAxis do begin Automatic:=false; Increment:=step;
      Minimum:=-100000000000; Maximum:=ymx; Minimum:=ymn; end; end;
    end;

//для использования в Excel в качестве макроса (Visual Basic):

    Function SetAxisRange(CChart As Chart, ByRef AMax As Double, ByRef AMin As Double, ByRef AStep As Double)
     
    Dim Step, RMax, RMin, Max, Min, Raz As Double
    Dim I, J, N, M, d As Integer
     
        Max = -1000000
        Min = 1000000
        For I = 1 To CChart.SeriesCollection.Count
        ReDim VArray(UBound(CChart.SeriesCollection(I).Values))
        VArray = CChart.SeriesCollection(I).Values
        For J = 1 To UBound(VArray)
        If VArray(J) > Max Then Max = VArray(J)
        If VArray(J) < Min Then Min = VArray(J)
        Next J
        Next I
        RMax = Max
        RMin = Min
        N = 0
        M = 0
        If Max <> Min Then
        While Min < 0
        Min = Min + 100
        Max = Max + 100
        M = M + 1
        Wend
        Raz = Max - Min
        While Raz < 100
        Min = Min * 10
        Max = Max * 10
        Raz = Max - Min
        N = N + 1
        Wend
        Max = Int(Max) + 1
        Min = Int(Min)
        d = Max \ 100
        Max = (d + 1) * 100
        d = Min \ 100
        Min = d * 100
        Raz = Max - Min
        Step = Raz / 5
        AStep = Step / (10 ^ N)
        AMin = Min / (10 ^ N) - M * 100
        AMax = Max / (10 ^ N) - M * 100
        d = 0
        For I = 1 To 5
        If d = 0 Then
        If (AMin + AStep * I) > RMax Then d = I
        End If
        Next I
        If d <> 0 Then AMax = AMin + AStep * d
        d = 0
        For I = 1 To 5
        If d = 0 Then
        If (AMin + AStep * I) < RMin Then d = I
        End If
        Next I
        If d <> 0 Then AMin = AMin + AStep * d
        End If
     
    End Function 


