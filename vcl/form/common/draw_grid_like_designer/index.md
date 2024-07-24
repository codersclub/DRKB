---
Title: Функция, которая нарисует на форме сетку и сделает форму похожей на дизайнер форм Delphi
Author: Rrader
Source: Vingrad.ru <https://forum.vingrad.ru>
Date: 01.01.2007
---


Функция, которая нарисует на форме сетку и сделает форму похожей на дизайнер форм Delphi
========================================================================================

Функция, которая нарисует на форме сетку и сделает форму похожей на
дизайнер форм Delphi. По умолчанию в дизайнере Delphi отступы равны 8
пикселям

    procedure TForm1.DrawGrid;
    var
      TmpBmp: TBitmap;
    begin
      TmpBmp := TBitmap.Create;
      try
        with TmpBmp do
        begin
          Width := 8;
          Height := 8;
          Canvas.Brush.Color := clBtnFace;
          Canvas.FillRect(TmpBmp.Canvas.ClipRect);
          Canvas.Pixels[0, 0] := clBlack;
          Canvas.Pixels[0, Height] := clBlack;
          Canvas.Pixels[Width, 0] := clBlack;
          Canvas.Pixels[Width, Height] := clBlack;
        end;
        with Canvas, Brush do
        begin
          Bitmap := TBitmap.Create;
          try
            Bitmap.Assign(TmpBmp);
            Canvas.FillRect(Canvas.ClipRect);
          finally
            Bitmap.Free;
          end;
        end;
      finally
        TmpBmp.Free;
      end;
    end;
     
    { Использование }
    procedure TForm1.FormPaint(Sender: TObject);
    begin
      DrawGrid; 
    end;

Ещё способ, рисует сетку либо линии на компоненте AObject цветом
FGridColor, в параметре ACanvas нужно передать холст компонента, FSizeX
и FSizeY определяют размер сетки либо линий:

    ...
      TGridType = (gtDots, gtLines);
    ...
    procedure Draw(AObject: TControl; ACanvas: TCanvas; FGridType: TGridType; FGridColor: TColor;
      FSizeX, FSizeY: Integer);
    var
      ColorRGB, X, Y, MaxX, MaxY: Integer;
      DC: HDC;
    begin
      MaxX := AObject.ClientWidth Div FSizeX;
      MaxY := AObject.ClientHeight Div FSizeY;
      case FGridType of
        gtDots:
          begin
            ColorRGB := ColorToRGB(FGridColor);
            DC := ACanvas.Handle;
            For X := 0 To MaxX Do
              For Y := 0 To MaxY Do
              SetPixel(DC, X * FSizeX, Y * FSizeY, ColorRGB);
          End;
        gtLines:
          begin
            ACanvas.Pen.Color := FGridColor;
            for X := 0 to MaxX do
            Begin
              ACanvas.MoveTo(X * FSizeX, 0);
              ACanvas.LineTo(X * FSizeY, AObject.ClientHeight);
            end;
            for Y := 0 to MaxY do
            begin
              ACanvas.MoveTo(0, Y * FSizeY);
              ACanvas.LineTo(AObject.ClientWidth, Y * FSizeY);
            end;
          end;
      end;
    end;

