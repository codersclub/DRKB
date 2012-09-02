<h1>Расширенный TLabel для отображения имени файла</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;

interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;
 
type
  TForm1 = class(TForm)
    Label1: TLabel;
    procedure FormCreate(Sender: TObject);
  end;
 
var
  Form1: TForm1;
 
implementation
 
uses Types;
 
{$R *.dfm}
 
type
  TPathLabel = class(TLabel)
  private
    FHintWindow: THintWindow;
    procedure CMHintShow(var Message: TMessage); message CM_HINTSHOW;
    procedure CMTextChanged(var Message: TMessage); message CM_TEXTCHANGED;
    procedure CMMouseEnter(var Message: TMessage); message CM_MOUSEENTER;
    procedure CMMouseLeave(var Message: TMessage); message CM_MOUSELEAVE;    
  protected
    procedure Paint; override;
  public
    constructor Create(AOwner: TComponent); override;
  end;
 
{ TPathLabel }
 
procedure TPathLabel.CMHintShow(var Message: TMessage);
var
  P: TPoint;
  R: TRect;
begin
  Message.Result := 1;
end;
 
procedure TPathLabel.CMMouseEnter(var Message: TMessage);
var
  P: TPoint;
  R: TRect;
  W: Integer;
begin
  W := Canvas.TextWidth(Caption);
  if W &gt; ClientWidth then
  begin
    P := ClientToScreen(Point(0, 0));
    R := ClientRect;
    R := Rect(P.X, P.Y,
              P.X + W + 5,
              P.Y + ClientHeight);
 
    FHintWindow.ActivateHint(R, Caption);
    Message.Result := 1;
  end;
 
  inherited;
end;
 
procedure TPathLabel.CMMouseLeave(var Message: TMessage);
begin
  FHintWindow.ReleaseHandle;
 
  inherited;
end;
 
procedure TPathLabel.CMTextChanged(var Message: TMessage);
begin
  if Canvas.TextWidth(Caption) &gt; ClientWidth then
  begin
    ShowHint := True;
    Hint := Caption;
  end else begin
    ShowHint := False;
    Hint := '';
  end;
 
  inherited;
end;
 
constructor TPathLabel.Create(AOwner: TComponent);
begin
  inherited Create(AOwner);
 
  AutoSize := False;
  FHintWindow := THintWindow.Create(Self);
  FHintWindow.Color := Application.HintColor;
end;
 
procedure TPathLabel.Paint;
var
  R: TRect;
begin
  R := ClientRect;
  if Transparent then
    Canvas.Brush.Style := bsClear
  else begin
    Canvas.Brush.Style := bsSolid;
    Canvas.Brush.Color := Color;
  end;
  DrawText(Canvas.Handle, PChar(Caption), -1, R, DT_PATH_ELLIPSIS);
end;
 
procedure TForm1.FormCreate(Sender: TObject);
var
  R: TRect;
begin
  R := Label1.BoundsRect;
  Inc(R.Top, 50);
  Inc(R.Bottom, 50);
  with TPathLabel.Create(Self) do
  begin
    Parent := Self;
    Color := clLime;
    BoundsRect := R;
    Caption := Label1.Caption;
  end;
end;
 
end.
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p class="author">Автор: Smike</p>
