<h1>Show text progressively as typed with a typewriter (horizontal/vertical)</h1>
<div class="date">01.01.2007</div>


<pre>
{
 To make this code to work you would need 2 images,
 one for the horizontal- and another for the vertical text.
}
 
// VerticalTypewriter ( &lt;Text&gt;, &lt;Image to write to&gt;, &lt;Time to delay between every chars&gt; )
procedure VerticalTypewriter(text: string; image: timage; delay: integer);
var
 x,y,i: integer;
begin
 image.Canvas.Refresh;
 application.ProcessMessages;
 y := 1;
 
 for i := 1 to length(text) do begin
  application.ProcessMessages;
  y := y+image.Canvas.TextHeight(text[i]);
  x := image.width div 2 - (image.Canvas.TextWidth(text[i]) div 2);
  image.Canvas.TextOut(x,y,text[i]);
  sleep(delay);
 end;
 
end;
 
// Horizontal Typewriter ( &lt;Text&gt;, &lt;Image to write to&gt;, &lt;Time to delay between every chars&gt;, &lt;Space between chars&gt;)
procedure HorizontalTypewriter(text: string; image: timage; delay, space: integer);
var
 x,y,i: integer;
begin
 image.Canvas.Refresh;
 application.ProcessMessages;
 x := 1;
 
 for i := 1 to length(text) do begin
  application.ProcessMessages;
  y := image.Picture.Height div 2 - (image.Canvas.TextHeight(text[i]) div 2);
  x := x+image.Canvas.TextWidth(text[i])+space;
  image.Canvas.TextOut(x,y,text[i]);
  sleep(delay);
 end;
 
end;
 
 
// Sample calls:
procedure TForm1.Button1Click(Sender: TObject);
begin
 //                  &lt;text&gt;          &lt;image&gt;  &lt;delay&gt;
 VerticalTypewriter('HELLO BIG-X',   image1,  100     );
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
 //                    &lt;text&gt;         &lt;image&gt;  &lt;delay&gt;  &lt;space&gt;
 HorizontalTypewriter('Hello Big-X',  image2,  100,     1       );
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
