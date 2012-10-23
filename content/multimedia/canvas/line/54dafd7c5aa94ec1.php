<h1>Рисование линий как в Microsoft Paint</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ToolWin, ComCtrls, ExtCtrls;
 
type
  TForm1 = class(TForm)
    Image1: TImage;
    procedure FormCreate(Sender: TObject);
    procedure FormMouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure FormMouseUp(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure FormMouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
  private
    { Private declarations }
    StartX: integer;
    StartY: integer;
    EndX: integer;
    EndY: integer;
    isMousePressed: boolean;
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
 isMousePressed:=false;
 Image1.Picture.Bitmap:=TBitmap.create();
 Image1.Picture.Bitmap.Width:=Image1.Width;
 Image1.Picture.Bitmap.Height:=Image1.Height
end;
 
procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
 StartX:=X;
 StartY:=Y;
 EndX:=StartX;
 EndY:=StartY;
 isMousePressed:=true
end;
 
procedure TForm1.FormMouseUp(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
 isMousePressed:=false;
 Image1.Picture.Bitmap.Canvas.Pen.Mode:=pmNOT;
 Image1.Picture.Bitmap.Canvas.moveTo(StartX, StartY);
 Image1.Picture.Bitmap.Canvas.lineTo(EndX, EndY);
 Image1.Picture.Bitmap.Canvas.Pen.Mode:=pmCopy;
 EndX:=X;
 EndY:=Y;
 Image1.Picture.Bitmap.Canvas.moveTo(StartX, StartY);
 Image1.Picture.Bitmap.Canvas.lineTo(EndX, EndY)
end;
 
procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X,
  Y: Integer);
begin
 if isMousePressed then
 begin
  Image1.Picture.Bitmap.Canvas.Pen.Mode:=pmNOT;
  Image1.Picture.Bitmap.Canvas.moveTo(StartX, StartY);
  Image1.Picture.Bitmap.Canvas.lineTo(EndX, EndY);
  EndX:=X;
  EndY:=Y;
  Image1.Picture.Bitmap.Canvas.moveTo(StartX, StartY);
  Image1.Picture.Bitmap.Canvas.lineTo(EndX, EndY);
  Image1.Picture.Bitmap.Canvas.Pen.Mode:=pmCopy
 end
end;
 
end.
</pre>
<p>&nbsp;<br>
&nbsp;<br>
Более развернутую демку можно найти в папке {$DELPHI7}/Demos/Doc/Graphex<br>
&nbsp;<br>
<div class="author">Автор: Mischka </div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
