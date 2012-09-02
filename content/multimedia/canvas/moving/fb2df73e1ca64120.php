<h1>Движение окружности</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls;
 
type
  TForm1 = class(TForm)
    Timer1: TTimer;
    procedure FormActivate(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
  x, y: byte; // координаты центра окружности
  dx: byte; // приращение координаты x при движении окружности
 
implementation
 
{$R *.dfm}
 
procedure TForm1.FormActivate(Sender: TObject);
begin
  x := 0;
  y := 10;
  dx := 5;
  timer1.Interval := 50; // период возникновения события OnTimer - 0.5 сек
  form1.canvas.brush.color := form1.color;
end;
 
procedure Ris;
begin
     // стереть окружность
  form1.Canvas.Pen.Color := form1.Color;
  form1.Canvas.Ellipse(x, y, x + 10, y + 10);
 
  x := x + dx;
 
     // нарисовать окружность на новом месте
  form1.Canvas.Pen.Color := clBlack;
  form1.Canvas.Ellipse(x, y, x + 10, y + 10);
end;
 
procedure TForm1.Timer1Timer(Sender: TObject);
begin
  Ris;
end;
 
end.
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

