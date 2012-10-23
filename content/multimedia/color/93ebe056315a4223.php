<h1>Как преобразовать цвет в оттенки серого?</h1>
<div class="date">01.01.2007</div>


<p>Следущий пример показывает, как преобразовать RGB цвет в аналогичный оттенок серого, наподобие того, как это делает чёрно-белый телевизор:</p>
<pre>
function RgbToGray(RGBColor : TColor) : TColor;
var
  Gray : byte;
begin
  Gray := Round((0.30 * GetRValue(RGBColor)) +
                (0.59 * GetGValue(RGBColor)) +
                (0.11 * GetBValue(RGBColor )));
  Result := RGB(Gray, Gray, Gray);
end;
</pre>

<p>Пример</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
begin
  Shape1.Brush.Color := RGB(255, 64, 64);
  Shape2.Brush.Color := RgbToGray(Shape1.Brush.Color);
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<pre>
// Используется функция преобразования изображения в оттенки серого
  // взятая из UBPFD - http://delphibase.endimus.com/
  // автор: Николай Федоровских - mailto: chook_nu@uraltc.ru
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
      if B &lt; 0 then Result := 0
        else if B &gt; 255 then Result := 255
          else Result := B;
    end;
  type TRGB = record
         B, G, R: Byte;
       end;
       pRGB = ^TRGB;
  var r1, g1, b1: Byte;
      x, y: Integer;
      Dest: pRGB;
      A: Double;
  begin
    Bitmap.PixelFormat := pf24Bit;
    r1 := Round(255 / 100 * GetR(Color));
    g1 := Round(255 / 100 * GetG(Color));
    b1 := Round(255 / 100 * GetB(Color));
    for y := 0 to Bitmap.Height - 1 do begin
      Dest := Bitmap.ScanLine[y];
      for x := 0 to Bitmap.Width - 1 do begin
        with Dest^ do begin
          A := (r + b + g) / 300;
          with Dest^ do begin
            R := BLimit(Round(r1 * A));
            G := BLimit(Round(g1 * A));
            B := BLimit(Round(b1 * A));
            // Небольшая поправка к оригинальной функции
            if (R=255) and (G=255) and (B=255) then begin
              R:= 216;
              G:= 212;
              B:= 240;
            end;
          end;
        end;
        Inc(Dest);
      end;
    end;
  end;
</pre>
&nbsp;<br>
<p>пример использования:</p>
<pre>
ModColors(BitMap, RGB(150,150,150));
</pre>

<div class="author">Автор: Rouse_ </div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
