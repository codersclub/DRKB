---
Title: Рисуем график функции в Delphi
Author: Baa
Date: 01.01.2007
---


Рисуем график функции в Delphi
==============================

Вариант 1.

Рисуем график функции в Delphi

В этой статье мы рассмотрим несколько способов нарисовать график
какой-нибудь функции. Рисовать график мы будем на канве компонента
Image.

Рисование по пикселам

Рисовать на канве можно разными способами. Первый вариант - рисовать по
пикселям. Для этого используется свойство канвы Pixels. Это свойство
представляет собой двумерный массив, который отвечает за цвета канвы.
Например Canvas.Pixels[10,20] - соответствует цвету пикселя с
координатами (10,20). С массивом пикселей можно обращаться, как с любым
свойством: изменять цвет, задавая пикселю новое значение, или определять
его цвет, по хранящемуся в нем значению. На примере ниже мы зададим
черный цвет пикселю с координатами (10,20):

    Canvas.Pixels[10,20]:=clBlack;

Теперь мы попробуем нарисовать график функции F(x), если известен
диапазон ее изменений Ymax и Ymin, и диапазон изменения аргумента Xmax и
Xmin. Для этого мы напишем пользовательскую функцию, которая будет
вычислять значение функции F в точке x, а также будет возвращать
максимум и минимум функции и ее аргумента.

    function Tform1.F(x:real; var Xmax,Xmin,Ymax,Ymin:real):real;
    Begin
    F:=Sin(x);
    Xmax:=4*pi;
    Xmin:=0;
    Ymax:=1;
    Ymin:=-1;
    End; 

Не забудьте также указать заголовок этой функциии в разделе Public:

    public
    { Public declarations } 
    function F(x:real; var Xmax,Xmin,Ymax,Ymin:real):real; 

Здесь для ясности мы просто указали диапазон изменения функции Sin(x) и
ее аргумента, ниже эта функция будет описана целиком. Параметры Xmax,
Xmin, Ymax, Ymin - описаны со словом Var потому что они являются
входными-выходными, т.е. через них функция будет возвращать значения
вычислений этих данных в основную программу. Поэтому надо объявить Xmax,
Xmin, Ymax, Ymin как глобальные переменные в разделе Implementation:

    implementation
    var Xmax,Xmin,Ymax,Ymin:real;

Теперь поставим на форму кнопку и в ее обработчике события OnClick
напишем следующий код:

    procedure TForm1.Button1Click(Sender: TObject);
    var x,y:real;
    PX,PY:longInt;
    begin
    for PX:=0 to Image1.Width do
    begin
    x:=Xmin+PX*(Xmax-Xmin)/Image1.Width;
    y:=F(x,Xmax,Xmin,Ymax,Ymin);
    PY:=trunc(Image1.Height-(y-Ymin)*Image1.height/(Ymax-Ymin));
    image1.Canvas.Pixels[PX,PY]:=clBlack;
    end;
    end; 

В этом коде вводятся переменные x и y, являющиеся значениями аргумента и
функции, а также переменные PX и PY, являющиеся координатами пикселей,
соответствующих x и y. Сама процедура состоит из цикла по всем значениям
горизонтальной координаты пикселей PX компонента Image1. Сначала
выбранное значение PX пересчитывается в соответствующее значение x.
Затем производится вызов функции F(x) и определяется ее значение Y. Это
значение пересчитывается в вертикальную координату пикселя PY

Рисование с помощью пера Pen

У канвы имеется свойство Pen - перо. Это объект в свою очередь имеющий
ряд свойств. Одно из них свойство Color - цвет, которым наносится
рисунок. Второе свойство Width - ширина линии, задается в пикселах (по
умолчанию 1).

Свойство Style определяет вид линии и может принимать следующие
значения:

    --------------- ----------------------------------------------
    psSolid         Сплошная линия
    psDash          Штриховая линия
    psDot           Пунктирная линия
    psDashDot       Штрих пунктирная линия
    psDashDotDot    Линия, чередующая штрих и два пунктира
    psClear         Отсутствие линии
    psInsideFrame   Сплошная линия, но при Width \> 1
                    допускающая цвета, отличные от палитры Windows
    --------------- ----------------------------------------------

Все стили со штрихами и пунктирами доступны только при толщине линий
равной 1. Иначе эти линии рисуются как сплошные.

У канвы имеется свойство PenPos, типа TPoint. Это свойство определяет в
координатах канвы текущую позицию пера. Перемещение пера без прорисовки
осуществляется методом MoveTo(x,y). После вызова этого метода канвы
точка с координатами (x,y) становится исходной, от которой методом
LineTo(x,y) можно провести линию, в любую точку с координатами (x,y).

Давайте теперь попробуем нарисовать график синуса пером. Для этого
добавим перед циклом оператор:

    Image1.Canvas.MoveTo(0,Image1.height div 2);

А перед заключительным end цикла добавьте следующий оператор:

    Image1.Canvas.LineTo(PX,PY);

Таким образом у Вас должен получиться такой код:

    procedure TForm1.Button1Click(Sender: TObject);
    var x,y:real;
    PX,PY:longInt;
    begin
    Image1.Canvas.MoveTo(0,Image1.height div 2);
    for PX:=0 to Image1.Width do
    begin
    x:=Xmin+PX*(Xmax-Xmin)/Image1.Width;
    y:=F(x,Xmax,Xmin,Ymax,Ymin);
    PY:=trunc(Image1.Height-(y-Ymin)*Image1.height/(Ymax-Ymin));
    image1.Canvas.Pixels[PX,PY]:=clBlack;
    Image1.Canvas.LineTo(PX,PY);
    end;
    end;

Как Вы уже успели заметить, если запустили программу, качество рисования
графика пером, намного лучше, чем рисования по пикселям.

Как обещал сейчас напишу пример программы которая находит максимум и
минимум функции. Я маленько изменил структуру процедур и функций, чтобы
было яснее. Вот готовый код программы:

    ...
    type
    TForm1 = class(TForm)
    Button1: TButton;
    Image1: TImage;
    procedure Button1Click(Sender: TObject);
    private
    { Private declarations }
    public
    function F(x:real):real;
    Procedure Extrem1(Xmax,Xmin:real; Var Ymin:real);
    Procedure Extrem2(Xmax,Xmin:real; Var Ymax:real);
    { Public declarations }
    end;
     
    var
    Form1: TForm1;
     
    implementation
    Const e=1e-4;//точность одна тысячная
    var Xmax,Xmin,Ymax,Ymin:real;
    {$R *.DFM}
    function Tform1.F(x:real):real;
    Begin
    F:=Sin(x);
    End;
     
    //поиск минимума функции
    Procedure TForm1.Extrem1(Xmax,Xmin:real; Var Ymin:real);
    Var x,h:real; j,n:integer;
    Begin
    n:=10;
    Repeat
    x:=Xmin;
    n:=n*2;
    h:=(Xmax-Xmin)/n;
    Ymin:=F(Xmin);
    For j:=1 to n do begin
    if f(x)<Ymin then Ymin:=f(x);
    x:=x+h;
    end;
    Until abs(f(Ymin)-f(Ymin+h))<e;
    End;
     
    //поиск максимума функции
    Procedure TForm1.Extrem2(Xmax,Xmin:real; Var Ymax:real);
    Var x,h:real; j,n:integer;
    Begin
    n:=10;
    Repeat
    x:=Xmin;
    n:=n*2;
    h:=(Xmax-Xmin)/n;
    Ymax:=F(Xmin);
    For j:=1 to n do begin
    if f(x)>=Ymax then Ymax:=f(x);
    x:=x+h;
    end;
    Until abs(f(Ymax)-f(Ymax+h))<e;
    End;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    var x,y:real;
    PX,PY:longInt;
    begin
    //здесь необходимо указать диапазон изменения x
    Xmax:=8*pi;
    Xmin:=0;
     
    //вычисляем экстремумы функции
    Extrem1(Xmax,Xmin,Ymin);
    Extrem2(Xmax,Xmin,Ymax);
     
    //рисуем график функции
    Image1.Canvas.MoveTo(0,Image1.height div 2);
    for PX:=0 to Image1.Width do
    begin
    x:=Xmin+PX*(Xmax-Xmin)/Image1.Width;
    y:=F(x);
    PY:=trunc(Image1.Height-(y-Ymin)*Image1.height/(Ymax-Ymin));
    image1.Canvas.Pixels[PX,PY]:=clBlack;
    Image1.Canvas.LineTo(PX,PY);
    end;
    end;
    end.

Ну вот и все, надеюсь эта статья оказалась Вам интересна!

Источник: <https://delphid.dax.ru>

 

------------------------------------------------------------------------

Вариант 2.

    procedure TForm1.Button3Click(Sender: TObject);
    var
      x, y: array[1..50] of double;
      i: integer;
      scalex, scaley, ymin, ymax, xmin, xmax: double;
    begin
      for i := 1 to 50 do
      begin
        y[i] := sin(i * 0.5);
        x[i] := i;
      end;
      xmin := x[1];
      xmax := x[1];
      ymin := y[1];
      ymax := y[1];
      for i := 2 to 50 do
      begin // ??? ??????????? ymin:=MinValue(y); ? ?.?.
        if y[i] < ymin then
          ymin := y[i];
        if y[i] > ymax then
          ymax := y[i];
        if x[i] < xmin then
          xmin := x[i];
        if x[i] > xmax then
          xmax := x[i];
      end;
      scalex := paintbox1.Width / (xmax - xmin);
      scaley := paintbox1.Height / (ymax - ymin);
      with paintbox1.canvas do
      begin
        moveto(trunc(scalex * (x[1] - xmin)), paintbox1.height - trunc(scaley * (y[1]
          - ymin)));
        for i := 2 to 50 do
          Lineto(trunc(scalex * (x[i] - xmin)), paintbox1.height - trunc(scaley *
            (y[i] - ymin)));
      end;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Вариант 3.

Автор: Baa

Забавная штука синусы:

    for i := 1 to 500 do
      paintbox1.Canvas.Pixels[round(sin(i * 5) * 10 + 50), round(sin(i * 10) * 10 +
        50)] := RGB(0, 0, 0);

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Вариант 4.

    unit grfunc_;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs;
     
    type
      TForm1 = class(TForm)
        procedure FormPaint(Sender: TObject);
        procedure FormResize(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    // Функция, график которой надо построить
     
    function f(x: real): real;
    begin
      f := 2 * Sin(x) * exp(x / 5);
    end;
     
    // строит график функции
     
    procedure GrOfFunc;
    var
      x1, x2: real; // границы изменения аргумента функции
      y1, y2: real; // границы изменения значения функции
      x: real; // аргумент функции
      y: real; // значение функции в точке x
      dx: real; // приращение аргумента
      l, b: integer; // левый нижний угол области вывода графика
      w, h: integer; // ширина и высота области вывода графика
      mx, my: real; // масштаб по осям X и Y
      x0, y0: integer; // точка - начало координат
     
    begin
     // область вывода графика
      l := 10; // X - координата левого верхнего угла
      b := Form1.ClientHeight - 20; // Y - координата левого верхнего угла
      h := Form1.ClientHeight - 40; // высота
      w := Form1.Width - 40; // ширина
     
      x1 := 0; // нижняя граница диапазона аргумента
      x2 := 25; // верхняя граница диапазона аргумента
      dx := 0.01; // шаг аргумента
     
     // найдем максимальное и минимальное значения
     //  функции на отрезке [x1,x2]
      y1 := f(x1); // минимум
      y2 := f(x1); // максимум
      x := x1;
      repeat
        y := f(x);
        if y < y1 then y1 := y;
        if y > y2 then y2 := y;
        x := x + dx;
      until (x >= x2);
     
     // вычислим масштаб
      my := h / abs(y2 - y1); // масштаб по оси Y
      mx := w / abs(x2 - x1); // масштаб по оси X
     
     // оси
      x0 := l;
      y0 := b - Abs(Round(y1 * my));
     
      with form1.Canvas do
      begin
       // оси
        MoveTo(l, b); LineTo(l, b - h);
        MoveTo(x0, y0); LineTo(x0 + w, y0);
        TextOut(l + 5, b - h, FloatToStrF(y2, ffGeneral, 6, 3));
        TextOut(l + 5, b, FloatToStrF(y1, ffGeneral, 6, 3));
       // построение графика
        x := x1;
        repeat
          y := f(x);
          Pixels[x0 + Round(x * mx), y0 - Round(y * my)] := clRed;
          x := x + dx;
        until (x >= x2);
     
        TextOut(17, 100, 'Delphi World Example');
      end;
    end;
     
     
    procedure TForm1.FormPaint(Sender: TObject);
    begin
      GrOfFunc;
    end;
     
    // изменился размер окна программы
     
    procedure TForm1.FormResize(Sender: TObject);
    begin
      // очистить форму
      form1.Canvas.FillRect(Rect(0, 0, ClientWidth, ClientHeight));
      // построить график
      GrOfFunc;
    end;
     
    end.
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Вариант 4.

    unit TestGrF;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls, DdhGraph;
     
    type
      TForm1 = class(TForm)
        ColorDialog1: TColorDialog;
        FontDialog1: TFontDialog;
        Image1: TImage;
        Panel1: TPanel;
        Button1: TButton;
        Button2: TButton;
        CheckBox1: TCheckBox;
        Button3: TButton;
        DdhGraph1: TDdhGraph;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        procedure CheckBox1Click(Sender: TObject);
        procedure Button3Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ColorDialog1.Color := DdhGraph1.Color;
      if ColorDialog1.Execute then
        DdhGraph1.Color := ColorDialog1.Color;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      FontDialog1.Font := DdhGraph1.Font;
      if FontDialog1.Execute then
        DdhGraph1.Font := FontDialog1.Font;
    end;
     
    procedure TForm1.CheckBox1Click(Sender: TObject);
    begin
      if CheckBox1.Checked then
        DdhGraph1.BorderStyle := bsSingle
      else
        DdhGraph1.BorderStyle := bsNone;
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      ColorDialog1.Color := DdhGraph1.LinesColor;
      if ColorDialog1.Execute then
        DdhGraph1.LinesColor := ColorDialog1.Color;
    end;
     
    end.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
