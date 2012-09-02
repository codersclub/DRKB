<h1>Замена всех цветов на оттенки одного</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Замена всех цветов на оттенки одного
 
Зависимости: Graphics
Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
Copyright:   Собственное написание (Николай федоровских)
Дата:        1 июня 2002 г.
***************************************************** }
 
procedure ModColors(Bitmap: TBitmap; Color: TColor);
  function GetR(const Color: TColor): Byte;
    //извлечение красного
  begin
    Result := Lo(Color);
  end;
  function GetG(const Color: TColor): Byte;
    //извлечение зелёного
  begin
    Result := Lo(Color shr 8);
  end;
  function GetB(const Color: TColor): Byte;
    //извлечение синего
  begin
    Result := Lo((Color shr 8) shr 8);
  end;
 
  function BLimit(B: Integer): Byte;
  begin
    if B &lt; 0 then
      Result := 0
    else if B &gt; 255 then
      Result := 255
    else
      Result := B;
  end;
 
type
  TRGB = record
    B, G, R: Byte;
  end;
  pRGB = ^TRGB;
var
  r1, g1, b1: Byte;
  x, y: Integer;
  Dest: pRGB;
  A: Double;
begin
  Bitmap.PixelFormat := pf24Bit;
  r1 := Round(255 / 100 * GetR(Color));
  g1 := Round(255 / 100 * GetG(Color));
  b1 := Round(255 / 100 * GetB(Color));
  for y := 0 to Bitmap.Height - 1 do
  begin
    Dest := Bitmap.ScanLine[y];
    for x := 0 to Bitmap.Width - 1 do
    begin
      with Dest^ do
      begin
        A := (r + b + g) / 300;
        with Dest^ do
        begin
          R := BLimit(Round(r1 * A));
          G := BLimit(Round(g1 * A));
          B := BLimit(Round(b1 * A));
        end;
      end;
      Inc(Dest);
    end;
  end;
end;
Пример использования: 
ModColors(FBitmap, RGB(218, 219, 230)); 
</pre>

