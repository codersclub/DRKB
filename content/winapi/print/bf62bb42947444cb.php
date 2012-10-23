<h1>Печать с масштабированием</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
// © Song
Var ScaleX, ScaleY: Integer;
Begin
 Printer.BeginDoc;
 With Printer Do
  try
   ScaleX:=GetDeviceCaps(Handle,LogPixelsX) div PixelsPerInch;
   ScaleY:=GetDeviceCaps(Handle,LogPixelsY) div PixelsPerInch;
   Canvas.StretchDraw(Rect(0,0,Image1.Picture.Width*ScaleX,Image1.Picture.Height*ScaleY),Image1.Picture.Graphic);
  finally
   EndDoc;
  end;
End;
</pre>

<div class="author">Автор: Song</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

