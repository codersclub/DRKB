<h1>Эффект разбрызгивания</h1>
<div class="date">01.01.2007</div>


<pre>
procedure Spray(Canvas: TCanvas; x, y, r: Integer; Color: TColor);
 var
   rad, a: Single;
   i: Integer;
 begin
   for i := 0 to 100 do
   begin
     a   := Random * 2 * pi;
     rad := Random * r;
     Canvas.Pixels[x + Round(rad * Cos(a)), y + Round(rad * Sin(a))] := Color;
   end;
 end;
 
 procedure TForm1.Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
   Y: Integer);
 begin
   if ssLeft in Shift then Spray(Image1.Canvas, x, y, 40, clRed);
 end;
 
 procedure TForm1.Image1MouseDown(Sender: TObject; Button: TMouseButton;
   Shift: TShiftState; X, Y: Integer);
 begin
   if ssLeft in Shift then Spray(Image1.Canvas, x, y, 40, clRed);
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
