<h1>Как вставить картинку</h1>
<div class="date">01.01.2007</div>



<p>Answer:</p>

<p>If WS is your worksheet:</p>

<pre>
{ ... }
WS.Shapes.AddPicture('C:\Pictures\Small.Bmp', EmptyParam, EmptyParam, 10, 160,
  EmptyParam, EmptyParam);
</pre>

<p>or</p>
<pre>
{ ... }
var
  Pics: Excel2000.Pictures; {or whichever Excel}
  Pic: Excel2000.Picture;
  Pic: Excel2000.Shape;
  Left, Top: integer;
{ ... }
Pics := (WS.Pictures(EmptyParam, 0) as Pictures);
Pic := Pics.Insert('C:\Pictures\Small.Bmp', EmptyParam);
Pic.Top := WS.Range['D4', 'D4'].Top;
Pic.Left := WS.Range['D4', 'D4'].Left;
{ ... }
</pre>


<p>EmptyParam a special variant (declared in Variants.pas in D6+). However in later versions of Delphi some conversions cause problems. This should work:</p>
<pre>
uses
  OfficeXP;
 
{ ... }
WS.Shapes.AddPicture('H:\Pictures\Game\Hills.bmp', msoFalse, msoTrue, 10, 160, 100,
  100);
</pre>


<p>But you may have to use a TBitmap to find out how large the picture should be.</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
