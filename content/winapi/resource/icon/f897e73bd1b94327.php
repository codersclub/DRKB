<h1>Проблемы с TCanvas.StretchDraw при рисовании иконок</h1>
<div class="date">01.01.2007</div>


<p>При попытке использовать метод TCanvas.StretchDraw чтобы нарисовать иконку</p>
<p>увеличенной ее размер не изменяется. Что делать?</p>

<p>Иконки всегда рисуются размером принятым в системе по умолчанию. Чтобы показать увеличенный вид иконки скоприуйте ее на bitmap, а зате используйте метод TCanvas.StretchDraw.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  TheBitmap: TBitmap;
begin
  TheBitmap := TBitmap.Create;
  TheBitmap.Width := Application.Icon.Width;
  TheBitmap.Height := Application.Icon.Height;
  TheBitmap.Canvas.Draw(0, 0, Application.Icon);
  Form1.Canvas.StretchDraw(Rect(0, 0, TheBitmap.Width * 3, TheBitmap.Height * 3),
    TheBitmap);
  TheBitmap.Free;
end;
</pre>

