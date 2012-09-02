<h1>Кнопка с закругленными краями</h1>
<div class="date">01.01.2007</div>


<pre>
unit RVButton;
 
 interface
 
 uses
   SysUtils, Classes, Controls, Messages, Graphics, Windows;
 
 const
   iOffset = 3;
 
 type
   TRVButton = class(TGraphicControl)
   private
     FCaption : string;
     FButtonColor: TColor;
     FLButtonDown: boolean;
     FBtnPoints : array[1..2] of TPoint;
     FKRgn : HRgn;
     procedure SetCaption(Value: string);
     procedure SetButtonColor(Value: TColor);
     procedure FreeRegion;
   protected
     procedure Paint; override;
     procedure DrawCircle;
     procedure MoveButton;
     procedure WMLButtonDown(var Message: TWMLButtonDown); message WM_LBUTTONDOWN;
     procedure WMLButtonUp(var Message: TWMLButtonUp); message WM_LBUTTONUP;
   public
     constructor Create(AOwner: TComponent); override;
     destructor Destroy; override;
   published
     property ButtonColor: TColor read FButtonColor write SetButtonColor;
     property Caption: string read FCaption write SetCaption;
     property Enabled;
     property Font;
     property ParentFont;
     property ParentShowHint;
     property ShowHint;
     property Visible;
     property OnClick;
   end;
 
 procedure Register;
 
 implementation
 
 procedure Register;
 begin
   RegisterComponents('Samples', [TRVButton]);
 end;
 
 { TRVButton }
 
 constructor TRVButton.Create(AOwner: TComponent);
 begin
   inherited Create(AOwner);
   ControlStyle := [csClickEvents,csCaptureMouse];
   Width := 50;
   Height := 50;
   FButtonColor := clBtnFace;
   FKRgn := 0;
   FLButtonDown := False;
 end;
 
 destructor TRVButton.Destroy;
 begin
   if FKRgn &lt;&gt; 0 then FreeRegion;
   inherited Destroy;
 end;
 
 procedure TRVButton.DrawCircle;
 begin
   FBtnPoints[1] := Point(iOffset,iOffset);
   FBtnPoints[2] := Point(Width - iOffset,Height - iOffset);
   FKRgn := CreateEllipticRgn(FBtnPoints[1].x,FBtnPoints[1].y,FBtnPoints[2].x,FBtnPoints[2].y);
   Canvas.Brush.Color := FButtonColor;
   FillRgn(Canvas.Handle,FKRgn,Canvas.Brush.Handle);
   MoveButton;
 end;
 
 procedure TRVButton.FreeRegion;
 begin
   if FKRgn &lt;&gt; 0 then DeleteObject(FKRgn);
   FKRgn := 0;
 end;
 
 procedure TRVButton.MoveButton;
 var
   Color1: TColor;
   Color2: TColor;
 begin
   with Canvas do
     begin
     if not FLButtonDown then
       begin
       Color1 := clBtnHighlight;
       Color2 := clBtnShadow;
       end
     else
       begin
       Color1 := clBtnShadow;
       Color2 := clBtnHighLight;
       end;
 
       Pen.Width := 1;
 
       if FLButtonDown then Pen.Color := clBlack
       else                 Pen.Color := Color2;
 
       Ellipse(FBtnPoints[1].x - 2,FBtnPoints[1].y - 2,FBtnPoints[2].x + 2,FBtnPoints[2].y + 2);
 
       if not FLButtonDown then Pen.Width := 2
       else                     Pen.Width := 1;
 
       Pen.Color := Color1;
 
       Arc(FBtnPoints[1].x,FBtnPoints[1].y,FBtnPoints[2].x,FBtnPoints[2].y,
           FBtnPoints[2].x,FBtnPoints[1].y,FBtnPoints[1].x,FBtnPoints[2].y);
 
       Pen.Color := Color2;
 
       Arc(FBtnPoints[1].x,FBtnPoints[1].y,FBtnPoints[2].x,FBtnPoints[2].y,
           FBtnPoints[1].x,FBtnPoints[2].y,FBtnPoints[2].x,FBtnPoints[1].y);
       end;
 
   SetCaption('');
 end;
 
 procedure TRVButton.Paint;
 begin
   inherited Paint;
   FreeRegion;
   DrawCircle;
 end;
 
 procedure TRVButton.SetButtonColor(Value: TColor);
 begin
   if Value &lt;&gt; FButtonColor then
     begin
     FButtonColor := Value;
     Invalidate;
     end;
 end;
 
 procedure TRVButton.SetCaption(Value: string);
 var
   X: Integer;
   Y: Integer;
 begin
   if ((Value &lt;&gt; FCaption) and (Value &lt;&gt; '')) then
   begin
     FCaption := Value;
   end;
 
   with Canvas.Font do
   begin
     Name  := Font.Name;
     Size  := Font.Size;
     Style := Font.Style;
     if Self.Enabled then Color := Font.Color
     else
       Color := clDkGray;
   end;
 
   X := (Width div 2) - (Canvas.TextWidth(FCaption) div 2);
   Y := (Height div 2) - (Canvas.TextHeight(FCaption) div 2);
   Canvas.TextOut(X, Y, FCaption);
   //  Invalidate; 
end;
 
 
 procedure TRVButton.WMLButtonDown(var Message: TWMLButtonDown);
 begin
   if not PtInRegion(FKRgn,Message.xPos,Message.yPos) then exit;
   FLButtonDown := True;
   MoveButton;
   inherited;
 end;
 
 procedure TRVButton.WMLButtonUp(var Message: TWMLButtonUp);
 begin
   if not FLButtonDown then exit;
   FLButtonDown := False;
   MoveButton;
   inherited;
 end;
 
 
 end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
