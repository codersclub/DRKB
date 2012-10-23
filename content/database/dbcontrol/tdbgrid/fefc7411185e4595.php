<h1>Рисование текста в TDBGrid</h1>
<div class="date">01.01.2007</div>


<p>Следующий метод может быть использован в качестве обработчика события TDBGrid.OnDrawDataCell. Он демонстрирует способ рисования текста в колонке цветом, отличным от цвета текста в остальной части табличной сетки.</p>

<pre>
procedure TForm1.DBGrid1DrawDataCell(Sender: TObject; const Rect:
  TRect; Field: TField; State: TGridDrawState);
  { ПРИМЕЧАНИЕ: Свойство DefaultDrawing компонента
  Grid должно быть установлено в False }
begin
  { если имя поля - "NAME" }
  if Field.FieldName = 'NAME' then
    { изменяем цвет шрифта на красный }
    (Sender as TDBGrid).Canvas.Font.Color := clRed;
  { выводим текст в табличной сетке }
  (Sender as TDBGrid).Canvas.TextRect(Rect, Rect.Left + 2,
    Rect.Top + 2, Field.AsString);
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
<hr />Для отображения таблицы я использую DBGrid. Для некоторых полей я хочу применить другой шрифт, размер, цвет...</p>

<p>Вам необходимо обработать событие OnDrawDataCell, например так:</p>

<pre>
procedure TForm1.DBGrid1DrawDataCell(Sender: TObject; const 
  Rect: TRect; Field: TField; State: TGridDrawState);
begin
  if Field.FieldName = 'SERIAL' then
    if (Field as TStringField).Value = 'НЕИЗВЕСТНО' then
      with (Sender as TDBGrid).Canvas do 
      begin
        Brush.Color := clRed;
        Font.Style := [fsItalic];
        Font.Color := clAqua;
        FillRect(Rect);
        TextOut(Rect.Left, Rect.Top, Field.AsString);
      end;
end;
</pre>


<p>....BTW, выключите DefaultDrawing.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
