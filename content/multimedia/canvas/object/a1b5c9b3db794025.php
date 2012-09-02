<h1>Рисование графов</h1>
<div class="date">01.01.2007</div>


<p>...вы могли бы использовать объект TCanvas, чем рисовать самому. В вашем случае сгодится компонент TImage, он имеет bitmap и свойство canvas, на котором очень удобно рисовать. </p>

<p>Пример: (Создайте новую форму, добавьте к ней Image и Button. Добавьте следующий код к обработчику события нажатия кнопки)</p>

<pre>
var
  x, l: Integer;
  y, a: Double;
begin
  Image1.Picture.Bitmap := TBitmap.Create;
  Image1.Picture.Bitmap.Width := Image1.Width;
  Image1.Picture.Bitmap.Height := Image1.Height; {Эти три строчки могут быть
  размещены в обработчике Form1.Create}
  l := Image1.Picture.Bitmap.Width;
  for x := 0 to l do
  begin
    a := (x / l) * 2 * Pi; {Преобразуем позицию по оси X к углу между 0 &amp; 2Pi}
    y := Sin(a); {Ваша функция должна находиться здесь}
    y := y * (Image1.Picture.Bitmap.Height / 2); {Масштабируем по оси Y}
    y := y * -1; {Инвертируем Y, верх экрана это 0 !}
    y := y + (Image1.Picture.Bitmap.Height / 2);
      {Добавляем компенсацию для среднего 0}
    Image1.Picture.Bitmap.Canvas.Pixels[Trunc(x), Trunc(y)] := clBlack;
  end;
end;
</pre>




<p>Я обнаружил, что лучшим решением будет рисование на холсте. Предпочтительно делать это в отдельной процедуре, которая принимает в качестве параметров TCanvas и TRect. Таким способом мы может передать в качестве параметров холст вашего окна и клиентскую область для рисования на экране, и холст принтера и область клиента для ее позиционирования и печати. Чтобы посмотреть доступные для рисования подпрограммы, взгляните на методы холста.</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
