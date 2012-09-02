<h1>Найти точку пересечения прямых</h1>
<div class="date">01.01.2007</div>


<pre>
// determine if 2 line cross given their end-points
function LinesCross(LineAP1, LineAP2, LineBP1, LineBP2 : TPoint) : boolean;
Var
  diffLA, diffLB : TPoint;
  CompareA, CompareB : integer;
begin
  Result := False;
 
  diffLA := Subtract(LineAP2, LineAP1);
  diffLB := Subtract(LineBP2, LineBP1);
 
  CompareA := diffLA.X*LineAP1.Y - diffLA.Y*LineAP1.X;
  CompareB := diffLB.X*LineBP1.Y - diffLB.Y*LineBP1.X;
 
  if ( ((diffLA.X*LineBP1.Y - diffLA.Y*LineBP1.X) &lt; CompareA) xor
       ((diffLA.X*LineBP2.Y - diffLA.Y*LineBP2.X) &lt; CompareA) ) and
     ( ((diffLB.X*LineAP1.Y - diffLB.Y*LineAP1.X) &lt; CompareB) xor
       ((diffLB.X*LineAP2.Y - diffLB.Y*LineAP2.X) &lt; CompareB) ) then
    Result := True;
end;
 
function LineIntersect(LineAP1, LineAP2, LineBP1, LineBP2 : TPoint) : TPointFloat;
Var
  LDetLineA, LDetLineB, LDetDivInv : Real;
  LDiffLA, LDiffLB : TPoint;
begin
  LDetLineA := LineAP1.X*LineAP2.Y - LineAP1.Y*LineAP2.X;
  LDetLineB := LineBP1.X*LineBP2.Y - LineBP1.Y*LineBP2.X;
 
  LDiffLA := Subtract(LineAP1, LineAP2);
  LDiffLB := Subtract(LineBP1, LineBP2);
 
  LDetDivInv := 1 / ((LDiffLA.X*LDiffLB.Y) - (LDiffLA.Y*LDiffLB.X));
 
  Result.X := ((LDetLineA*LDiffLB.X) - (LDiffLA.X*LDetLineB)) * LDetDivInv;
  Result.Y := ((LDetLineA*LDiffLB.Y) - (LDiffLA.Y*LDetLineB)) * LDetDivInv;
end;
 
function Subtract(AVec1, AVec2 : TPoint) : TPoint;
begin
  Result.X := AVec1.X - AVec2.X;
  Result.Y := AVec1.Y - AVec2.Y;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
