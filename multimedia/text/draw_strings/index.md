---
Title: Вывод строковой информации
Author: Xavier Pacheco
Date: 12.12.1999
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Вывод строковой информации
==========================

    {
    Copyright © 1999 by Delphi 5 Developer's Guide - Xavier Pacheco and Steve Teixeira
    }
     
    unit MainFrm;
     
    interface
     
    uses
      SysUtils, Windows, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, Menus;
     
    const
      DString = 'Delphi 5 YES!';
      DString2 = 'Delphi 5 Rocks!';
     
    type
     
      TMainForm = class(TForm)
        mmMain: TMainMenu;
        mmiText: TMenuItem;
        mmiTextRect: TMenuItem;
        mmiTextSize: TMenuItem;
        mmiDrawTextCenter: TMenuItem;
        mmiDrawTextRight: TMenuItem;
        mmiDrawTextLeft: TMenuItem;
        procedure mmiTextRectClick(Sender: TObject);
        procedure mmiTextSizeClick(Sender: TObject);
        procedure mmiDrawTextCenterClick(Sender: TObject);
        procedure mmiDrawTextRightClick(Sender: TObject);
        procedure mmiDrawTextLeftClick(Sender: TObject);
      public
        procedure ClearCanvas;
      end;
     
    var
      MainForm: TMainForm;
     
    implementation
     
    {$R *.DFM}
     
    procedure TMainForm.ClearCanvas;
    begin
      with Canvas do
      begin
        Brush.Style := bsSolid;
        Brush.Color := clWhite;
        FillRect(ClipRect);
      end;
    end;
     
    procedure TMainForm.mmiTextRectClick(Sender: TObject);
    var
      R: TRect;
      TWidth, THeight: integer;
    begin
      ClearCanvas;
      Canvas.Font.Size := 18;
      // Calculate the width/height of the text string
      TWidth := Canvas.TextWidth(DString);
      THeight := Canvas.TextHeight(DString);
     
      { Initialize a TRect structure. The height of this rectangle will
        be 1/2 the height of the text string height. This is to
        illustrate clipping the text by the rectangle drawn }
      R := Rect(1, THeight div 2, TWidth + 1, THeight + (THeight div 2));
      // Draw a rectangle based on the text sizes
      Canvas.Rectangle(R.Left - 1, R.Top - 1, R.Right + 1, R.Bottom + 1);
      // Draw the Text within the rectangle
      Canvas.TextRect(R, 0, 0, DString);
    end;
     
    procedure TMainForm.mmiTextSizeClick(Sender: TObject);
    begin
      ClearCanvas;
      with Canvas do
      begin
        Font.Size := 18;
        TextOut(10, 10, DString);
        TextOut(50, 50, 'TextWidth = ' + IntToStr(TextWidth(DString)));
        TextOut(100, 100, 'TextHeight = ' + IntToStr(TextHeight(DString)));
      end;
    end;
     
    procedure TMainForm.mmiDrawTextCenterClick(Sender: TObject);
    var
      R: TRect;
    begin
      ClearCanvas;
      Canvas.Font.Size := 10;
      R := Rect(10, 10, 80, 100);
      // Draw a rectangle to surround the TRect boundaries by 2 pixels }
      Canvas.Rectangle(R.Left - 2, R.Top - 2, R.Right + 2, R.Bottom + 2);
      // Draw text centered by specifying the dt_Center option
      DrawText(Canvas.Handle, PChar(DString2), -1, R, dt_WordBreak or dt_Center);
    end;
     
    procedure TMainForm.mmiDrawTextRightClick(Sender: TObject);
    var
      R: TRect;
    begin
      ClearCanvas;
      Canvas.Font.Size := 10;
      R := Rect(10, 10, 80, 100);
      // Draw a rectangle to surround the TRect boundaries by 2 pixels
      Canvas.Rectangle(R.Left - 2, R.Top - 2, R.Right + 2, R.Bottom + 2);
      // Draw text right-aligned by specifying the dt_Right option
      DrawText(Canvas.Handle, PChar(DString2), -1, R, dt_WordBreak or dt_Right);
    end;
     
    procedure TMainForm.mmiDrawTextLeftClick(Sender: TObject);
    var
      R: TRect;
    begin
      ClearCanvas;
      Canvas.Font.Size := 10;
      R := Rect(10, 10, 80, 100);
      // Draw a rectangle to surround the TRect boudries by 2 pixels
      Canvas.Rectangle(R.Left - 2, R.Top - 2, R.Right + 2, R.Bottom + 2);
      // Draw text left-aligned by specifying the dt_Left option
      DrawText(Canvas.Handle, PChar(DString2), -1, R, dt_WordBreak or dt_Left);
    end;
     
    end.


