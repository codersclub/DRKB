---
Title: Рисовать практически любую фигуру!
Author: Deni
Date: 01.01.2007
---


Рисовать практически любую фигуру!
==================================

::: {.date}
01.01.2007
:::

Недавно писал графический редактор и вот просматривая GDI функции
заметил LineDDA. При ближайшем рассмотрении эта функция поверга меня в
шок, долго я не мог поверить своему счастью. Эта бестия позволяет
рисовать практически любую фигуру!


Синтаксис:

function LineDDA(XStart, YStart, XEnd, YEnd: Integer; LineFunc:
TFNLineDDAProc; Data: LPARAM): BOOL;


где
XStart, YStart - начальные позиции,
XEnd, YEnd - задают тень,
LineFunc: TFNLineDDAProc - указатель на функцию обратного вызова,
параметры объясню далее,
Data - дополнительный параметр(у меня в исходнике я использую его для
передачи контекста устройства)



Функция обратного вызова:

procedure func(X,Y:integer; lpData:LPARAM);stdcall;


X,Y - текущие координаты мыши,
lpData - дополнительный параметр о котором я уже писал выше.



К сему прикрепляю исходник, в котором с помощью этой ф-ции рисуется
крест. Надеюсь кому-нибудь пригодится.

    unit Unit1;
     
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

Автор: Deni

Взято из <https://forum.sources.ru>
