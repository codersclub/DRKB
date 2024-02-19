---
Title: Как нарисовать кривую Безье?
Date: 01.01.2007
Author: Даниил Карапетян, delphi4all@narod.ru
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как нарисовать кривую Безье?
============================

Как нарисовать кривую Безье.
Именно она применяется для построения гладких кривых во всех
графических
программах - от PaintBrush до CorelDraw и PhotoShop. Для задания кривой
Безье n-ной степени (чем больше степень, тем более кривой
может быть линия; кривая первой степени - отрезок) нужно указать n+1
точку. Первая

и последняя точки будут началом и концом кривой, а остальные точки задаю
ее поведение

на других участках. В частности, первая и n-ая точки задают касательные
и кривизну

кривой на ее концах. В большинстве программ используются кривые Безье
третьего

порядка. Начиная с Delphi5 такую кривую можно нарисовать при помощи
функции PolyBezier. Кривая Безье задается параметрически (x=x(t),
y=y(t)). Это позволяет ей вести

себя абсолютно произвольно. Если бы она задавалась, как y(x), она не
смогла бы

даже сделать поворот на 180 градусов. Функции x(t) и y(t) выглядят так:

x(t)= Cn0 * t0 * (1-t)n * x0 + Cn1 * t1 * (1-t)n-1 * x1 + Cn2 *
t2 * (1-t)n-2

* x2 + ... + Cnn * tn * (1-t)0 * xn

y(t)= Cn0 * t0 * (1-t)n * y0 + Cn1 * t1 * (1-t)n-1 * y1 + Cn2 *
t2 * (1-t)n-2

* y2 + ... + Cnn * tn * (1-t)0 * yn

где n - порядок кривой, Cni - коэффициенты в разложении бинома Ньютона,
t - параметр,

меняющийся от 0 до 1, xi, yi - координаты опорных точек. Эта программа
строит кривую Безье n-ного порядка. n задается в SpinEdit1. Все

узлы можно перемещать по полю мышью. Для создания нового узла нужно
нажать мышью

на пустое место на поле или увеличить порядок кривой. Скачать
необходимые для компиляции файлы проекта можно на
<https://program.dax.ru/>.

    uses Math; 
    const
    RectSize = 5;
    MaxN = 128; 
    var
    n: integer = -1;
    pt: array [0..MaxN] of TPoint;
    C: array [0..MaxN] of single;
    bm: TBitMap; 
    function GetBinomialCoefficient(m, i: integer): single;
    function Factorial(x: integer): double;
    var i: integer;
    begin
    result := 1;
    for i := 2 to x do result := result * i;
    end;
    begin
    result := Factorial(m) / (Factorial(i) * Factorial(m - i));
    end; 
    procedure DrawBezier(Canvas: TCanvas; Count: integer);
    type
    TPointArray = array [word] of TPoint;
    PPointArray = ^TPointArray; 
    var
    p: PPointArray;
    Step, qx, qy, t, q: single;
    i, j: integer;
    begin
    GetMem(p, sizeof(TPoint) * (Count + 1));
    Step := 1.0 / Count;
    for i := 0 to Count do 
    begin
    t := i * Step;
    qx := 0; qy := 0;
    for j := 0 to n do 
    begin
    q := C[j] * IntPower(1 - t, j) * IntPower(t, n - j);
    qx := qx + q * pt[j].x;
    qy := qy + q * pt[j].y;
    end;
    p[i] := Point(round(qx), round(qy));
    end; 
    Canvas.Polyline(Slice(p^, Count + 1));
    FreeMem(p);
    end; 
    procedure DrawLines(canvas: TCanvas; const pt: array of TPoint);
    var
    i: integer;
    begin
    Canvas.Pen.Color := clGreen;
    Canvas.Pen.Width := 1;
    Canvas.MoveTo(pt[0].x, pt[0].y);
    for i := 0 to n do 
    begin
    Canvas.Rectangle(Bounds(pt[i].x - RectSize, pt[i].y - RectSize,
    2 * RectSize, 2 * RectSize));
    Canvas.LineTo(pt[i].x, pt[i].y);
    end;
    end; 
    procedure Redraw;
    begin
    with Form1.PaintBox1 do 
    begin
    bm.Canvas.FillRect(Bounds(0, 0, Width, Height));
    if Form1.CheckBox1.Checked then DrawLines(bm.Canvas, pt);
    bm.Canvas.PolyBezier(pt);
    bm.Canvas.Pen.Color := clRed;
    bm.Canvas.pen.Width := Form1.SpinEdit3.Value;
    DrawBezier(bm.Canvas, Form1.SpinEdit2.Value);
    Canvas.Draw(0, 0, bm);
    end;
    end; 
    var
    moving: integer = -1;
    oldr: TRect; 
     
    procedure FillRandom(NewN: integer);
    var
    i: integer;
    begin
    randomize;
    for i := n+1 to NewN do pt[i] := Point(random(Form1.PaintBox1.Width - 20) + 10,
    random(Form1.PaintBox1.Height - 20) + 10);
    n := NewN;
    end; 
    procedure TForm1.FormCreate(Sender: TObject);
    begin
    bm := TBitmap.Create;
    bm.Width := PaintBox1.Width;
    bm.Height := PaintBox1.height; SpinEdit1.MinValue := 1;
    SpinEdit1.MaxValue := MaxN;
    SpinEdit1.Value := 3; SpinEdit2.MinValue := 6;
    SpinEdit2.MaxValue := MaxN * 4;
    SpinEdit2.Value := 50;
    SpinEdit2.OnChange := PaintBox1.OnPaint; SpinEdit3.MinValue := 1;
    SpinEdit3.MaxValue := 8;
    SpinEdit3.Value := 3;
    SpinEdit3.OnChange := PaintBox1.OnPaint; CheckBox1.Checked := true;
    CheckBox1.OnClick := PaintBox1.OnPaint;
    end; 
    procedure TForm1.PaintBox1MouseDown(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    var
    i: integer;
    r: TRect;
    begin
    if Button <> mbLeft then Exit;
    for i := 0 to n do
    if (abs(X - pt[i].x) <= RectSize) and (abs(Y - pt[i].y) <= RectSize) then 
    begin
    moving := i;
    r.TopLeft := Form1.ClientToScreen(PaintBox1.BoundsRect.TopLeft);
    r.BottomRight := Form1.ClientToScreen(PaintBox1.BoundsRect.BottomRight);
    GetClipCursor(oldr);
    ClipCursor(@r);
    Exit;
    end;
    if moving < 0 then 
    begin
    SpinEdit1.Value := SpinEdit1.Value + 1;
    pt[n] := Point(X, Y);
    Redraw;
    end;
    end; 
    procedure TForm1.PaintBox1MouseMove(Sender: TObject; Shift: TShiftState; X, Y: Integer);
    begin
    if moving < 0 then Exit;
    pt[moving] := Point(X, Y);
    Redraw;
    end; 
    procedure TForm1.PaintBox1MouseUp(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    begin
    if (Button = mbLeft) and (moving >= 0) then 
    begin
    moving := -1;
    ClipCursor(@oldr);
    end;
    end; 
    procedure TForm1.SpinEdit1Change(Sender: TObject);
    var
    i: integer;
    begin
    FillRandom(SpinEdit1.Value);
    SpinEdit2.MinValue := n * 2;
    for i := 0 to n do C[i] := GetBinomialCoefficient(n, i);
    Redraw;
    end;
    procedure TForm1.PaintBox1Paint(Sender: TObject);
    begin
    Redraw;
    end; 

Даниил Карапетян.

На сайте <https://delphi4all.narod.ru> Вы найдете еще более 100 советов
по Delphi.

Email: <delphi4all@narod.ru>

