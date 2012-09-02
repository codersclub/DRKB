<h1>Как найти контрастный цвет к данному?</h1>
<div class="date">01.01.2007</div>


<pre>
function FindContrastingColor(Color: TColor): TColor;
var
  R, G, B: Byte;
begin
  R := GetRValue(Color);
  G := GetGValue(Color);
  B := GetBValue(Color);
  if (R &lt; 128) then
    R := 255
  else
    R := 0;
  if (G &lt; 128) then
    G := 255
  else
    G := 0;
  if (B &lt; 128) then
    B := 255
  else
    B := 0;
  Result := RGB(R, G, B);
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>


