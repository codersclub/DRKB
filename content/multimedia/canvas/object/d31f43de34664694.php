<h1>Рисовать практически любую фигуру!</h1>
<div class="date">01.01.2007</div>

<p>Недавно писал графический редактор и вот просматривая GDI функции заметил LineDDA. При ближайшем рассмотрении эта функция поверга меня в шок, долго я не мог поверить своему счастью. Эта бестия позволяет рисовать практически любую фигуру!<br>
 <br>
<p>Синтаксис:</p>
<p>function LineDDA(XStart, YStart, XEnd, YEnd: Integer; LineFunc: TFNLineDDAProc; Data: LPARAM): BOOL;</p>
<p> <br>
где <br>
XStart, YStart - начальные позиции, <br>
XEnd, YEnd - задают тень,<br>
LineFunc: TFNLineDDAProc - указатель на функцию обратного вызова, параметры объясню далее,<br>
Data - дополнительный параметр(у меня в исходнике я использую его для передачи контекста устройства)<br>
 <br>
 <br>
<p>Функция обратного вызова:</p>
<p>procedure func(X,Y:integer; lpData:LPARAM);stdcall;</p>
<p> <br>
X,Y - текущие координаты мыши,<br>
lpData - дополнительный параметр о котором я уже писал выше.<br>
 <br>
 <br>
<p>К сему прикрепляю исходник, в котором с помощью этой ф-ции рисуется крест. Надеюсь кому-нибудь пригодится.</p>
<pre>unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, ExtCtrls, StdCtrls;
 
type
  TForm1 = class(TForm)
    Image1: TImage;
    Button1: TButton;
    procedure Image1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
    procedure Image1MouseUp(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure FormCreate(Sender: TObject);
    procedure Button1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
  b:boolean;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.Image1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  b:=true;
end;
 
procedure func(X,Y:integer; lpData:LPARAM);stdcall;
begin
  Rectangle(lpData,X,Y,X-10,Y-10);
  Rectangle(lpData,X,Y,X-20,Y+10);
  Rectangle(lpData,X,Y,X-10,Y+30);
  Rectangle(lpData,X,Y,X+10,Y+10);
  Sleep(10);
end;
 
procedure TForm1.Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
  Y: Integer);
begin
  if b then LineDDA(X, Y, X-2, Y+2, @func, Image1.Canvas.Handle);
  Image1.Repaint;
end;
 
procedure TForm1.Image1MouseUp(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  b:=false;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  b:=false;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  Image1.Canvas.FillRect(Bounds(Image1.Left,Image1.Top,Image1.Width,Image1.Height));
end;
 
end.
</pre>
<pre>
object Form1: TForm1
  Left = 38
  Top = 143
  Width = 441
  Height = 500
  Caption = 'Form1'
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  OnCreate = FormCreate
  PixelsPerInch = 96
  TextHeight = 13
  object Image1: TImage
    Left = 0
    Top = 0
    Width = 433
    Height = 466
    Align = alClient
    OnMouseDown = Image1MouseDown
    OnMouseMove = Image1MouseMove
    OnMouseUp = Image1MouseUp
  end
  object Button1: TButton
    Left = 144
    Top = 400
    Width = 75
    Height = 25
    Caption = 'Button1'
    TabOrder = 0
    OnClick = Button1Click
  end
end
</pre>
<div class="author">Автор: Deni</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
