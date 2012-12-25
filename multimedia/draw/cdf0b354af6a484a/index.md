---
Title: Как начертить hexagon?
Date: 01.01.2007
---


Как начертить hexagon?
======================

::: {.date}
01.01.2007
:::

    procedure PlotPolygon(const Canvas: TCanvas; const N: Integer; const R: Single;
      const XC: Integer; const YC: Integer);
    type
      TPolygon = array of TPoint;
    var
      Polygon: TPolygon;
      I: Integer;
      C: Extended;
      S: Extended;
      A: Single;
    begin
      SetLength(Polygon, N);
      A := 2 * Pi / N;
      for I := 0 to (N - 1) do
      begin
        SinCos(I * A, S, C);
        Polygon[I].X := XC + Round(R * C);
        Polygon[I].Y := YC + Round(R * S);
      end;
      Canvas.Polygon(Polygon);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      W: Single;
      H: Single;
      X: Integer;
      Y: Integer;
    const
      N = 6;
      R = 10;
    begin
      W := 1.5 * R;
      H := R * Sqrt(3);
      for X := 0 to Round(ClientWidth / W) do
        for Y := 0 to Round(ClientHeight / H) do
          if Odd(X) then
            PlotPolygon(Canvas, N, R, Round(X * W), Round((Y + 0.5) * H))
          else
            PlotPolygon(Canvas, N, R, Round(X * W), Round(Y * H));
    end;

------------------------------------------------------------------------

    unit HexGrid;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Controls, ExtCtrls, Math;
     
    type
     
      TOrientation = (hxVertical, hxhorizontal);
     
      THexGrid = class(TCustomPanel)
      private
        FOrientation: TOrientation;
        FHexSize: Integer;
        FPoints: array[0..5] of TPoint;
        FDisplayCaption: Boolean;
        procedure ChangedDimensions;
        procedure SetOrientation(Value: TOrientation);
        procedure SetHexSize(const Value: Integer);
        procedure DrawVerticalGrid;
        procedure DrawhorizontalGrid;
        procedure SetDisplayCaption(Value: Boolean);
      protected
      public
        constructor Create(AOwner: TComponent); override;
        procedure Paint; override;
        property Orientation: TOrientation read FOrientation write SetOrientation;
      published
        property Align;
        property Alignment;
        property Anchors;
        property AutoSize;
        property BevelInner;
        property BevelOuter;
        property BevelWidth;
        property BiDiMode;
        property BorderWidth;
        property BorderStyle;
        property Caption;
        property Color;
        property Constraints;
        property Ctl3D;
        property UseDockManager default True;
        property DockSite;
        property DragCursor;
        property DragKind;
        property DragMode;
        property Enabled;
        property FullRepaint;
        property Font;
        property Locked;
        property ParentBiDiMode;
        property ParentColor;
        property ParentCtl3D;
        property ParentFont;
        property ParentShowHint;
        property PopupMenu;
        property ShowHint;
        property TabOrder;
        property TabStop;
        property Visible;
        property OnCanResize;
        property OnClick;
        property OnConstrainedResize;
        property OnContextPopup;
        property OnDockDrop;
        property OnDockOver;
        property OnDblClick;
        property OnDragDrop;
        property OnDragOver;
        property OnEndDock;
        property OnEndDrag;
        property OnEnter;
        property OnExit;
        property OnGetSiteInfo;
        property OnMouseDown;
        property OnMouseMove;
        property OnMouseUp;
        property OnResize;
        property OnStartDock;
        property OnStartDrag;
        property OnUnDock;
        property Left;
        property Top;
        property Width;
        property Height;
        property Cursor;
        property Hint;
        property HelpType;
        property HelpKeyword;
        property HelpContext;
        property HexSize: Integer read FHexSize write SetHexSize;
        property DisplayCaption: Boolean read FDisplayCaption write SetDisplayCaption;
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Samples', [THexGrid]);
    end;
     
    procedure THexGrid.ChangedDimensions;
    var
      I: Integer;
    begin
      for I := 0 to High(FPoints) do
      begin
        FPoints[I].X := 0;
        FPoints[I].Y := 0;
      end;
      if Orientation = hxhorizontal then
      begin
        FPoints[0].X := Hexsize div 4;
        FPoints[1].X := HexSize - (Hexsize div 4);
        FPoints[2].X := HexSize;
        FPoints[2].Y := HexSize div 2;
        FPoints[3].X := HexSize - (Hexsize div 4);
        FPoints[3].Y := HexSize;
        FPoints[4].X := HexSize div 4;
        FPoints[4].Y := HexSize;
        FPoints[5].Y := HexSize div 2;
      end;
      if Orientation = hxVertical then
      begin
        FPoints[0].X := HexSize div 2;
        FPoints[1].X := HexSize;
        FPoints[1].Y := HexSize div 4;
        FPoints[2].X := HexSize;
        FPoints[2].Y := HexSize - (Hexsize div 4);
        FPoints[3].X := HexSize div 2;
        FPoints[3].Y := HexSize;
        FPoints[4].Y := HexSize - (Hexsize div 4);
        FPoints[5].Y := HexSize div 4;
      end;
    end;
     
    procedure THexGrid.SetOrientation(Value: TOrientation);
    begin
      if FOrientation <> Value then
      begin
        FOrientation := Value;
        ChangedDimensions;
        invalidate;
      end;
    end;
     
    procedure THexGrid.SetHexSize(const Value: Integer);
    begin
      if FHexSize <> Value then
      begin
        FHexSize := Value;
        ChangedDimensions;
        invalidate;
      end;
    end;
     
    constructor THexGrid.Create(AOwner: TComponent);
    begin
      inherited;
      FOrientation := hxVertical;
      FHexSize := 64;
      ChangedDimensions;
      Width := 128;
      Height := 128;
    end;
     
    procedure THexGrid.Paint;
    begin
      inherited;
      if Orientation = hxhorizontal then
        DrawhorizontalGrid
      else
        DrawVerticalGrid;
    end;
     
    procedure THexGrid.DrawhorizontalGrid;
    var
      I: Integer;
      X, Y, Offset: Integer;
      FHex: array[0..5] of TPoint;
    begin
      X := 0;
      Y := 0;
      Offset := 0;
      while X + HexSize < Width do
      begin
        Y := 0;
        while Y + HexSize < Height do
        begin
          with Self.Canvas do
          begin
            for I := 0 to High(FPoints) do
            begin
              FHex[I].X := X + FPoints[I].X;
              FHex[I].Y := Y + FPoints[I].Y + Offset;
            end;
            Polygon(FHex);
          end;
          Y := Y + HexSize;
        end;
        if Offset = 0 then
          Offset := (0 - (HexSize div 2))
        else
          Offset := 0;
        X := X + (HexSize - (HexSize div 4));
      end;
    end;
     
    procedure THexGrid.DrawVerticalGrid;
    var
      I: Integer;
      X, Y, Offset: Integer;
      FHex: array[0..5] of TPoint;
    begin
      X := 0;
      Y := 0;
      Offset := 0;
      while Y + HexSize < Height do
      begin
        X := 0;
        while X + HexSize < Width do
        begin
          with Self.Canvas do
          begin
            for I := 0 to High(FPoints) do
            begin
              FHex[I].X := X + FPoints[I].X + Offset;
              FHex[I].Y := Y + FPoints[I].Y;
            end;
            Polygon(FHex);
          end;
          X := X + HexSize;
        end;
        if Offset = 0 then
          Offset := (0 - (HexSize div 2))
        else
          Offset := 0;
        Y := Y + (HexSize - (HexSize div 4));
      end;
    end;
     
    procedure THexGrid.SetDisplayCaption(Value: Boolean);
    begin
    end;
     
    end.

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
