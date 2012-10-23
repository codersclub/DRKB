<h1>Как разместить прозрачную надпись на TBitmap?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
        OldBkMode : integer;
begin
        Image1.Picture.Bitmap.Canvas.Font.Color := clBlue;
        OldBkMode := SetBkMode(Image1.Picture.Bitmap.Canvas.Handle,TRANSPARENT);
        Image1.Picture.Bitmap.Canvas.TextOut(10, 10, 'Hello');
        SetBkMode(Image1.Picture.Bitmap.Canvas.Handle,OldBkMode);
end;
</pre>

<p>Взято из</p>
DELPHI VCL FAQ Перевод с английского &nbsp; &nbsp; &nbsp; 
<p>Подборку, перевод и адаптацию материала подготовил Aziz(JINX)</p>
<p>специально для <a href="https://delphi.vitpc.com/" target="_blank">Королевства Дельфи</a></p>

