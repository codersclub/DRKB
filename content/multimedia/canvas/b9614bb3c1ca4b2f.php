<h1>Как создать временный Canvas?</h1>
<div class="date">01.01.2007</div>


<p>Создайте Bitmap, и воспользуйтесь свойством холста TBitmap-а, чтобы рисовать на нём. Следующий пример создаёт Bitmap, рисует на его canvas-е, рисует canvas на форме, а затем освобождает bitmap.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject); 
var 
  bm : TBitmap; 
begin 
  bm := TBitmap.Create; 
  bm.Width := 100; 
  bm.Height := 100; 
  bm.Canvas.Brush.Color := clRed; 
  bm.Canvas.FillRect(Rect(0, 0, 100, 100)); 
  bm.Canvas.MoveTo(0, 0); 
  bm.Canvas.LineTo(100, 100); 
  Form1.Canvas.StretchDraw(Form1.ClientRect, Bm); 
  bm.Free; 
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

