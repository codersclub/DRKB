<h1>Пример TDrawGrid.DrawCell</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Neil</div>

<pre>
procedure TForm1.DrawGrid1DrawCell(Sender: TObject; Col, Row: Longint;
  Rect: TRect; State: TGridDrawState);
var
  vRow, vCol: LongInt;
begin
  vRow := Row;
  vCol := Col;
  with Sender as TDrawGrid, Canvas do
  begin
    if (vRow = 0) or (vCol = 0) then
      Font.Color := clBlack
    else
      Font.Color := clRed;
    TextRect(Rect, Rect.Left, Rect.Top, Format('(%d,%d)', [vRow, vCol]));
  end;
end;
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>

<hr />

<p>Это код, который я использую для печати TMemoField в TDBGrid. Перекрываем (override) метод DrawCell:</p>
<pre>
Canvas.FillRect(ARect);
R := ARect;
WITH TMemoField(Field) DO
DrawText(Canvas.Handle, PChar(Value), Length(Value), R,
DT_WORDBREAK OR DT_NOPREFIX);
</pre>
<p>Я думаю этот код, который я создал в Delphi 1.0, должен помочь вам:</p>
<pre>
procedure TForm1.StringGrid1DrawCell(Sender: TObject; Col, Row: Longint;
  Rect: TRect; State: TGridDrawState);
var
  bufB: array[0..79] of Char;
  algn: Word;
begin
  algn := 0;
  if (Col = NumbColK) or (Col = PrceColK) or
    (Col = TtlColK) then
    algn := dt_Right;
  if Row = 0 then
    algn := dt_Center;
  if algn = 0 then
    Exit;
  StringGrid1.Canvas.FillRect(Rect);
  StrPCopy(bufB, StringGrid1.CellS[Col, Row]);
  Rect.Top := Rect.Top + 2;
  Rect.Right := Rect.Right - 2;
  DrawText(StringGrid1.Canvas.Handle, bufB, -1, Rect, algn);
end;
</pre>

<p>В первой части необходимо установить нужное вам выравнивание, и очистить старый текст.</p>
<p>Число -1, поскольку, я думаю, bufB должен быть строкой с терминирующим нулем, в которую вы можете помещать любое число, например, 10, и он должен ограничивать вашу строку до 10, как раз то, что вы хотели.</p>
<p>...действительно, в зависимости от вашего приложения, можно все значительно упростить. Если вы заполняете сетку из другого источника, просто сделайте так:</p>
<pre>
grid.cells[col,row] :=
trimWithDots (myString, form1.canvas, grid.widths[col]-2);
</pre>

<p>где trimWithDots-функция, с помощью которой вычисляется количество пикселей, необходимых для написания в ячейки сетки строки myString. При этом у myString обрезаются левые и правые пробелы, а для определения ширины используется функция холста textWidth:</p>
<pre>
function trimWithDots (const myString: string; canvas: tCanvas;
wid: integer): string;
begin
  result := myString;
  while canvas.textWidth (result) &gt; wid do
    delete (result, length(result), 1);
end;
</pre>

<p>Естественно, вы можете сделать это более грамотнее, добавляя к правильно-обрезанному тексту '...'. По какой-то странной причине, grid.canvas почему-то возвращает мне неверные результаты, поэтому я всегда работаю с form1.canvas, который меня никогда не подводил.</p>
<p>Если вы не загружаете сетку из другого источника, вы можете все делать так, как описано выше, но помещая код в обработчик события onDrawDataCell. В этом случае сетка нарисует за вас все линии, вам же останется нарисовать только содержимое.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
