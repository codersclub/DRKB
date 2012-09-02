<h1>Отрисовка битового образца</h1>
<div class="date">01.01.2007</div>


<pre>
unit aplanes_;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs;
 
type
  TForm1 = class(TForm)
    procedure FormPaint(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
  sky, aplane: TBitMap; // битовые образы: небо и самолет
 
implementation
 
{$R *.DFM}
 
procedure TForm1.FormPaint(Sender: TObject);
begin
     // создать битовые образы
  sky := TBitMap.Create;
  aplane := TBitMap.Create;
 
     // загрузить картинки
  sky.LoadFromFile('sky.bmp');
  aplane.LoadFromFile('aplane.bmp');
 
  Form1.Canvas.Draw(0, 0, sky); // отрисовка фона
  Form1.Canvas.Draw(20, 20, aplane); // отрисовка левого самолета
 
  aplane.Transparent := True;
     // теперь элементы рисунка, цвет которых совпадает с цветом
     // левой нижней точки битового образа, не отрисовываются
  Form1.Canvas.Draw(120, 20, aplane); // отрисовка правого самолета
 
     // освободить память
  sky.free;
  aplane.free;
end;
 
end.
</pre>

