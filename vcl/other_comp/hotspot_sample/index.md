---
Title: Пример компонента HotSpot
Author: Robert Wittig
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Пример компонента HotSpot
=========================

Вот пример HotSpot-компонента, основанного на TPanel (небольшая
переделка). Управляя событиями MouseDown и MouseUp можно получить эффект
резинового контура.

    unit Newpanel;
     
    interface
    uses WinTypes, Classes, Controls, StdCtrls, ExtCtrls;
     
    type
     
      tHotSpotClickEvent = procedure(Sender: tObject;
        Button: tMouseButton;
        Shift: tShiftState) of object;
     
      TNewPanel = class(tPanel)
      private
        fHotSpotClick: tHotSpotClickEvent;
        fHotSpot: tRect;
        fInHotSpot: Boolean;
        function GetHotSpotTop: Word;
        function GetHotSpotLeft: Word;
        function GetHotSpotWidth: Word;
        function GetHotSpotHeight: Word;
        procedure SetHotSpotTop(Value: Word);
        procedure SetHotSpotLeft(Value: Word);
        procedure SetHotSpotWidth(Value: Word);
        procedure SetHotSpotHeight(Value: Word);
      protected
        procedure Paint; override;
        procedure MouseDown(Button: tMouseButton; Shift: tShiftState; X, Y: Integer);
          override;
        procedure MouseUp(Button: tMouseButton; Shift: tShiftState; X, Y: Integer);
          override;
      public
        procedure Click; override;
        property HotSpot: tRect read fHotSpot write fHotSpot;
      published
        property hsTop: Word read GetHotSpotTop write SetHotSpotTop;
        property hsLeft: Word read GetHotSpotLeft write SetHotSpotLeft;
        property hsWidth: Word read GetHotSpotWidth write SetHotSpotWidth;
        property hsHeight: Word read GetHotSpotHeight write SetHotSpotHeight;
        property OnHotSpot: tHotSpotClickEvent read fHotSpotClick write
          fHotSpotClick;
      end;
     
    procedure Register;
     
    implementation
    uses WinProcs, Graphics;
     
    procedure Register;
    begin
      RegisterComponents('Custom', [TNewPanel]);
    end;
     
    procedure TNewPanel.MouseDown(Button: tMouseButton;
      Shift: tShiftState;
      X, Y: Integer);
    begin
      if PtInRect(fHotSpot, Point(X, Y)) and
        Assigned(fHotSpotClick) then
        fInHotSpot := True;
      inherited MouseDown(Button, Shift, X, Y);
    end;
     
    procedure TNewPanel.MouseUp(Button: tMouseButton;
      Shift: tShiftState;
      X, Y: Integer);
    begin
      inherited MouseUp(Button, Shift, X, Y);
     
      if fInHotSpot then
      begin
        if Assigned(fHotSpotClick) then
          fHotSpotClick(Self, Button, Shift);
        fInHotSpot := False;
      end;
    end;
     
    procedure TNewPanel.Click;
    begin
      if not fInHotSpot then
        inherited Click;
    end;
     
    procedure TNewPanel.Paint;
    var
      OldStyle: tPenStyle;
    begin
      inherited Paint;
     
      if csDesigning in ComponentState then
      begin
        OldStyle := Canvas.Pen.Style;
        Canvas.Pen.Style := psDash;
        Canvas.Rectangle(HotSpot.Left, HotSpot.Top, HotSpot.Right, HotSpot.Bottom);
        Canvas.Pen.Style := OldStyle;
      end;
    end;
     
    procedure TNewPanel.SetHotSpotTop(Value: Word);
    begin
      fHotSpot.Bottom := fHotSpot.Bottom + Value - fHotSpot.Top;
      fHotSpot.Top := Value;
      Paint;
    end;
     
    procedure TNewPanel.SetHotSpotLeft(Value: Word);
    begin
      fHotSpot.Right := fHotSpot.Right + Value - fHotSpot.Left;
      fHotSpot.Left := Value;
      Paint;
    end;
     
    procedure TNewPanel.SetHotSpotWidth(Value: Word);
    begin
      fHotSpot.Right := fHotSpot.Left + Value;
      Paint;
    end;
     
    procedure TNewPanel.SetHotSpotHeight(Value: Word);
    begin
      fHotSpot.Bottom := fHotSpot.Top + Value;
      Paint;
    end;
     
    function TNewPanel.GetHotSpotTop: Word;
    begin
      Result := fHotSpot.Top
    end;
     
    function TNewPanel.GetHotSpotLeft: Word;
    begin
      Result := fHotSpot.Left;
    end;
     
    function TNewPanel.GetHotSpotWidth: Word;
    begin
      Result := fHotSpot.Right - fHotSpot.Left;
    end;
     
    function TNewPanel.GetHotSpotHeight: Word;
    begin
      Result := fHotSpot.Bottom - fHotSpot.Top;
    end;
     
    end.

