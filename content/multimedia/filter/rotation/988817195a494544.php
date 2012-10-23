<h1>Вращение изображения</h1>
<div class="date">01.01.2007</div>

<div class="author">https://delphiworld.narod.ru</div>

<p>Вот быстрый и примитивный способ вращения изображения. Должно работать. По крайней мере хоть какой-то выход из-положения, поскольку Windows этого делать не умеет. Но сначала попробуйте на небольший изображениях.</p>
<pre>
procedure RotateRight(BitMap: tImage);
var
  FirstC, LastC, c, r: integer;
 
  procedure FixPixels(c, r: integer);
  var
    SavePix, SavePix2: tColor;
    i, NewC, NewR: integer;
  begin
    SavePix := Bitmap.Canvas.Pixels[c, r];
    for i := 1 to 4 do
    begin
      newc := BitMap.Height - r + 1;
      newr := c;
      SavePix2 := BitMap.Canvas.Pixels[newc, newr];
      Bitmap.Canvas.Pixels[newc, newr] := SavePix;
      SavePix := SavePix2;
      c := Newc;
      r := NewR;
    end;
  end;
 
begin
  if BitMap.Width &lt;&gt; BitMap.Height then
    exit;
  BitMap.Visible := false;
  with Bitmap.Canvas do
  begin
    firstc := 0;
    lastc := BitMap.Width;
    for r := 0 to BitMap.Height div 2 do
    begin
      for c := firstc to lastc do
      begin
        FixPixels(c, r);
      end;
      inc(FirstC);
      Dec(LastC);
    end;
  end;
  BitMap.Visible := true;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />

<div class="author">https://delphiworld.narod.ru</div>

<p>...я думаю над принудительным грубым методом, но его эффективность может быть сомнительна, и не вздумайте пробовать его без сопроцессора! </p>
<p>Сделайте наложение пиксель-на-пиксель из исходного изображение на целевой (используя свойство Canvas.Pixels). Для каждого пикселя осуществите преобразование полярных координат, добавьте компенсирующий угол к полярной координате, затем спозиционируйте это обратно на координаты прямоугольника, и разместите пиксель с новыми координатами на целевом изображении. Также вы можете добавлять какой-либо псевдослучайный пиксель через определенное их количество, если хотите задать какую-то точность вашей операции. </p>
<p>Для преобразования X- и Y-координат объявлены следующие переменные:</p>
<p>X,Y&nbsp;&nbsp;&nbsp; = старые координаты пикселя</p>
<p>X1,Y1&nbsp; = новые координаты пикселя</p>
<p>T&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; = угол вращения (в радианах)</p>
<p>R, A&nbsp;&nbsp; - промежуточные величины, представляющие собой полярные координаты</p>
<p>R = Sqrt(Sqr(X) + Sqr(Y));</p>
<p>A = Arctan(Y/X);</p>
<p>X1 = R * Cos(A+T);</p>
<p>Y1 = R * Sin(A+T);</p>
<p>Я отдаю себе отчет, что это не оптимальное решение, поэтому, если вы найдете еще какое-либо решение, дайте мне знать. В действительности мой метод работает, но делает это очень медленно. </p>
<p>Создайте наложение пиксель-на-пиксель исходного изображение на целевое (используя свойство Canvas.Pixels).</p>
<p>...это хорошее начало, но я думаю другой способ будет немного лучшим. Создайте наложение пиксель-на-пиксель целевого изображения на исходное так, чтобы нам было нужно вычислять откуда брать нужные пиксели, а не думать над тем, куда их нужно поместить. </p>
<p>Для начала вот мой вариант формулы вращения:</p>
<p>x, y = координаты в целевом изображении</p>
<p>t = угол</p>
<p>u, v = координаты в исходном изображении</p>
<p>x = u * cos(t) - v * sin(t)</p>
<p>y = v * cos(t) + u * sin(t)</p>
<p>Теперь, если я захочу решить эти уравнения и вычислить u и v (привести их к правой части уравнения), то формулы будут выглядеть следующим образом (без гарантии, по этой причине я и включил исходные уравнения!):</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; x * cos(t) + y</p>
<p>u = --------------------</p>
<p> &nbsp;&nbsp; sqr(cos(t)) + sin(t)</p>
<p>v =&nbsp;&nbsp; y * cos(t) - x</p>
<p> &nbsp;&nbsp; --------------------</p>
<p> &nbsp;&nbsp; sqr(cos(t)) + sin(t)</p>
<p>Так, подразумевая, что вы уже знаете угол вращения, можно вычислить константы cos(t) и 1/sqr(cos(t))+sin(t) непосредственно перед самим циклом; это может выглядеть примерно так (приблизительный код):</p>
<pre>
ct := cos(t);
ccst := 1/sqr(cos(t))+sin(t);
for x := 0 to width do
 
for y := 0 to height do
dest.pixels[x,y] := source.pixels[Round((x * ct + y) * ccst),
Round((y * ct - x) * ccst)];
</pre>

<p>Если вы хотите ускорить этот процесс, и при этом волнуетесь за накопление ошибки округления, то вам следует обратить внимание на используемую нами технологию: мы перемещаем за один раз один пиксель, дистанция между пикселями равна u, v содержит константу, определяющую колонку с перемещаемым пикселем. Я использую расчитанные выше переменные как рычаг с коротким плечом (с вычисленной длиной и точкой приложения). Просто поместите в (x,y) = (1,0) и (x,y) = (0,1) и уравнение, приведенное выше:</p>
<pre>
duCol := ct * ccst;
dvCol := -ccst;
 
duRow := ccst;
dvRow := ct * ccst;
 
uStart := 0;
vStart := 0;
 
for x := 0 to width do
begin
  u := uStart;
  v := vStart;
  for y := 0 to height do
  begin
    dest.pixels[x, y] := source.pixels[Round(u), Round(v)];
    u := u + rowdu;
    v := v + rowdv;
  end;
  uStart := uStart + duCol;
  vStart := vStart + dvCol;
end;
</pre>

<p>Приведенный выше код можно использовать "как есть", и я не даю никаких гарантий отностительно его использования! </p>
<p>Если вы в душе испытатель, и хотите попробовать вращение вокруг произвольной точки, попробуйте поиграться со значенияим u и v:</p>
<p>Xp, Yp (X-sub-p, Y-sub-p) точка оси вращения, другие константы определены выше</p>
<p>x = Xp + (u - Xp) * cos(t) - (y - Yp) * sin(t)</p>
<p>y = Yp + (y - Yp) * cos(t) - (x - Xp) * sin(t)</p>
<p>Оригинальные уравнения:</p>
<p>  x = u * cos(t) - v * sin(t)</p>
<p>  y = v * cos(t) + u * sin(t)</p>
<p>верны, но когда я решаю их для u и v, я получаю это:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; x * cos(t) + y * sin(t)</p>
<p>  u = -----------------------</p>
<p> &nbsp;&nbsp;&nbsp; sqr(cos(t)) + sqr(sin(t))</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; y * cos(t) - x * sin(t)</p>
<p>  v = ------------------------</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; sqr(cos(t)) + sqr(sin(t))</p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />

<div class="date">02.06.2002</div>
<div class="author">Федоровских Николай</div>

<pre>
{**** UBPFD *********** by delphibase.endimus.ru ****
&gt;&gt; Вращение изображения на заданный угол
 
Зависимости: Windows, Classes, Graphics
Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
Copyright:   Автор Федоровских Николай
Дата:        2 июня 2002 г.
**************************************************** }
 
procedure RotateBitmap(Bitmap: TBitmap; Angle: Double; BackColor: TColor);
type TRGB = record
       B, G, R: Byte;
     end;
     pRGB = ^TRGB;
     pByteArray = ^TByteArray;
     TByteArray = array[0..32767] of Byte;
     TRectList = array [1..4] of TPoint;
 
var x, y, W, H, v1, v2: Integer;
    Dest, Src: pRGB;
    VertArray: array of pByteArray;
    Bmp: TBitmap;
 
  procedure SinCos(AngleRad: Double; var ASin, ACos: Double);
  begin
    ASin := Sin(AngleRad);
    ACos := Cos(AngleRad);
  end;
 
  function RotateRect(const Rect: TRect; const Center: TPoint; Angle: Double): TRectList;
  var DX, DY: Integer;
      SinAng, CosAng: Double;
    function RotPoint(PX, PY: Integer): TPoint;
    begin
      DX := PX - Center.x;
      DY := PY - Center.y;
      Result.x := Center.x + Round(DX * CosAng - DY * SinAng);
      Result.y := Center.y + Round(DX * SinAng + DY * CosAng);
    end;
  begin
    SinCos(Angle * (Pi / 180), SinAng, CosAng);
    Result[1] := RotPoint(Rect.Left, Rect.Top);
    Result[2] := RotPoint(Rect.Right, Rect.Top);
    Result[3] := RotPoint(Rect.Right, Rect.Bottom);
    Result[4] := RotPoint(Rect.Left, Rect.Bottom);
  end;
 
  function Min(A, B: Integer): Integer;
  begin
    if A &lt; B then Result := A
             else Result := B;
  end;
 
  function Max(A, B: Integer): Integer;
  begin
    if A &gt; B then Result := A
             else Result := B;
  end;
 
  function GetRLLimit(const RL: TRectList): TRect;
  begin
    Result.Left := Min(Min(RL[1].x, RL[2].x), Min(RL[3].x, RL[4].x));
    Result.Top := Min(Min(RL[1].y, RL[2].y), Min(RL[3].y, RL[4].y));
    Result.Right := Max(Max(RL[1].x, RL[2].x), Max(RL[3].x, RL[4].x));
    Result.Bottom := Max(Max(RL[1].y, RL[2].y), Max(RL[3].y, RL[4].y));
  end;
 
  procedure Rotate;
  var x, y, xr, yr, yp: Integer;
      ACos, ASin: Double;
      Lim: TRect;
  begin
    W := Bmp.Width;
    H := Bmp.Height;
    SinCos(-Angle * Pi/180, ASin, ACos);
    Lim := GetRLLimit(RotateRect(Rect(0, 0, Bmp.Width, Bmp.Height), Point(0, 0), Angle));
    Bitmap.Width := Lim.Right - Lim.Left;
    Bitmap.Height := Lim.Bottom - Lim.Top;
    Bitmap.Canvas.Brush.Color := BackColor;
    Bitmap.Canvas.FillRect(Rect(0, 0, Bitmap.Width, Bitmap.Height));
    for y := 0 to Bitmap.Height - 1 do begin
      Dest := Bitmap.ScanLine[y];
      yp := y + Lim.Top;
      for x := 0 to Bitmap.Width - 1 do begin
        xr := Round(((x + Lim.Left) * ACos) - (yp * ASin));
        yr := Round(((x + Lim.Left) * ASin) + (yp * ACos));
        if (xr &gt; -1) and (xr &lt; W) and (yr &gt; -1) and (yr &lt; H) then begin
          Src := Bmp.ScanLine[yr];
          Inc(Src, xr);
          Dest^ := Src^;
        end;
        Inc(Dest);
      end;
    end;
  end;
 
begin
  Bitmap.PixelFormat := pf24Bit;
  Bmp := TBitmap.Create;
  try
    Bmp.Assign(Bitmap);
    W := Bitmap.Width - 1;
    H := Bitmap.Height - 1;
    if Frac(Angle) &lt;&gt; 0.0
      then Rotate
      else
    case Trunc(Angle) of
      -360, 0, 360, 720: Exit;
      90, 270: begin
        Bitmap.Width := H + 1;
        Bitmap.Height := W + 1;
        SetLength(VertArray, H + 1);
        v1 := 0;
        v2 := 0;
        if Angle = 90.0 then v1 := H
                        else v2 := W;
        for y := 0 to H do VertArray[y] := Bmp.ScanLine[Abs(v1 - y)];
        for x := 0 to W do begin
          Dest := Bitmap.ScanLine[x];
          for y := 0 to H do begin
            v1 := Abs(v2 - x)*3;
            with Dest^ do begin
              B := VertArray[y, v1];
              G := VertArray[y, v1+1];
              R := VertArray[y, v1+2];
            end;
            Inc(Dest);
          end;
        end
      end;
      180: begin
        for y := 0 to H do begin
          Dest := Bitmap.ScanLine[y];
          Src := Bmp.ScanLine[H - y];
          Inc(Src, W);
          for x := 0 to W do begin
            Dest^ := Src^;
            Dec(Src);
            Inc(Dest);
          end;
        end;
      end;
      else Rotate;
    end;
  finally
    Bmp.Free;
  end;
end;
 
</pre>

<p>Пример использования:</p>
<pre>
RotateBitmap(FBitmap, 17.23, clWhite);
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />

<div class="author">delphiworld.narod.ru</div>

<pre>
const
  PixelMax = 32768;
 
type
  pPixelArray = ^TPixelArray;
  TPixelArray = array [0..PixelMax-1] of TRGBTriple;
 
procedure RotateBitmap_ads(SourceBitmap: TBitmap;
out DestBitmap: TBitmap; Center: TPoint; Angle: Double);
var
  cosRadians : Double;
  inX : Integer;
  inXOriginal : Integer;
  inXPrime : Integer;
  inXPrimeRotated : Integer;
  inY : Integer;
  inYOriginal : Integer;
  inYPrime : Integer;
  inYPrimeRotated : Integer;
  OriginalRow : pPixelArray;
  Radians : Double;
  RotatedRow : pPixelArray;
  sinRadians : Double;
begin
  DestBitmap.Width := SourceBitmap.Width;
  DestBitmap.Height := SourceBitmap.Height;
  DestBitmap.PixelFormat := pf24bit;
  Radians := -(Angle) * PI / 180;
  sinRadians := Sin(Radians);
  cosRadians := Cos(Radians);
  for inX := DestBitmap.Height-1 downto 0 do
  begin
    RotatedRow := DestBitmap.Scanline[inX];
    inXPrime := 2*(inX - Center.y) + 1;
    for inY := DestBitmap.Width-1 downto 0 do
    begin
      inYPrime := 2*(inY - Center.x) + 1;
      inYPrimeRotated := Round(inYPrime * CosRadians - inXPrime * sinRadians);
      inXPrimeRotated := Round(inYPrime * sinRadians + inXPrime * cosRadians);
      inYOriginal := (inYPrimeRotated - 1) div 2 + Center.x;
      inXOriginal := (inXPrimeRotated - 1) div 2 + Center.y;
      if (inYOriginal &gt;= 0) and (inYOriginal &lt;= SourceBitmap.Width-1) and
      (inXOriginal &gt;= 0) and (inXOriginal &lt;= SourceBitmap.Height-1) then
      begin
        OriginalRow := SourceBitmap.Scanline[inXOriginal];
        RotatedRow[inY] := OriginalRow[inYOriginal]
      end
      else
      begin
        RotatedRow[inY].rgbtBlue := 255;
        RotatedRow[inY].rgbtGreen := 0;
        RotatedRow[inY].rgbtRed := 0
      end;
    end;
  end;
end;
 
{Usage:}
procedure TForm1.Button1Click(Sender: TObject);
var
  Center : TPoint;
  Bitmap : TBitmap;
begin
  Bitmap := TBitmap.Create;
  try
    Center.y := (Image.Height div 2)+20;
    Center.x := (Image.Width div 2)+0;
    RotateBitmap_ads(
    Image.Picture.Bitmap,
    Bitmap,
    Center,
    Angle);
    Angle := Angle + 15;
    Image2.Picture.Bitmap.Assign(Bitmap);
  finally
    Bitmap.Free;
  end;
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />

<div class="author">Автор: Айткулов Павел, http://rax.ru/click?apg67108864.narod.ru/</div>

<p>Здесь я бы хотел рассказать не о том, как работать с DelphiX, OpenGL или Direct, а о том, как можно вращать многогранники с помощью простых действий: moveto и lineto. </p>
<p>Здесь рассмотрим пример вращения куба. Будем рисовать на Canvase (например Listbox). Сначала нарисуем врашающийся квадрат (точнее 2 квадрата и соединим их). Пусть q - угол поворота квадрата, который мы рисуем. Очевидно, что нам надо задать координаты вершин квадрата - a:array [1..5,1..2] of integer. 1..4+1 - количество вершин квадрата (почему +1 будет объяснено позже). 1..2 - координата по X и Y. Кто учился в школе, наверное помнит, что уравнение окружности: X^2+Y^2=R^2, кто хорошо учился в школе, возможно вспомнит уравнение эллипса: (X^2)/(a^2)+ (Y^2)/(b^2)=1. Но это нам не надо. Нам понадобится уравнение эллипса в полярных координатах: x=a*sin(t); y=a*cos(t);t=0..2*PI; (учащиеся университетов и институтов ликуют). </p>
<p>С помощью данного уравнения мы заполняем массив с координатами. </p>

<pre>
for i:=1 to 5 do
begin
  // координата по Х; q+i*pi/2 - угол поворота
  // i-той вершины квадрата.
  a[i,1]:=trunc(80*sin(q+i*pi/2));
  // координата по Y; знак минус - потому что координаты
  // считаются с верхнего левого угла
  a[i,1]:=trunc(-30*cos(q+i*pi/2));
end;
</pre>
<p>Сейчас будем рисовать квадрат: </p>
<pre>
for i:=1 to 4 do
begin
  moveto(100+a[i,1],50+a[i,2]); //Встаем на i-ую точку квадрата.
  lineto(100+a[i+1,1],50+a[i+1,2]); //Рисуем линию к i+1-ой точке.
</pre>
<p>Вот почему array[1..5,1..2], иначе - выход за границы. end; </p>
<p>Затем рисуем второй такой же квадрат, но пониже (или повыше). Соединяем линиями первый со вторым: </p>
<pre>
for i:=1 to 4 do
begin
  moveto(100+a[i,1],50+a[i,2]);
  lineto(100+a[i,1],130+a[i,2]);
end;
</pre>
<p>Осталось очистить Listbox, увеличить q и сделать сначала. Все!!! </p>
<p>Можно также скрывать невидимые линии - когда q находится в определенном интервале. Также можно поизвращаться: повернуть куб в другой плоскости - поворот осей(для тех, кто знает формулу). </p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

<hr />

<div class="author">www.swissdelphicenter.ch</div>

<pre>
function RotateBitmap(var hDIB: HGlobal; radang: Double; clrBack: TColor): Boolean;
 // (c) Copyright original C Code: Code Guru 
var
   lpDIBBits: Pointer;
   lpbi, hDIBResult: PBitmapInfoHeader;
   bpp, nColors, nWidth, nHeight, nRowBytes: Integer;
   cosine, sine: Double;
   x1, y1, x2, y2, x3, y3, minx, miny, maxx, maxy, ti, x, y, w, h: Integer;
   nResultRowBytes, nHeaderSize: Integer;
   i, len: longint;
   lpDIBBitsResult: Pointer;
   dwBackColor: DWORD;
   PtrClr: PRGBQuad;
   RbackClr, GBackClr, BBackClr: Word;
   sourcex, sourcey: Integer;
   mask: Byte;
   PtrByte: PByte;
   dwpixel: DWORD;
   PtrDWord: PDWord;
   hDIBResInfo: HGlobal;
 begin;
   // Get source bitmap info 
  lpbi := PBitmapInfoHeader(GlobalLock(hdIB));
   nHeaderSize := lpbi^.biSize + lpbi^.biClrUsed * SizeOf(TRGBQUAD);
   lpDIBBits := Pointer(Longint(lpbi) + nHeaderSize);
   bpp := lpbi^.biBitCount; // Bits per pixel 
  ncolors := lpbi^.biClrUsed; // Already computed when bitmap was loaded 
  nWidth := lpbi^.biWidth;
   nHeight := lpbi^.biHeight;
   nRowBytes := ((((nWidth * bpp) + 31) and (not 31)) shr 3);
 
   // Compute the cosine and sine only once 
  cosine := cos(radang);
   sine := sin(radang);
 
   // Compute dimensions of the resulting bitmap 
  // First get the coordinates of the 3 corners other than origin 
  x1 := ceil(-nHeight * sine); // Originally floor at all places 
  y1 := ceil(nHeight * cosine);
   x2 := ceil(nWidth * cosine - nHeight * sine);
   y2 := ceil(nHeight * cosine + nWidth * sine);
   x3 := ceil(nWidth * cosine);
   y3 := ceil(nWidth * sine);
 
   minx := min(0, min(x1, min(x2, x3)));
   miny := min(0, min(y1, min(y2, y3)));
   maxx := max(0, max(x1, max(x2, x3)));// added max(0, 
  maxy := max(0, max(y1, max(y2, y3)));// added max(0, 
 
  w := maxx - minx;
   h := maxy - miny;
 
   // Create a DIB to hold the result 
  nResultRowBytes := ((((w * bpp) + 31) and (not 31)) div 8);
   len := nResultRowBytes * h;
   hDIBResInfo := GlobalAlloc(GMEM_MOVEABLE, len + nHeaderSize);
   if hDIBResInfo = 0 then
   begin
     Result := False;
     Exit;
   end;
 
   hDIBResult := PBitmapInfoHeader(GlobalLock(hDIBResInfo));
   // Initialize the header information 
  CopyMemory(hDIBResult, lpbi, nHeaderSize);
   //BITMAPINFO &amp;bmInfoResult = *(LPBITMAPINFO)hDIBResult ; 
  hDIBResult^.biWidth := w;
   hDIBResult^.biHeight := h;
   hDIBResult^.biSizeImage := len;
   lpDIBBitsResult := Pointer(Longint(hDIBResult) + nHeaderSize);
 
   // Get the back color value (index) 
  ZeroMemory(lpDIBBitsResult, len);
   case bpp of
     1:
       begin //Monochrome 
        if (clrBack = RGB(255, 255, 255)) then
           FillMemory(lpDIBBitsResult, len, $ff);
       end;
     4,
     8:
       begin //Search the color table 
        PtrClr := PRGBQuad(Longint(lpbi) + lpbi^.bisize);
         RBackClr := GetRValue(clrBack);
         GBackClr := GetGValue(clrBack);
         BBackClr := GetBValue(clrBack);
         for i := 0 to nColors - 1 do // Color table starts with index 0 
        begin
           if (PtrClr^.rgbBlue = BBackClr) and
             (PtrClr^.rgbGreen = GBackClr) and
             (PtrClr^.rgbRed = RBackClr) then
           begin
             if (bpp = 4) then //if(bpp==4) i = i | i&lt;&lt;4; 
              ti := i or (i shl 4)
             else
               ti := i;
             FillMemory(lpDIBBitsResult, ti, len);
             break;
           end;
           Inc(PtrClr);
         end;// If not match found the color remains black 
      end;
     16:
       begin
         (* When the Compression field is set to BI_BITFIELDS,
         Windows 95 supports
         only the following 16bpp color masks: A 5-5-5 16-bit image, where the blue mask
         is $001F, the green mask is $03E0, and the red mask is $7C00; and a 5-6-5
         16-bit image, where the blue mask is $001F, the green mask is $07E0,
         and the red mask is $F800. *)
         PtrClr := PRGBQuad(Longint(lpbi) + lpbi^.bisize);
         if (PtrClr^.rgbRed = $7c00) then // Check the Red mask 
        begin // Bitmap is RGB555 
          dwBackColor := ((GetRValue(clrBack) shr 3) shl 10) +
             ((GetRValue(clrBack) shr 3) shl 5) +
             (GetBValue(clrBack) shr 3);
         end
         else
         begin // Bitmap is RGB565 
          dwBackColor := ((GetRValue(clrBack) shr 3) shl 11) +
             ((GetRValue(clrBack) shr 2) shl 5) +
             (GetBValue(clrBack) shr 3);
         end;
       end;
     24,
     32:
       begin
         dwBackColor := ((GetRValue(clrBack)) shl 16) or
           ((GetGValue(clrBack)) shl 8) or
           ((GetBValue(clrBack)));
       end;
   end;
 
   // Now do the actual rotating - a pixel at a time 
  // Computing the destination point for each source point 
  // will leave a few pixels that do not get covered 
  // So we use a reverse transform - e.i. compute the source point 
  // for each destination point 
 
  for y := 0 to h - 1 do
   begin
     for x := 0 to w - 1 do
     begin
       sourcex := floor((x + minx) * cosine + (y + miny) * sine);
       sourcey := floor((y + miny) * cosine - (x + minx) * sine);
       if ((sourcex &gt;= 0) and (sourcex &lt; nWidth) and
         (sourcey &gt;= 0) and (sourcey &lt; nHeight)) then
       begin // Set the destination pixel 
        case bpp of
           1:
             begin //Monochrome 
              mask := PByte(Longint(lpDIBBits) +
                 nRowBytes * sourcey +
                 (sourcex div 8))^ and ($80 shr
                 (sourcex mod 8));
               if mask &lt;&gt; 0 then
                 mask := $80 shr (x mod 8);
               PtrByte  := PByte(Longint(lpDIBBitsResult) +
                 nResultRowBytes * y + (x div
                 8));
               PtrByte^ := PtrByte^ and (not ($80 shr (x mod
                 8)));
               PtrByte^ := PtrByte^ or mask;
             end;
           4:
             begin
               if ((sourcex and 1) &lt;&gt; 0) then
                 mask := $0f
               else
                 mask := $f0;
               mask := PByte(Longint(lpDIBBits) +
                 nRowBytes * sourcey +
                 (sourcex div 2))^ and mask;
               if ((sourcex and 1) &lt;&gt; (x and 1)) then
               begin
                 if (mask and $f0) &lt;&gt; 0 then
                   mask := (mask shr 4)
                 else
                   mask := (mask shl 4);
               end;
               PtrByte := PByte(Longint(lpDIBBitsResult) +
                 nResultRowBytes * y + (x div
                 2));
               if ((x and 1) &lt;&gt; 0) then
                 PtrByte^ := PtrByte^ and (not $0f)
               else
                 PtrByte^ := PtrByte^ and (not $f0);
               PtrByte^ := PtrByte^ or Mask;
             end;
           8:
             begin
               mask := PByte(Longint(lpDIBBits) +
                 nRowBytes * sourcey +
                 sourcex)^;
               PtrByte  := PByte(Longint(lpDIBBitsResult) +
                 nResultRowBytes * y + x);
               PtrByte^ := mask;
             end;
           16:
             begin
               dwPixel := PDWord(Longint(lpDIBBits) +
                 nRowBytes * sourcey +
                 sourcex * 2)^;
               PtrDword  := PDWord(Longint(lpDIBBitsResult) +
                 nResultRowBytes * y + x * 2);
               PtrDword^ := Word(dwpixel);
             end;
           24:
             begin
               dwPixel := PDWord(Longint(lpDIBBits) +
                 nRowBytes * sourcey +
                 sourcex * 3)^ and $ffffff;
               PtrDword  := PDWord(Longint(lpDIBBitsResult) +
                 nResultRowBytes * y + x * 3);
               PtrDword^ := PtrDword^ or dwPixel;
             end;
           32:
             begin
               dwPixel := PDWord(Longint(lpDIBBits) +
                 nRowBytes * sourcey +
                 sourcex * 4)^;
               PtrDword := PDWord(Longint(lpDIBBitsResult) +
                 nResultRowBytes * y + x * 4);
               PtrDword^ := dwpixel;
             end;
         end; // Case 
      end
       else
       begin
         // Draw the background color. The background color 
        // has already been drawn for 8 bits per pixel and less 
        case bpp of
           16:
             begin
               PtrDWord := PDWord(Longint(lpDIBBitsResult) +
                 nResultRowBytes * y + x * 2);
               PtrDword^ := Word(dwBackColor);
             end;
           24:
             begin
               PtrDWord := PDWord(Longint(lpDIBBitsResult) +
                 nResultRowBytes * y + x * 3);
               PtrDword^ := PtrDword^ or dwBackColor;
             end;
           32:
             begin
               PtrDWord := PDWord(Longint(lpDIBBitsResult) +
                 nResultRowBytes * y + x * 4);
               PtrDword^ := dwBackColor;
             end;
         end;
       end;
     end;
   end;
   GlobalUnLock(hDIBResInfo);
   GlobalUnLock(hDIB);
   GlobalFree(hDIB);
   hDIB := hDIBResInfo;
   Result := True;
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
