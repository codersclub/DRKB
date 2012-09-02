<h1>Как сделать 24bit dithering?</h1>
<div class="date">01.01.2007</div>


<pre>
{ ... }
type
  PIntegerArray = ^TIntegerArray;
  TIntegerArray = array[0..maxInt div sizeof(integer) - 2] of integer;
  TColor3 = packed record
    b, g, r: byte;
  end;
  TColor3Array = array[0..maxInt div sizeof(TColor3) - 2] of TColor3;
  PColor3Array = ^TColor3Array;
 
procedure Swap(var p1, p2: PIntegerArray);
var
  t: PIntegerArray;
begin
  t := p1;
  p1 := p2;
  p2 := t;
end;
 
function clamp(x, min, max: integer): integer;
begin
  result := x;
  if result &lt; min then
    result := min;
  else
    if result &gt; max then
      result := max;
end;
 
procedure Dither(bmpS, bmpD: TBitmap);
var
  bmpS, bmpD: TBitmap;
  scanlS, scanlD: PColor3Array;
  error1R, error1G, error1B,
    error2R, error2G, error2B: PIntegerArray;
  x, y: integer;
  dx: integer;
  c, cD: TColor3;
  sR, sG, sB: integer;
  dR, dG, dB: integer;
  eR, eG, eB: integer;
begin
  bmpD.Width := bmpS.Width;
  bmpD.Height := bmpS.Height;
  bmpS.PixelFormat := pf24bit;
  bmpD.PixelFormat := pf24bit;
  error1R := AllocMem((bmpS.Width + 2) * sizeof(integer));
  error1G := AllocMem((bmpS.Width + 2) * sizeof(integer));
  error1B := AllocMem((bmpS.Width + 2) * sizeof(integer));
  error2R := AllocMem((bmpS.Width + 2) * sizeof(integer));
  error2G := AllocMem((bmpS.Width + 2) * sizeof(integer));
  error2B := AllocMem((bmpS.Width + 2) * sizeof(integer));
  {dx holds the delta for each iteration as we zigzag, it'll change between 1 and -1}
  dx := 1;
  for y := 0 to bmpS.Height - 1 do
  begin
    scanlS := bmpS.ScanLine[y];
    scanlD := bmpD.ScanLine[y];
    if dx &gt; 0 then
      x := 0
    else
      x := bmpS.Width - 1;
    while (x &gt;= 0) and (x &lt; bmpS.Width) do
    begin
      c := scanlS[x];
      sR := c.r;
      sG := c.g;
      sB := c.b;
      eR := error1R[x + 1];
      eG := error1G[x + 1];
      eB := error1B[x + 1];
      dR := (sR * 16 + eR) div 16;
      dG := (sR * 16 + eR) div 16;
      dB := (sR * 16 + eR) div 16;
      {actual downsampling}
      dR := clamp(dR, 0, 255) and (255 shl 4);
      dG := clamp(dR, 0, 255) and (255 shl 4);
      dB := clamp(dR, 0, 255) and (255 shl 4);
      cD.r := dR;
      cD.g := dG;
      cD.b := dB;
      scanlD[x] := cD;
      eR := sR - dR;
      eG := sG - dG;
      eB := sB - dB;
      inc(error1R[x + 1 + dx], (eR * 7)); {next}
      inc(error1G[x + 1 + dx], (eG * 7));
      inc(error1B[x + 1 + dx], (eB * 7));
      inc(error2R[x + 1], (eR * 5)); {top}
      inc(error2G[x + 1], (eG * 5));
      inc(error2B[x + 1], (eB * 5));
      inc(error2R[x + 1 + dx], (eR * 1)); {diag forward}
      inc(error2G[x + 1 + dx], (eG * 1));
      inc(error2B[x + 1 + dx], (eB * 1));
      inc(error2R[x + 1 - dx], (eR * 3)); {diag backward}
      inc(error2G[x + 1 - dx], (eG * 3));
      inc(error2B[x + 1 - dx], (eB * 3));
      inc(x, dx);
    end;
    dx := dx * -1;
    Swap(error1R, error2R);
    Swap(error1G, error2G);
    Swap(error1B, error2B);
    FillChar(error2R^, sizeof(integer) * (bmpS.Width + 2), 0);
    FillChar(error2G^, sizeof(integer) * (bmpS.Width + 2), 0);
    FillChar(error2B^, sizeof(integer) * (bmpS.Width + 2), 0);
  end;
  FreeMem(error1R);
  FreeMem(error1G);
  FreeMem(error1B);
  FreeMem(error2R);
  FreeMem(error2G);
  FreeMem(error2B);
end;
</pre>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

