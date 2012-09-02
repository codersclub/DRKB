<h1>Самолет летит по небу</h1>
<div class="date">01.01.2007</div>


<pre>
unit aplane_;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  ExtCtrls, StdCtrls, Buttons;
 
type
  TForm1 = class(TForm)
    Timer1: TTimer;
    Image1: TImage;
    procedure FormActivate(Sender: TObject);
    procedure Timer1Timer(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
var
  Back, bitmap, Buf: TBitMap; // фон, картинка, буфер
  BackRct: TRect; // область фона, которая должна быть
  // восстановлена из буфера
  BufRct: Trect; // область буфера, которая используется для
  // восстановления фона
 
  x, y: integer; // текущее положение картинки
  W, H: integer; // размеры картинки
 
procedure TForm1.FormActivate(Sender: TObject);
begin
  // создать три объекта - битовых образа
  Back := TBitmap.Create; // фон
  bitmap := TBitmap.Create; // картинка
  Buf := TBitmap.Create; // буфер
 
  // загрузить и вывести фон
  Back.LoadFromFile('factory.bmp');
  Form1.Image1.canvas.Draw(0, 0, Back);
 
  // загрузить картинку, которая будет двигаться
  bitmap.LoadFromFile('aplane.bmp');
  // определим "прозрачный" цвет
  bitmap.Transparent := True;
  bitmap.TransParentColor := bitmap.canvas.pixels[1, 1];
 
  // создать буфер для сохранения копии области фона,
  // на которую накладывается картинка
  W := bitmap.Width;
  H := bitmap.Height;
  Buf.Width := W;
  Buf.Height := H;
  Buf.Palette := Back.Palette; // Чтобы обеспечить соответствие палитр !!
  Buf.Canvas.CopyMode := cmSrcCopy;
  // определим область буфера, которая будет использоваться
  // для восстановления фона
  BufRct := Bounds(0, 0, W, H);
 
  // начальное положение картинки
  x := -W;
  y := 20;
 
  // определим сохраняемую область фона
  BackRct := Bounds(x, y, W, H);
  // и сохраним ее
  Buf.Canvas.CopyRect(BufRct, Back.Canvas, BackRct);
end;
 
// обработка сигнала таймера
 
procedure TForm1.Timer1Timer(Sender: TObject);
begin
  // восстановлением фона (из буфера) удалим рисунок
  Form1.image1.canvas.Draw(x, y, Buf);
 
  x := x + 2;
  if x &gt; form1.Image1.Width then
    x := -W;
 
  // определим сохраняемую область фона
  BackRct := Bounds(x, y, W, H);
  // сохраним ее копию
  Buf.Canvas.CopyRect(BufRct, Back.Canvas, BackRct);
 
  // выведем рисунок
  Form1.image1.canvas.Draw(x, y, bitmap);
end;
 
// завершение работы программы
 
procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
  // освободим память, выделенную
  // для хранения битовых образов
  Back.Free;
  bitmap.Free;
  Buf.Free;
end;
 
end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
