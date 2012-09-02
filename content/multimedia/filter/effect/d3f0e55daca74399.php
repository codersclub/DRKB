<h1>Конвертация bitmap в sepia или greyscale</h1>
<div class="date">01.01.2007</div>


<pre>
//This function adds a sepia effect to a bitmap.
//the 'depth' sets the colour intensity of the red-brown colour
//greater numbers set a higher intensity.
//To create a greyscale effect instead, set 'depth' to 0
 
function bmptosepia(const bmp: TBitmap; depth: Integer): Boolean;
var
color,color2:longint;
r,g,b,rr,gg:byte;
h,w:integer;
begin
  for h := 0 to bmp.height do
  begin
    for w := 0 to bmp.width do
    begin
//first convert the bitmap to greyscale
    color:=colortorgb(bmp.Canvas.pixels[w,h]);
    r:=getrvalue(color);
    g:=getgvalue(color);
    b:=getbvalue(color);
    color2:=(r+g+b) div 3;
    bmp.canvas.Pixels[w,h]:=RGB(color2,color2,color2);
//then convert it to sepia
    color:=colortorgb(bmp.Canvas.pixels[w,h]);
    r:=getrvalue(color);
    g:=getgvalue(color);
    b:=getbvalue(color);
    rr:=r+(depth*2);
    gg:=g+depth;
    if rr &lt;= ((depth*2)-1) then
    rr:=255;
    if gg &lt;= (depth-1) then
    gg:=255;
    bmp.canvas.Pixels[w,h]:=RGB(rr,gg,b);
    end;
  end;
end;
</pre>

<pre>
//Example:
procedure TForm1.Button1Click(Sender: TObject);
begin
  bmptosepia(image1.picture.bitmap, 20);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
