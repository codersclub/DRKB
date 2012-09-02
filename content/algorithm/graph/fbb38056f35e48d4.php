<h1>Путь в двумерном лабиринте &ndash; волновой алгоритм</h1>
<div class="date">01.01.2007</div>

<p>Идея этого метода весьма проста: в стороны от исходной точки распростроняется волна.</p>
<p>Начальное значение волны - ноль.</p>
<p>То есть ближайшие точки, в которые можно пойти, например, верх, низ, левая и правая, и которые еще не затронуты волной, получают значение волны+некоторый модификатор проходимости этой точки. Чем он больше - тем медленнее преодоление данного участка. Значение волны увеличивается на 1.</p>
<p>Обрабатываем аналогично клетки, отходя от тех, на которой значение волны - 2. При этом на клетках с худшей проходимостью волна задержится.</p>
<p>И так дальше все обрабатывается, пока не достигнута конечная точка маршрута.</p>
<p>Сам путь в получившемся массиве значений волны вычисляется по наименьшим клеткам. В примере на Си все очень хорошо продемонстрировано.</p>
<pre>Program Voln;
 
Uses Crt;
 
Const
 
     Map : array [1..10, 1..10] of Byte =
 
         (
 
                (0, 0, 1, 0, 0, 0, 0, 0, 0, 0),
 
                (1, 0, 0, 0, 0, 1, 0, 0, 1, 0),
 
                (0, 0, 0, 1, 1, 1, 0, 0, 1, 1),
 
                (0, 1, 0, 0, 0, 1, 0, 0, 1, 0),
 
                (0, 0, 0, 0, 1, 1, 1, 0, 1, 0),
 
                (0, 0, 1, 1, 1, 0, 1, 0, 0, 0),
 
                (0, 0, 0, 1, 0, 0, 1, 0, 0, 0),
 
                (1, 1, 0, 1, 0, 0, 1, 1, 1, 0),
 
                (0, 1, 0, 0, 0, 0, 1, 0, 0, 0),
 
                (0, 1, 0, 0, 0, 0, 1, 0, 0, 0)
 
         );
 
var
 
   XS, YS, XE, YE : Byte;
 
   X, Y, I : Byte;
 
   MapM : array [1..10, 1..10] of Byte;
 
   Moves : Byte;
 
   MovesX : array [1..100] of Byte;
 
   MovesY : array [1..100] of Byte;
 
Procedure Next(Var X, Y : Byte);
 
Begin
 
     If (X &lt;10) and (MapM[X, Y] - MapM[X + 1, Y] = 1) then
 
        Begin
 
             X := X + 1;
 
             Exit;
 
        End;
 
     If (X &gt;1) and (MapM[X, Y] - MapM[X - 1, Y] = 1) then
 
        Begin
 
             X := X - 1;
 
             Exit;
 
        End;
 
     If (Y &lt;10) and (MapM[X, Y] - MapM[X, Y + 1] = 1) then
 
        Begin
 
             Y := Y + 1;
 
             Exit;
 
        End;
 
     If (Y &gt;1) and (MapM[X, Y] - MapM[X, Y - 1] = 1) then
 
        Begin
 
             Y := Y - 1;
 
             Exit;
 
        End;
 
End;
 
Begin
 
     ClrScr;
 
     For Y := 1 to 10 do
 
         Begin
 
              For X := 1 to 10 do Write(Map[X, Y], ' ');
 
              WriteLn;
 
         End;
 
     WriteLn('Please enter X and Y of the start: ');
 
     ReadLn(XS, YS);
 
     WriteLn('Please enter X and Y of the end: ');
 
     ReadLn(XE, YE);
 
     If (Map[XS, YS] = 1) or (Map[XE, YE] = 1) then
 
        Begin
 
             WriteLn('Error!!!');
 
             ReadLn;
 
             Halt;
 
        End;
 
     MapM[XS, YS] := 1;
 
     I := 1;
 
     Repeat
 
           I := I + 1;
 
           For Y := 1 to 10 do
 
             For X := 1 to 10 do
 
               If MapM[X, Y] = I - 1 then
 
                 Begin
 
                   If (Y &lt;10) and (MapM[X, Y + 1] = 0) 
and (Map[X, Y+1] = 0) Then MapM[X, Y+1] := I;
 
                   If (Y &gt;1) 
and (MapM[X, Y-1] = 0) and (Map[X, Y-1] = 0) Then MapM[X, Y-1] := I;
 
                   If (X &lt;10) 
and (MapM[X+1, Y] = 0) and (Map[X+1, Y] = 0) Then MapM[X+1, Y] := I;
 
                   If (X &gt;1) 
and (MapM[X-1, Y] = 0) and (Map[X-1, Y] = 0) Then MapM[X-1, Y] := I;
 
                  End;
 
         If I = 100 then
 
              Begin
 
                   WriteLn('You cant go there!!!');
 
                   ReadLn;
 
                   Halt;
 
              End;
 
     Until MapM[XE, YE] &gt;0;
 
     Moves := I - 1;
 
     X := XE;
 
     Y := YE;
 
     I := Moves;
 
     Map[XE, YE] := 4;
 
     Repeat
 
           MovesX[I] := X;
 
           MovesY[I] := Y;
 
           Next(X, Y);
 
           Map[X, Y] := 3;
 
           I := I - 1;
 
     Until (X = XS) and (Y = YS);
 
     Map[XS, YS] := 2;
 
     For I := 1 to Moves do WriteLn('X = ', MovesX[I],', Y = ', MovesY[I]);
 
     WriteLn('Total: ', Moves, ' moves');
 
     ReadLn;
 
     For Y := 1 to 10 do
 
         Begin
 
              For X := 1 to 10 do Write(Map[X, Y], ' ');
 
              WriteLn;
 
         End;
 
     ReadLn;
 
End.
</pre>
<p><a href="https://algolist.manual.ru" target="_blank">https://algolist.manual.ru</a></p>

