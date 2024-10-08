---
Title: Печать всей формы
Author: Bill
Date: 01.01.2007
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---

Печать всей формы
=================

    unit PrintF;
     
    {Печатает TLabel, TEdit, TMemo, TStringGrid, TShape и др. DB-компоненты.
     
    Установите Form H & V ScrollBar.Ranges на 768X1008 для страницы 8X10.5.
    Примечание: это не компонент. Успехов. Bill}
     
    interface
    uses
     
      SysUtils, WinTypes, WinProcs, Classes, Graphics, Controls,
      Forms, Grids, Printers, StdCtrls, ExtCtrls, Mask;
     
    function PrintForm(AForm: TForm; ATag: Longint): integer;
     
    {используйте:   PrintForm(Form2, 0);
     
    AForm - форма, которую необходимо напечатать. Если вы, к примеру,
    печатаете Form2 из обработчика события Form1, то используйте Unit2
    в списке используемых модулей в секции implementation молуля Unit1.
    ATag - поле Tag компонента, который необходимо печатать или 0 для всех.
    Если Tag компонента равен 14 (2+4+8), он буден напечатан в случае,
    когда ATag равен 0, 2, 4 или 8.
    Функция возвращает количество напечатанных компонентов. }
     
    implementation
    var ScaleX, ScaleY, I, Count: integer;
     
      DC: HDC;
      F: TForm;
     
    function ScaleToPrinter(R: TRect): TRect;
    begin
      R.Top := (R.Top + F.VertScrollBar.Position) * ScaleY;
      R.Left := (R.Left + F.HorzScrollBar.Position) * ScaleX;
      R.Bottom := (R.Bottom + F.VertScrollBar.Position) * ScaleY;
      R.Right := (R.Right + F.HorzScrollBar.Position) * ScaleY;
      Result := R;
    end;
     
    procedure PrintMComponent(MC: TMemo);
    var C: array[0..255] of char;
      CLen: integer;
      Format: Word;
      R: TRect;
     
    begin
      Printer.Canvas.Font := MC.Font;
      DC := Printer.Canvas.Handle; {так DrawText знает о шрифте}
      R := ScaleToPrinter(MC.BoundsRect);
      if (not (F.Components[I] is TCustomLabel)) and (MC.BorderStyle = bsSingle) then
        Printer.Canvas.Rectangle(R.Left, R.Top, R.Right, R.Bottom);
      Format := DT_LEFT;
      if (F.Components[I] is TEdit) or (F.Components[I] is TCustomMaskEdit) then
        Format := Format or DT_SINGLELINE or DT_VCENTER
      else
        begin
          if MC.WordWrap then Format := DT_WORDBREAK;
          if MC.Alignment = taCenter then Format := Format or DT_CENTER;
          if MC.Alignment = taRightJustify then Format := Format or DT_RIGHT;
          R.Bottom := R.Bottom + Printer.Canvas.Font.Height;
        end;
      CLen := MC.GetTextBuf(C, 255);
      R.Left := R.Left + ScaleX + ScaleX;
      WinProcs.DrawText(DC, C, CLen, R, Format);
      inc(Count);
    end;
     
    procedure PrintShape(SC: TShape);
    var H, W, S: integer;
      R: TRect;
    begin {PrintShape}
      Printer.Canvas.Pen := SC.Pen;
      Printer.Canvas.Pen.Width := Printer.Canvas.Pen.Width * ScaleX;
      Printer.Canvas.Brush := SC.Brush;
      R := ScaleToPrinter(SC.BoundsRect);
      W := R.Right - R.Left; H := R.Bottom - R.Top;
      if W < H then
        S := W
      else
        S := H;
      if SC.Shape in [stSquare, stRoundSquare, stCircle] then
        begin
          Inc(R.Left, (W - S) div 2);
          Inc(R.Top, (H - S) div 2);
          W := S;
          H := S;
        end;
      case SC.Shape of
        stRectangle, stSquare:
          Printer.Canvas.Rectangle(R.Left, R.Top, R.Left + W, R.Top + H);
        stRoundRect, stRoundSquare:
          Printer.Canvas.RoundRect(R.Left, R.Top, R.Left + W, R.Top + H, S div 4, S div 4);
        stCircle, stEllipse:
          Printer.Canvas.Ellipse(R.Left, R.Top, R.Left + W, R.Top + H);
      end;
      Printer.Canvas.Pen.Width := ScaleX;
      Printer.Canvas.Brush.Style := bsClear;
      inc(Count);
    end; {PrintShape}
     
    procedure PrintSGrid(SGC: TStringGrid);
    var J, K: integer;
      Q, R: TRect;
      Format: Word;
      C: array[0..255] of char;
      CLen: integer;
    begin
      Printer.Canvas.Font := SGC.Font;
      DC := Printer.Canvas.Handle; {так DrawText знает о шрифте}
      Format := DT_SINGLELINE or DT_VCENTER;
      Q := SGC.BoundsRect;
      Printer.Canvas.Pen.Width := SGC.GridLineWidth * ScaleX;
      for J := 0 to SGC.ColCount - 1 do
        for K := 0 to SGC.RowCount - 1 do
          begin
            R := SGC.CellRect(J, K);
            if R.Right > R.Left then
              begin
                R.Left := R.Left + Q.Left;
                R.Right := R.Right + Q.Left + SGC.GridLineWidth;
                R.Top := R.Top + Q.Top;
                R.Bottom := R.Bottom + Q.Top + SGC.GridLineWidth;
                R := ScaleToPrinter(R);
                if (J < SGC.FixedCols) or (K < SGC.FixedRows) then
                  Printer.Canvas.Brush.Color := SGC.FixedColor
                else
                  Printer.Canvas.Brush.Style := bsClear;
                if SGC.GridLineWidth > 0 then
                  Printer.Canvas.Rectangle(R.Left, R.Top, R.Right, R.Bottom);
                StrPCopy(C, SGC.Cells[J, K]);
                R.Left := R.Left + ScaleX + ScaleX;
                WinProcs.DrawText(DC, C, StrLen(C), R, Format);
     
              end;
          end;
      Printer.Canvas.Pen.Width := ScaleX;
      inc(Count);
    end;
     
    function PrintForm(AForm: TForm; ATag: Longint): integer;
    begin {PrintForm}
     
      Count := 0;
      F := AForm;
      Printer.BeginDoc;
      try
        DC := Printer.Canvas.Handle;
        ScaleX := WinProcs.GetDeviceCaps(DC, LOGPIXELSX) div F.PixelsPerInch;
        ScaleY := WinProcs.GetDeviceCaps(DC, LOGPIXELSY) div F.PixelsPerInch;
        for I := 0 to F.ComponentCount - 1 do
          if TControl(F.Components[I]).Visible then
            if (ATag = 0) or (TControl(F.Components[I]).Tag and ATag = ATag) then
              begin
                if (F.Components[I] is TCustomLabel) or (F.Components[I] is TCustomEdit) then
                  PrintMComponent(TMemo(F.Components[I]));
                if (F.Components[I] is TShape) then
                  PrintShape(TShape(F.Components[I]));
                if (F.Components[I] is TStringGrid) then
                  PrintSGrid(TStringGrid(F.Components[I]));
              end;
      finally
        Printer.EndDoc;
        Result := Count;
      end;
    end; {PrintForm}
     
    end.
     
    unit Rulers;
    { Добавьте в файл .DCR иконки для двух компонентов.
     
    Успехов, Bill}
    interface
     
    uses
     
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms;
     
    type
     
      THRuler = class(TGraphicControl)
      private
    { Private declarations }
        fHRulerAlign: TAlign;
        procedure SetHRulerAlign(Value: TAlign);
      protected
    { Protected declarations }
        procedure Paint; override;
      public
    { Public declarations }
        constructor Create(AOwner: TComponent); override;
      published
    { Published declarations }
        property AlignHRuler: TAlign read fHRulerAlign write SetHRulerAlign default alNone;
        property Color default clYellow;
        property Height default 33;
        property Width default 768;
        property Visible;
      end;
     
    type
      TVRuler = class(TGraphicControl)
      private
    { Private declarations }
        fVRulerAlign: TAlign;
        procedure SetVRulerAlign(Value: TAlign);
      protected
    { Protected declarations }
        procedure Paint; override;
      public
    { Public declarations }
        constructor Create(AOwner: TComponent); override;
      published
    { Published declarations }
        property AlignVRuler: TAlign read fVRulerAlign write SetVRulerAlign default alNone;
        property Color default clYellow;
        property Height default 1008;
        property Width default 33;
        property Visible;
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
     
      RegisterComponents('Samples', [THRuler, TVRuler]);
    end;
     
    procedure THRuler.SetHRulerAlign(Value: TAlign);
    begin
     
      if Value in [alTop, alBottom, alNone] then
        begin
          fHRulerAlign := Value;
          Align := Value;
        end;
    end;
     
    constructor THRuler.Create(AOwner: TComponent);
    begin
     
      inherited Create(AOwner);
      AlignHRuler := alNone;
      Color := clYellow;
      Height := 33;
      Width := 768;
    end;
     
    procedure THRuler.Paint;
    var a12th, N, X: word;
    begin
     
      a12th := Screen.PixelsPerInch div 12;
      N := 0; X := 0;
      with Canvas do
        begin
          Brush.Color := Color;
          FillRect(ClientRect);
          with ClientRect do
            Rectangle(Left, Top, Right, Bottom);
          while X < Width do
            begin
              MoveTo(X, 1);
              LineTo(X, 6 * (1 + byte(N mod 3 = 0) +
                byte(N mod 6 = 0) +
                byte(N mod 12 = 0)));
              if (N > 0) and (N mod 12 = 0) then
                TextOut(PenPos.X + 3, 9, IntToStr(N div 12));
              N := N + 1;
              X := X + a12th;
            end;
        end;
    end;
    {*********************************************}
     
    procedure TVRuler.SetVRulerAlign(Value: TAlign);
    begin
     
      if Value in [alLeft, alRight, alNone] then
        begin
          fVRulerAlign := Value;
          Align := Value;
        end;
    end;
     
    constructor TVRuler.Create(AOwner: TComponent);
    begin
     
      inherited Create(AOwner);
      AlignVRuler := alNone;
      Color := clYellow;
      Height := 1008;
      Width := 33;
    end;
     
    procedure TVRuler.Paint;
    var a6th, N, Y: word;
    begin
     
      a6th := Screen.PixelsPerInch div 6;
      N := 0; Y := 0;
      with Canvas do
        begin
          Brush.Color := Color;
          FillRect(ClientRect);
          with ClientRect do
            Rectangle(Left, Top, Right, Bottom);
          while Y < Height do
            begin
              MoveTo(1, Y);
              LineTo(6 * (2 + byte(N mod 3 = 0) +
                byte(N mod 6 = 0)), Y);
              if (N > 0) and (N mod 6 = 0) then
                TextOut(12, PenPos.Y - 16, IntToStr(N div 6));
              N := N + 1;
              Y := Y + a6th;
            end;
        end;
    end;
     
    end.

