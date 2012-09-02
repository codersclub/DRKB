<h1>Рисование квадрата мышкой</h1>
<div class="date">01.01.2007</div>


<pre>
private
   { Private declarations }
   AnchorX, AnchorY,
   CurX, CurY: Integer;
   Bounding: Boolean;
 end;
 
 implementation
 
 procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
   Shift: TShiftState; X, Y: Integer);
 begin
   AnchorX := X;
   CurX := X;
   AnchorY  := Y;
    CurY := Y;
   Bounding := True;
 end;
 
 procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X,
   Y: Integer);
 begin
   if Bounding then
    begin
     Canvas.Pen.Mode := pmNot;
     Canvas.Pen.Width := 2;
     Canvas.Brush.Style := bsClear;
     Canvas.Rectangle(AnchorX, AnchorY, CurX, CurY);
     CurX := X;
      CurY := Y;
     Canvas.Rectangle(AnchorX, AnchorY, CurX, CurY);
   end;
 end;
 
 procedure TForm1.FormMouseUp(Sender: TObject; Button: TMouseButton;
   Shift: TShiftState; X, Y: Integer);
 begin
   if Bounding then
    begin
     Bounding := False;
     Canvas.Pen.Mode := pmNot;
     Canvas.Brush.Style := bsClear;
     Canvas.Rectangle(AnchorX, AnchorY, CurX, CurY);
   end;
 end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
