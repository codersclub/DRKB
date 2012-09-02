<h1>TPaintBox в буфер обмена</h1>
<div class="date">01.01.2007</div>

Автор: Xavier Pacheco </p>
<pre>
var
  pbRect: TRect;
begin
  pbRect := Rect(0, 0, PaintBox1.Width, PaintBox1.Height);
  BitMap := TBitMap.Create;
  try
    Bitmap.Width := PaintBox1.Width;
    Bitmap.Height := PaintBox1.Height;
    BitMap.Canvas.CopyRect(pbRect, PaintBox1.Canvas, pbRect);
    ClipBoard.Assign(BitMap);
  finally
    BitMap.Free;
  end;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

