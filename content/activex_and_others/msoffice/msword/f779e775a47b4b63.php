<h1>Как работать с Shapes</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ ... }
var
  Pic: Word2000.Shape;
  Left, Top: OleVariant;
  { ... }
 
{To add a pic and make it appear behind text}
Left := 100;
Top := 100;
Pic := Doc.Shapes.AddPicture('C:\Small.bmp', EmptyParam, EmptyParam, Left, Top,
  EmptyParam, EmptyParam, EmptyParam);
Pic.WrapFormat.Type_ := wdWrapNone;
Pic.ZOrder(msoSendBehindText);
{To get a watermark effect}
Pic.PictureFormat.Brightness := 0.75;
Pic.PictureFormat.Contrast := 0.20;
{To make any white in a picture transparent}
Pic.PictureFormat.TransparencyColor := clWhite;
Pic.PictureFormat.TransparentBackground := msoTrue;
Pic.Fill.Visible := msoFalse;
{ ... }
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
