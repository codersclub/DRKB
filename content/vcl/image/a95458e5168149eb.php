<h1>Как сделать картинки в TImageList прозрачными</h1>
<div class="date">01.01.2007</div>

procedure TForm1.Button1Click(Sender: TObject);</p>
<p>var</p>
<p>    bm : TBitmap;</p>
<p>    il : TImageList;</p>
<p>begin</p>
<p>    bm := TBitmap.Create;</p>
<p>    bm.LoadFromFile('C:\DownLoad\TEST.BMP');</p>
<p>    il := TImageList.CreateSize(bm.Width,bm.Height);</p>
<p>    il.DrawingStyle := dsTransparent;</p>
<p>    il.Masked := true;</p>
<p>    il.AddMasked(bm, clRed);</p>
<p>    il.Draw(Form1.Canvas, 0, 0, 0);</p>
<p>    bm.Free;</p>
<p>    il.Free;</p>
<p>end;</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
</p>
</p>
