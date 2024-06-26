---
Title: Спрайтовый персонаж (Screenmate)
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Спрайтовый персонаж (Screenmate)
================================

Многие из вас знакомы с этим термином. Так характеризуют программы,
которые выводят на экран спрайтового персонажа, не создавая при этом
окна. Я очень давно искал данный пример в сети, и теперь решил вас
порадовать. Программа состоит из нескольких узлов, кои будут приведены
ниже...

**p.s.**
К сожалению вам надо позаботиться о кадрах анимации этого персонажа
самим т.к рисунки я послать немогу...


    {*******************************************************}
                                                          { }
                               { Delphi VCL Extensions (RX) }
                                                          { }
                        { Copyright (c) 1995, 1996 AO ROSNO }
                     { Copyright (c) 1997, 1998 Master-Bank }
                                                          { }
    {*******************************************************}
     
    unit Animate;
     
    interface
     
    {$I RX.INC}
     
    uses Messages, {$IFDEF WIN32}Windows, {$ELSE}WinTypes, WinProcs,
    {$ENDIF}
      SysUtils, Classes, Graphics, Controls, Forms, StdCtrls, Menus,
      ExtCtrls;
     
    type
      TGlyphOrientation = (goHorizontal, goVertical);
     
      { TRxImageControl }
     
      TRxImageControl = class(TGraphicControl)
      private
        FDrawing: Boolean;
      protected
        FGraphic: TGraphic;
        function DoPaletteChange: Boolean;
        procedure DoPaintImage; virtual; abstract;
        procedure PaintDesignRect;
        procedure PaintImage;
        procedure PictureChanged;
      public
        constructor Create(AOwner: TComponent); override;
      end;
     
      { TAnimatedImage }
     
      TAnimatedImage = class(TRxImageControl)
      private
        { Private declarations }
        FActive: Boolean;
        FAutoSize: Boolean;
        FGlyph: TBitmap;
        FImageWidth: Integer;
        FImageHeight: Integer;
        FInactiveGlyph: Integer;
        FOrientation: TGlyphOrientation;
        FTimer: TTimer;
        FNumGlyphs: Integer;
        FGlyphNum: Integer;
        FStretch: Boolean;
        FTransparentColor: TColor;
        FOpaque: Boolean;
        FTimerRepaint: Boolean;
        FOnFrameChanged: TNotifyEvent;
        FOnStart: TNotifyEvent;
        FOnStop: TNotifyEvent;
        procedure DefineBitmapSize;
        procedure ResetImageBounds;
        procedure AdjustBounds;
        function GetInterval: Cardinal;
        procedure SetAutoSize(Value: Boolean);
        procedure SetInterval(Value: Cardinal);
        procedure SetActive(Value: Boolean);
        procedure SetOrientation(Value: TGlyphOrientation);
        procedure SetGlyph(Value: TBitmap);
        procedure SetGlyphNum(Value: Integer);
        procedure SetInactiveGlyph(Value: Integer);
        procedure SetNumGlyphs(Value: Integer);
        procedure SetStretch(Value: Boolean);
        procedure SetTransparentColor(Value: TColor);
        procedure SetOpaque(Value: Boolean);
        procedure ImageChanged(Sender: TObject);
        procedure UpdateInactive;
        procedure TimerExpired(Sender: TObject);
        function TransparentStored: Boolean;
        procedure WMSize(var Message: TWMSize); message WM_SIZE;
      protected
        { Protected declarations }
        function GetPalette: HPALETTE; override;
        procedure Loaded; override;
        procedure Paint; override;
        procedure DoPaintImage; override;
        procedure FrameChanged; dynamic;
        procedure Start; dynamic;
        procedure Stop; dynamic;
      public
        { Public declarations }
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
        procedure DoPaintImageOn(Mycanvas: Tcanvas; x, y: integer);
          virtual;
      published
        { Published declarations }
        property Active: Boolean read FActive write SetActive default
          False;
        property Align;
        property AutoSize: Boolean read FAutoSize write SetAutoSize
          default True;
        property Orientation: TGlyphOrientation read FOrientation write
          SetOrientation
          default goHorizontal;
        property Glyph: TBitmap read FGlyph write SetGlyph;
        property GlyphNum: Integer read FGlyphNum write SetGlyphNum
          default 0;
        property Interval: Cardinal read GetInterval write SetInterval
          default 100;
        property NumGlyphs: Integer read FNumGlyphs write SetNumGlyphs
          default 1;
        property InactiveGlyph: Integer read FInactiveGlyph write
          SetInactiveGlyph default -1;
        property TransparentColor: TColor read FTransparentColor write
          SetTransparentColor
          stored TransparentStored;
        property Opaque: Boolean read FOpaque write SetOpaque default
          False;
        property Color;
        property Cursor;
        property DragCursor;
        property DragMode;
        property ParentColor default True;
        property ParentShowHint;
        property PopupMenu;
        property ShowHint;
        property Stretch: Boolean read FStretch write SetStretch default
          True;
        property Visible;
        property OnClick;
        property OnDblClick;
        property OnMouseMove;
        property OnMouseDown;
        property OnMouseUp;
        property OnDragOver;
        property OnDragDrop;
        property OnEndDrag;
    {$IFDEF WIN32}
        property OnStartDrag;
    {$ENDIF}
        property OnFrameChanged: TNotifyEvent read FOnFrameChanged write
          FOnFrameChanged;
        property OnStart: TNotifyEvent read FOnStart write FOnStart;
        property OnStop: TNotifyEvent read FOnStop write FOnStop;
      end;
     
    implementation
     
    uses RxConst, VCLUtils;
     
    { TRxImageControl }
     
    constructor TRxImageControl.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      ControlStyle := [csClickEvents, csCaptureMouse, csOpaque,
    {$IFDEF WIN32}csReplicatable, {$ENDIF}csDoubleClicks];
      Height := 105;
      Width := 105;
      ParentColor := True;
    end;
     
    procedure TRxImageControl.PaintImage;
    var
      Save: Boolean;
    begin
      Save := FDrawing;
      FDrawing := True;
      try
        DoPaintImage;
      finally
        FDrawing := Save;
      end;
    end;
     
    procedure TRxImageControl.PaintDesignRect;
    begin
      if csDesigning in ComponentState then
        with Canvas do
        begin
          Pen.Style := psDash;
          Brush.Style := bsClear;
          Rectangle(0, 0, Width, Height);
        end;
    end;
     
    function TRxImageControl.DoPaletteChange: Boolean;
    var
      ParentForm: TCustomForm;
      Tmp: TGraphic;
    begin
      Result := False;
      Tmp := FGraphic;
      if Visible and (not (csLoading in ComponentState)) and (Tmp <>
        nil)
    {$IFDEF RX_D3} and (Tmp.PaletteModified){$ENDIF} then
      begin
        if (GetPalette <> 0) then
        begin
          ParentForm := GetParentForm(Self);
          if Assigned(ParentForm) and ParentForm.Active and
            Parentform.HandleAllocated then
          begin
            if FDrawing then
              ParentForm.Perform(WM_QUERYNEWPALETTE, 0, 0)
            else
              PostMessage(ParentForm.Handle, WM_QUERYNEWPALETTE, 0, 0);
            Result := True;
    {$IFDEF RX_D3}
            Tmp.PaletteModified := False;
    {$ENDIF}
          end;
        end
    {$IFDEF RX_D3}
        else
        begin
          Tmp.PaletteModified := False;
        end;
    {$ENDIF}
      end;
    end;
     
    procedure TRxImageControl.PictureChanged;
    begin
      if (FGraphic <> nil) then
        if DoPaletteChange and FDrawing then
          Update;
      if not FDrawing then
        Invalidate;
    end;
     
    { TAnimatedImage }
     
    constructor TAnimatedImage.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      FTimer := TTimer.Create(Self);
      Interval := 100;
      FGlyph := TBitmap.Create;
      FGraphic := FGlyph;
      FGlyph.OnChange := ImageChanged;
      FGlyphNum := 0;
      FNumGlyphs := 1;
      FInactiveGlyph := -1;
      FTransparentColor := clNone;
      FOrientation := goHorizontal;
      FAutoSize := True;
      FStretch := True;
      Width := 32;
      Height := 32;
    end;
     
    destructor TAnimatedImage.Destroy;
    begin
      FOnFrameChanged := nil;
      FOnStart := nil;
      FOnStop := nil;
      FGlyph.OnChange := nil;
      Active := False;
      FGlyph.Free;
      inherited Destroy;
    end;
     
    procedure TAnimatedImage.Loaded;
    begin
      inherited Loaded;
      ResetImageBounds;
      UpdateInactive;
    end;
     
    function TAnimatedImage.GetPalette: HPALETTE;
    begin
      Result := 0;
      if not FGlyph.Empty then
        Result := FGlyph.Palette;
    end;
     
    procedure TAnimatedImage.ImageChanged(Sender: TObject);
    begin
      FTransparentColor := FGlyph.TransparentColor and not PaletteMask;
      DefineBitmapSize;
      AdjustBounds;
      PictureChanged;
    end;
     
    procedure TAnimatedImage.UpdateInactive;
    begin
      if (not Active) and (FInactiveGlyph >= 0) and
        (FInactiveGlyph < FNumGlyphs) and (FGlyphNum <> FInactiveGlyph) then
      begin
        FGlyphNum := FInactiveGlyph;
      end;
    end;
     
    function TAnimatedImage.TransparentStored: Boolean;
    begin
      Result := (FGlyph.Empty and (FTransparentColor <> clNone)) or
        ((FGlyph.TransparentColor and not PaletteMask) <>
        FTransparentColor);
    end;
     
    procedure TAnimatedImage.SetOpaque(Value: Boolean);
    begin
      if Value <> FOpaque then
      begin
        FOpaque := Value;
        PictureChanged;
      end;
    end;
     
    procedure TAnimatedImage.SetTransparentColor(Value: TColor);
    begin
      if Value <> TransparentColor then
      begin
        FTransparentColor := Value;
        PictureChanged;
      end;
    end;
     
    procedure TAnimatedImage.SetOrientation(Value: TGlyphOrientation);
    begin
      if FOrientation <> Value then
      begin
        FOrientation := Value;
        DefineBitmapSize;
        AdjustBounds;
        Invalidate;
      end;
    end;
     
    procedure TAnimatedImage.SetGlyph(Value: TBitmap);
    begin
      FGlyph.Assign(Value);
    end;
     
    procedure TAnimatedImage.SetStretch(Value: Boolean);
    begin
      if Value <> FStretch then
      begin
        FStretch := Value;
        PictureChanged;
        if Active then
          Repaint;
      end;
    end;
     
    procedure TAnimatedImage.SetGlyphNum(Value: Integer);
    begin
      if Value <> FGlyphNum then
      begin
        if (Value < FNumGlyphs) and (Value >= 0) then
        begin
          FGlyphNum := Value;
          UpdateInactive;
          FrameChanged;
          PictureChanged;
        end;
      end;
    end;
     
    procedure TAnimatedImage.SetInactiveGlyph(Value: Integer);
    begin
      if Value < 0 then
        Value := -1;
      if Value <> FInactiveGlyph then
      begin
        if (Value < FNumGlyphs) or (csLoading in ComponentState) then
        begin
          FInactiveGlyph := Value;
          UpdateInactive;
          FrameChanged;
          PictureChanged;
        end;
      end;
    end;
     
    procedure TAnimatedImage.SetNumGlyphs(Value: Integer);
    begin
      FNumGlyphs := Value;
      if FInactiveGlyph >= FNumGlyphs then
      begin
        FInactiveGlyph := -1;
        FGlyphNum := 0;
      end
      else
        UpdateInactive;
      FrameChanged;
      ResetImageBounds;
      AdjustBounds;
      PictureChanged;
    end;
     
    procedure TAnimatedImage.DefineBitmapSize;
    begin
      FNumGlyphs := 1;
      FGlyphNum := 0;
      FImageWidth := 0;
      FImageHeight := 0;
      if (FOrientation = goHorizontal) and (FGlyph.Height > 0) and
        (FGlyph.Width mod FGlyph.Height = 0) then
        FNumGlyphs := FGlyph.Width div FGlyph.Height
      else if (FOrientation = goVertical) and (FGlyph.Width > 0) and
        (FGlyph.Height mod FGlyph.Width = 0) then
        FNumGlyphs := FGlyph.Height div FGlyph.Width;
      ResetImageBounds;
    end;
     
    procedure TAnimatedImage.ResetImageBounds;
    begin
      if FNumGlyphs < 1 then
        FNumGlyphs := 1;
      if FOrientation = goHorizontal then
      begin
        FImageHeight := FGlyph.Height;
        FImageWidth := FGlyph.Width div FNumGlyphs;
      end
      else {if Orientation = goVertical then}
      begin
        FImageWidth := FGlyph.Width;
        FImageHeight := FGlyph.Height div FNumGlyphs;
      end;
    end;
     
    procedure TAnimatedImage.AdjustBounds;
    begin
      if not (csReading in ComponentState) then
      begin
        if FAutoSize and (FImageWidth > 0) and (FImageHeight > 0) then
          SetBounds(Left, Top, FImageWidth, FImageHeight);
      end;
    end;
     
    type
      TParentControl = class(TWinControl);

