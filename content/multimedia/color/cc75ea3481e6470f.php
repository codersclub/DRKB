<h1>Как преобразовать цвета RGB в CMYK и обратно?</h1>
<div class="date">01.01.2007</div>


<p>The following functions RGBTOCMYK() and CMYKTORGB()</p>
<p>demonstrate how to convert between RGB and CMYK color</p>
<p>spaces. Note: There is a direct relationship between RGB</p>
<p>colors and CMY colors. In a CMY color, black tones are</p>
<p>achieved by printing equal amounts of Cyan, Magenta, and</p>
<p>Yellow ink. The black component in a CMY color is achieved</p>
<p>by reducing the CMY components by the minimum of (C, M,</p>
<p>and Y) and substituting pure black in its place producing a</p>
<p>sharper print and using less ink. Since it is possible for a user</p>
<p>to boost the C,M and Y components where boosting the black</p>
<p>component would have been preferable, a ColorCorrectCMYK()</p>
<p>function is provided to achieve the same color by reducing the</p>
<p>C, M and Y components, and boosting the K component.</p>

<p>Example:</p>

<pre>
procedure RGBTOCMYK(R : byte;
                   G : byte;
                   B : byte;
                   var C : byte;
                   var M : byte;
                   var Y : byte;
                   var K : byte);
begin
 C := 255 - R;
 M := 255 - G;
 Y := 255 - B;
 if C &lt; M then
   K := C else
   K := M;
 if Y &lt; K then
   K := Y;
 if k &gt; 0 then begin
   c := c - k;
   m := m - k;
   y := y - k;
 end;
end;
 
procedure CMYKTORGB(C : byte;
                   M: byte;
                   Y : byte;
                   K : byte;
                   var R : byte;
                   var G : byte;
                   var B : byte);
begin
  if (Integer(C) + Integer(K)) &lt; 255 then
    R := 255 - (C + K) else
    R := 0;
  if (Integer(M) + Integer(K)) &lt; 255 then
    G := 255 - (M + K) else
    G := 0;
  if (Integer(Y) + Integer(K)) &lt; 255 then
    B := 255 - (Y + K) else
    B := 0;
end;
 
procedure ColorCorrectCMYK(var C : byte;
                          var M : byte;
                          var Y : byte;
                          var K : byte);
var
 MinColor : byte;
begin
 if C &lt; M then
   MinColor := C else
   MinColor := M;
 if Y &lt; MinColor  then
   MinColor := Y;
 if MinColor + K &gt; 255 then
   MinColor := 255 - K;
 C := C - MinColor;
 M := M - MinColor;
 Y := Y - MinColor;
 K := K + MinColor;
end;
</pre>


<div class="author">Автор: p0s0l</div>
