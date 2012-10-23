<h1>Добавление шума</h1>
<div class="date">05.06.2002</div>

<div class="author">Автор: Федоровских Николай</div>

<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Добавление шума в изображение
 
Зависимости: Graphics
Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
Copyright:   Автор Федоровских Николай
Дата:        5 июня 2002 г.
***************************************************** }
 
procedure AddNoise(Bitmap: TBitmap; Amount: Integer; Mono: Boolean);
{Если Mono = False, то точки цветные, иначе - чёрно-белые.
 Процедура взята из библиотеки FastLIB и немного переделана}
 
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
  x, y, i, a: Integer;
  Dest: pRGB;
begin
  Bitmap.PixelFormat := pf24Bit;
  Randomize;
  i := Amount shr 1;
  if Mono then
    for y := 0 to Bitmap.Height - 1 do
    begin
      Dest := Bitmap.ScanLine[y];
      for x := 0 to Bitmap.Width - 1 do
      begin
        a := Random(Amount) - i;
        with Dest^ do
        begin
          r := BLimit(r + a);
          g := BLimit(g + a);
          b := BLimit(b + a);
        end;
        Inc(Dest);
      end;
    end
  else
    for y := 0 to Bitmap.Height - 1 do
    begin
      Dest := Bitmap.ScanLine[y];
      for x := 0 to Bitmap.Width - 1 do
      begin
        with Dest^ do
        begin
          r := BLimit(r + Random(Amount) - i);
          g := BLimit(g + Random(Amount) - i);
          b := BLimit(b + Random(Amount) - i);
        end;
        Inc(Dest);
      end;
    end;
end;
</pre>

<p>Пример использования:</p>
<pre>
AddNoise(FBitmap, 65, False); 
</pre>


