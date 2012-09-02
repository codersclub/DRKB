<h1>Bitmap в TStringGrid-ячейке</h1>
<div class="date">01.01.2007</div>

В обработчике события OnDrawCell элемента StringGrid поместите следующий код: </p>
<pre>
with (Sender as TStringGrid) do
  with Canvas do
  begin
    {...}
    Draw(Rect.Left, Rect.Top, Image1.Picture.Graphic);
    {...}
  end;
</pre>

<p>Используйте метод Draw() или StretchDraw() класса TCanvas. Image1 - это TImage с предварительно загруженным в него bitmap-ом. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
