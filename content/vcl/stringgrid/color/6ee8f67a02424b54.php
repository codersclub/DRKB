<h1>Цветные ячейки в TStringGrid / TDBGrid?</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Alex Schlecht</div>

<p>StringGrids / DBGrids с цветными ячейками смотрятся очень красиво, и Вы можете информировать пользователя о важных данных внутри Grid.</p>

<p>Совместимость: все версии Delphi</p>

<p>К сожалению, невозможно применить один и тот же метод к StringGrids и к DBGrids. Итак сперва рассмотрим как это сделать в StringGrid:</p>

<p>1. StringGrid</p>
<p>=============</p>
<p>Для раскрашивания будем использовать событие "OnDrawCell". Следующий код показывает, как сделать в Grid красный бэкраунд. Бэкграунд второй колонки будет зелёным.</p>

<pre>
procedure TForm1.StringGrid1DrawCell(Sender: TObject; ACol, ARow: Integer; 
  Rect: TRect; State: TGridDrawState); 
 
Const   //сдесь определяем Ваш цвет. Так же можно использовать 
        //цвета по умолчанию. 
  clPaleGreen = TColor($CCFFCC); 
  clPaleRed =   TColor($CCCCFF); 
 
begin 
 
//Если ячейка получает фокус, то нам надо закрасить её другими цветами 
if (gdFocused in State) then begin     
   StringGrid1.Canvas.Brush.Color := clBlack; 
   StringGrid1.Canvas.Font.Color := clWhite; 
end 
else  //Если же ячейка теряет фокус, то закрашиваем её красным и зелёным 
 
   if ACol = 2   //Вторая колонка будет зелёной , другие - ячейки красными 
    then StringGrid1.Canvas.Brush.color := clPaleGreen 
    else StringGrid1.canvas.brush.Color := clPaleRed; 
 
//Теперь закрасим ячейки, но только, если ячейка не Title- Row/Column 
//Естевственно это завит от того, есть у Вас title-Row/Columns или нет. 
 
If (ACol &gt; 0) and (ARow&gt;0) then 
  begin 
      //Закрашиваем бэкграунд 
    StringGrid1.canvas.fillRect(Rect); 
 
      //Закрашиваем текст (Text). Также здесь можно добавить выравнивание и т.д.. 
    StringGrid1.canvas.TextOut(Rect.Left,Rect.Top,StringGrid1.Cells[ACol,ARow]); 
  end; 
end; 
</pre>



<p>Если Вы захотите чтобы цвет ячеек менялся в зависимости от значения в них, то можно заменить 3 линии (if Acol = 2 ......) на что-нибуть вроде этого</p>
<pre>
if StringGrid1.Cells[ACol, ARow] = 'highlight it' then
  StringGrid1.Canvas.Brush.color := clPalered
else
  StringGrid1.canvas.brush.Color := clwhite;
</pre>


<p>Ну а теперь давайте раскрасим DBGrids:</p>

<p>2. DBGrid</p>
<p>=========</p>
<p>С DBGrids это делается намного проще. Здесь мы будем использовать событие "OnDrawColumnCell". Следующий пример разукрашивает ячейки колонки "Status" когда значение НЕ равно "a".</p>
<p>Если Вы хотите закрасить целую линию, то достаточно удалить условие "If..." (смотрите ниже)</p>

<pre>
procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; const Rect: TRect;
  DataCol: Integer; Column: TColumn;
  State: TGridDrawState);
const
  clPaleGreen = TColor($CCFFCC);
  clPaleRed = TColor($CCCCFF);
begin
 
  if Column.FieldName = 'Status' then //Удалите эту линию, если хотете закрасить целую линию
 
    if Column.Field.Dataset.FieldbyName('Status').AsString &lt;&gt; 'a' then
      if (gdFocused in State) {//имеет ли ячейка фокус? } then
        dbgrid1.canvas.brush.color := clBlack //имеет фокус
      else
        dbgrid1.canvas.brush.color := clPaleGreen; //не имеет фокуса
 
//Теперь давайте закрасим ячейку используя стандартный метод:
  dbgrid1.DefaultDrawColumnCell(rect, DataCol, Column, State)
end;
</pre>


<p>Вот и всё. Не правда ли красиво ? :)</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


