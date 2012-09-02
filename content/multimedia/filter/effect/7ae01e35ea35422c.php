<h1>Эффект инея</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Эффект 'Иней' (разброс)
 
Зависимости: Classes, Graphics
Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
Copyright:   Собственное написание (Николай федоровских)
Дата:        1 июня 2002 г.
***************************************************** }
 
procedure Disorder(Bitmap: TBitmap; Hor, Ver: Integer; BackColor: TColor);
 
  function RandomInRadius(Num, Radius: Integer): Integer;
  begin
    if Random(2) = 0 then
      Result := Num + Random(Radius)
    else
      Result := Num - Random(Radius);
  end;
 
type
  TRGB = record
    B, G, R: Byte;
  end;
  pRGB = ^TRGB;
var
  x, y, WW, HH, xr, yr: Integer;
  Dest1, Dest2, Src1, Src2: PRGB;
  Bmp: TBitmap;
begin
  Randomize;
  Bitmap.PixelFormat := pf24Bit;
  Bmp := TBitmap.Create;
  try
    Bmp.Assign(Bitmap);
    WW := Bitmap.Width - 1;
    HH := Bitmap.Height - 1;
    Bitmap.Canvas.Brush.Color := BackColor;
    Bitmap.Canvas.FillRect(Rect(0, 0, WW + 1, HH + 1));
    for y := 0 to HH do
    begin
      for x := 0 to WW do
      begin
        xr := RandomInRadius(x, Hor);
        yr := RandomInRadius(y, Ver);
        if (xr &gt;= 0) and (xr &lt; WW) and (yr &gt;= 0) and (yr &lt; HH) then
        begin
          Src1 := Bmp.ScanLine[y];
          Src2 := Bmp.ScanLine[yr];
          Dest1 := Bitmap.ScanLine[y];
          Dest2 := Bitmap.ScanLine[yr];
          Inc(Src1, x);
          Inc(Src2, xr);
          Inc(Dest1, x);
          Inc(Dest2, xr);
          Dest1^ := Src2^;
          Dest2^ := Src1^;
        end;
      end;
    end;
  finally
    Bmp.Free;
  end;
end;
Пример использования: 
 
Disorder(FBitmap, 5, 5, clWhite); 
 
</pre>

