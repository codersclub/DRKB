<h1>Как поместить графическое изображение в TDBGrid?</h1>
<div class="date">01.01.2007</div>


<p>Использование свойства Canvas компонента TDBGrid в методе OnDrawColumnCell позволяет не только выводить в ячейке текст методом TextOut, но и размещать в ячейках графические изображения. В этом случае используется метод Draw свойства Canvas.</p>

<p>Модифицируем наш пример, добавив в форму компонент TImageList и поместив в него несколько изображений.</p>

<p>Модифицируем код нашего приложения:</p>

<p>Соответствующий код для Delphi имеет вид:</p>
<pre>
procedure TForm1.DBGridDrawColumnCell(Sender: TObject; const Rect: TRect;
DataCol: Integer; Column: TColumn;  State: TGridDrawState);
var
  Im1: TBitmap;
begin
  Im1 := TBitmap.Create;
  if Column.FieldName = 'VenueNo' then
    with DBGrid1.Canvas do
    begin
      Brush.Color := clWhite;
      FillRect(Rect);
      if Table.FieldByName('VanueNo').Value = 1 then
        ImageList1.GetBitmap(0, Im1)
      else
        ImageList1.GetBitmap(2, Im1);
      Draw(round((Rect.Left + Rect.Right - Im1.Width) / 2), Rect.Top, Im1);
    end;
end;
</pre>


<p>Теперь в TDBGrid в колонке VenueNo находятся графические изображения.</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
