<h1>Шапка в TDBGrid</h1>
<div class="date">01.01.2007</div>


<p>Уже реализовано в виде вот этого компонента</p>

<pre>
unit bdbgrid;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
    Grids, DBGrids, Math;
 
type
  TOnDrawTitleEvent = procedure(ACol: integer; ARect: TRect; var TitleText:
    string) of object;
 
  TBitDBGrid = class(TDBGrid)
  private
    FBitmapBrowse: TBitmap;
    FBitmapEdit: TBitmap;
    FBitmapInsert: TBitmap;
    FBitmapFill: TBitmap;
    FRealTitleFont: TFont;
    FOnDrawTitle: TOnDrawTitleEvent;
    FResizeFlag: boolean;
    { Private declarations }
    procedure SetRealTitleFont(Value: TFont);
    procedure UpdateTitlesHeight;
  protected
    procedure DrawCell(ACol, ARow: Longint; ARect: TRect; AState:
      TGridDrawState); override;
    procedure MouseDown(Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
      override;
    procedure MouseUp(Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
      override;
    { Protected declarations }
  public
    constructor Create(AOwner: TComponent); override;
    destructor Destroy; override;
    { Public declarations }
  published
    property OnDrawTitle: TOnDrawTitleEvent read FOnDrawTitle write
      FOnDrawTitle;
    property RealTitleFont: TFont read FRealTitleFont write SetRealTitleFont;
    { Published declarations }
  end;
 
procedure Register;
 
implementation
 
var
  DrawBitmap: TBitmap;
 
function Max(X, Y: Integer): Integer;
begin
  Result := Y;
  if X &gt; Y then
    Result := X;
end;
 
procedure WriteText(ACanvas: TCanvas; ARect: TRect; DX, DY: Integer; const Text:
  string; Alignment: TAlignment);
// © Borland function :)
const
  AlignFlags: array[TAlignment] of Integer =
  (DT_LEFT or DT_WORDBREAK or DT_EXPANDTABS or DT_NOPREFIX,
    DT_RIGHT or DT_WORDBREAK or DT_EXPANDTABS or DT_NOPREFIX,
    DT_CENTER or DT_WORDBREAK or DT_EXPANDTABS or DT_NOPREFIX);
var
  B, R: TRect;
  I, Left: Integer;
begin
  with DrawBitmap, ARect do { Use offscreen bitmap to eliminate flicker and }
  begin { brush origin tics in painting / scrolling. }
    Width := Max(Width, Right - Left);
    Height := Max(Height, Bottom - Top);
    R := Rect(DX, DY, Right - Left - 1, Bottom - Top - 1);
    B := Rect(0, 0, Right - Left, Bottom - Top);
  end;
  with DrawBitmap.Canvas do
  begin
    DrawBitmap.Canvas.CopyRect(B, ACanvas, ARect);
    Font := ACanvas.Font;
    Font.Color := ACanvas.Font.Color;
    Brush := ACanvas.Brush;
    SetBkMode(Handle, TRANSPARENT);
    DrawText(Handle, PChar(Text), Length(Text), R,
      AlignFlags[Alignment]);
  end;
  ACanvas.CopyRect(ARect, DrawBitmap.Canvas, B);
end;
 
constructor TBitDBGrid.Create(AOwner: TComponent);
begin
  inherited Create(Aowner);
  FRealTitleFont := TFont.Create;
  FResizeFlag := false;
end;
 
destructor TBitDBGrid.Destroy;
begin
  FRealTitleFont.Free;
  inherited Destroy;
end;
 
procedure TBitDBGrid.UpdateTitlesHeight;
var
  Loop: integer;
  MaxTextHeight: integer;
  RRect: TRect;
begin
  MaxTextHeight := 0;
  for loop := 0 to Columns.Count - 1 do
  begin
    RRect := CellRect(0, 0);
    RRect.Right := Columns[Loop].Width;
    RRect.Left := 0;
    Canvas.Font := RealTitleFont;
    MaxTextHeight := Max(MaxTextHeight, DrawText(Canvas.Handle,
      PChar(Columns[Loop].Title.Caption),
      Length(Columns[Loop].Title.Caption), RRect,
      DT_CALCRECT + DT_WORDBREAK)
      );
  end;
  if TitleFont.Height &lt;&gt; -MaxTextHeight then
    TitleFont.Height := -MaxTextHeight;
end;
 
procedure TBitDBGrid.MouseDown(Button: TMouseButton; Shift: TShiftState; X, Y:
  Integer);
begin
  if MouseCoord(X, Y).Y = 0 then
    FResizeFlag := true;
  inherited MouseDown(Button, Shift, X, Y);
end;
 
procedure TBitDBGrid.MouseUp(Button: TMouseButton; Shift: TShiftState; X, Y:
  Integer);
begin
  inherited MouseUp(Button, Shift, X, Y);
  if FResizeFlag then
  begin
    FResizeFlag := false;
    UpdateTitlesHeight;
  end;
end;
 
procedure TBitDBGrid.DrawCell(ACol, ARow: Longint; ARect: TRect; AState:
  TGridDrawState);
var
  Indicator: TBitmap;
  TitleText: string;
  Al: TAlignment;
begin
  if not ((gdFixed in AState) and ((ARow = 0) and (dgTitles in Options) and (ACol
    &lt;&gt; 0))) then
    inherited DrawCell(ACol, ARow, ARect, AState)
  else
  begin
    if DefaultDrawing then
    begin
      DrawEdge(Canvas.Handle, ARect, BDR_RAISEDINNER, BF_BOTTOMLEFT);
      DrawEdge(Canvas.Handle, ARect, BDR_RAISEDINNER, BF_TOPRIGHT);
      InflateRect(ARect, -1, -1);
      Canvas.Brush.Color := FixedColor;
      Canvas.FillRect(ARect);
    end;
    TitleText := Columns[ACol - 1].Title.Caption;
    if Assigned(OnDrawTitle) then
      OnDrawTitle(ACol, ARect, TitleText);
    if DefaultDrawing and (TitleText &lt;&gt; '') then
    begin
      Canvas.Brush.Style := bsClear;
      Canvas.Font := RealTitleFont;
      if ACol &gt; 0 then
        Al := Columns[ACol - 1].Title.Alignment
      else
        Al := Columns[0].Title.DefaultAlignment;
      WriteText(Canvas, ARect, 2, 2, TitleText, Al);
    end;
  end;
end;
 
procedure TBitDBGrid.SetRealTitleFont(Value: TFont);
begin
  FRealTitleFont.Assign(Value);
  Repaint;
end;
 
procedure Register;
begin
  RegisterComponents('Andre VCL', [TBitDBGrid]);
end;
 
initialization
  DrawBitmap := TBitmap.Create;
 
finalization
  DrawBitmap.Free;
 
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
