<h1>Получить цвет пикселя на рабочем столе</h1>
<div class="date">01.01.2007</div>


<pre>
function DesktopColor(const X, Y: Integer): TColor;
 var
   c: TCanvas;
 begin
   c := TCanvas.Create;
   try
     c.Handle := GetWindowDC(GetDesktopWindow);
     Result   := GetPixel(c.Handle, X, Y);
   finally
     c.Free;
   end;
 end;
 
 procedure TForm1.Timer1Timer(Sender: TObject);
 var
   Pos: TPoint;
 begin
   GetCursorPos(Pos);
   Panel1.Color := DesktopColor(Pos.X, Pos.Y);
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
