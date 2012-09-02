<h1>CUR &gt; BMP</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  hCursor: LongInt;
  Bitmap: TBitmap;
begin
  Bitmap := TBitmap.Create;
  Bitmap.Width := 32;
  Bitmap.Height := 32;
  hCursor := LoadCursorFromFile('test.cur');
  DrawIcon(Bitmap.Canvas.Handle, 0, 0, hCursor);
  Bitmap.SaveToFile('test.bmp');
  Bitmap.Free;
end;
</pre>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

