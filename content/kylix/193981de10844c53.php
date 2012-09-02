<h1>Как нарисовать повернутый текст?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  QT; 
 
procedure TForm1.RotatedText(Cnv: TCanvas; Wkl: Integer; Pxy: TPoint; Txt: string); 
var 
  PrPoint: TPoint; 
begin 
  // Rotate Canvas 
  QPainter_rotate(Cnv.Handle, Wkl); 
  // Convert Device Coord. to Modell- Coord. 
  QPainter_xFormDev(Cnv.Handle, PPoint(@PrPoint), 
    PPoint(@Pxy)); 
  // Write text. 
  Canvas.TextOut(PrPoint.X, PrPoint.Y, 'Txt'); 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
