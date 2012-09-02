<h1>Изменяем цвет TPageControl</h1>
<div class="date">01.01.2007</div>


<pre>
type 
  TTabSheet = class(ComCtrls.TTabSheet) 
  private 
    FColor: TColor; 
    procedure SetColor(Value: TColor); 
    procedure WMEraseBkGnd(var Msg: TWMEraseBkGnd); 
      message WM_ERASEBKGND; 
  public 
    constructor Create(aOwner: TComponent); override; 
    property Color: TColor read FColor write SetColor; 
  end; 
 
  {...} 
 implementation 
{...} 
 
constructor TTabSheet.Create(aOwner: TComponent); 
begin 
  inherited; 
  FColor := clBtnFace; 
end; 
 
procedure TTabSheet.SetColor(Value: TColor); 
begin 
  if FColor  Value then  
  begin 
    FColor := Value; 
    Invalidate; 
  end; 
end; 
 
procedure TTabSheet.WMEraseBkGnd(var Msg: TWMEraseBkGnd); 
begin 
  if FColor = clBtnFace then 
    inherited 
  else  
  begin 
    Brush.Color := FColor; 
    Windows.FillRect(Msg.dc, ClientRect, Brush.Handle); 
    Msg.Result := 1; 
  end; 
end; 
 
procedure TForm1.FormCreate(Sender: TObject); 
begin 
  Tabsheet1.Color := clWhite; 
  TabSheet2.Color := clLime; 
end; 
 
// PageControl1.OwnerDraw := true ! 
 
procedure TForm1.PageControl1DrawTab(Control: TCustomTabControl; 
  TabIndex: Integer; const Rect: TRect; Active: Boolean); 
var 
  AText: string; 
  APoint: TPoint; 
begin 
  with (Control as TPageControl).Canvas do 
  begin 
    Brush.Color := clred; 
    FillRect(Rect); 
    AText := TPageControl(Control).Pages[TabIndex].Caption; 
    with Control.Canvas do 
    begin 
      APoint.x := (Rect.Right - Rect.Left) div 2 - TextWidth(AText) div 2; 
      APoint.y := (Rect.Bottom - Rect.Top) div 2 - TextHeight(AText) div 2; 
      TextRect(Rect, Rect.Left + APoint.x, Rect.Top + APoint.y, AText); 
    end; 
  end; 
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
