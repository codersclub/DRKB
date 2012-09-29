<h1>Rotate a 2D Point</h1>
<div class="date">01.01.2007</div>


<pre>
const
  PIDiv180 = 0.017453292519943295769236907684886;
 
procedure Rotate(RotAng: Double; x, y: Double; var Nx, Ny: Double);
var
  SinVal: Double;
  CosVal: Double;
begin
  RotAng := RotAng * PIDiv180;
  SinVal := Sin(RotAng);
  CosVal := Cos(RotAng);
  Nx := x * CosVal - y * SinVal;
  Ny := y * CosVal + x * SinVal;
end;
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr /><p>Rotate a 2D Point around another 2D Point</p>
<pre>
const
  PIDiv180 = 0.017453292519943295769236907684886;
 
procedure Rotate(RotAng: Double; x, y, ox, oy: Double; var Nx, Ny: Double);
begin
  Rotate(RotAng, x - ox, y - oy, Nx, Ny);
  Nx := Nx + ox;
  Ny := Ny + oy;
end;
 
 
 
procedure Rotate(RotAng: Double; x, y: Double; var Nx, Ny: Double);
var
  SinVal: Double;
  CosVal: Double;
begin
  RotAng := RotAng * PIDiv180;
  SinVal := Sin(RotAng);
  CosVal := Cos(RotAng);
  Nx := x * CosVal - y * SinVal;
  Ny := y * CosVal + x * SinVal;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
