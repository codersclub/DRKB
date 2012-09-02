<h1>Как сделать картинки в TImageList прозрачными</h1>
<div class="date">01.01.2007</div>

procedure TForm1.Button1Click(Sender: TObject);</p>
<p>var</p>
<p>  &nbsp; bm : TBitmap;</p>
<p>  &nbsp; il : TImageList;</p>
<p>begin</p>
<p>  &nbsp; bm := TBitmap.Create;</p>
<p>  &nbsp; bm.LoadFromFile('C:\DownLoad\TEST.BMP');</p>
<p>  &nbsp; il := TImageList.CreateSize(bm.Width,bm.Height);</p>
<p>  &nbsp; il.DrawingStyle := dsTransparent;</p>
<p>  &nbsp; il.Masked := true;</p>
<p>  &nbsp; il.AddMasked(bm, clRed);</p>
<p>  &nbsp; il.Draw(Form1.Canvas, 0, 0, 0);</p>
<p>  &nbsp; bm.Free;</p>
<p>  &nbsp; il.Free;</p>
<p>end;</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
&nbsp;</p>
&nbsp;</p>
