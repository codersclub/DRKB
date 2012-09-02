<h1>Как сделать картинки из TImageList прозрачными?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  bm: TBitmap;
  il: TImageList;
begin
  bm := TBitmap.Create;
  bm.LoadFromFile('C:\DownLoad\TEST.BMP');
  il := TImageList.CreateSize(bm.Width, bm.Height);
  il.DrawingStyle := dsTransparent;
  il.Masked := true;
  il.AddMasked(bm, clRed);
  il.Draw(Form1.Canvas, 0, 0, 0);
  bm.Free;
  il.Free;
end;
</pre>

