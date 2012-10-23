<h1>Что можно поместить в TDBGrid?</h1>
<div class="date">01.01.2007</div>


Что можно поместить в DBGrid</p>
Наталия Елманова<br>
Компьютер Пресс - CD, 1999, N 5<br>
<p>&#169; Copyright N.Elmanova &amp; ComputerPress Magazine.</p>
Нередко при разработке приложений, использующих табличный вывод данных, требуется отобразить те или иные строки таблиц нестандартным образом, например, с целью привлечения внимания пользователя к этим строкам. В данной статье содержатся некоторые советы, касающиеся нестандартного отображения данных в компоненте TDBGrid.</p>
<p>Совет 12. Как изменить цвет строки в TDBGrid</p>
Предположим, нам требуется изменить атрибуты текста и фона строки в компоненте TDBGrid, если значение какого-либо поля удовлетворяет заранее заданному условию. Для этой цели принято использовать обработчик события OnDrawColumnCell этого компонента. Отметим, что возможности, предоставляемые при его использовании, весьма разнообразны.</p>
Рассмотрим простейшее приложение с TDBGrid, содержащее один компонент TTable, один компонент TDataSource и один компонент TDBGrid: Установим значения их свойств в соответствии с приведенной ниже таблицей:</p>
<table cellspacing="0" cellpadding="0" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr>
<td><p>Компонент</p>
</td>
<td><p>Свойство</p>
</td>
<td><p>Значение</p>
</td>
</tr>
<tr>
<td rowspan="3" ><p>Table1</p>
</td>
<td><p>DatabaseName</p>
</td>
<td><p>BCDEMOS (или DBDEMOS)</p>
</td>
</tr>
<tr>
<td><p>TableName</p>
</td>
<td><p>events.db</p>
</td>
</tr>
<tr>
<td><p>Active</p>
</td>
<td><p>true</p>
</td>
</tr>
<tr>
<td><p>DataSource1</p>
</td>
<td><p>DataSet</p>
</td>
<td><p>Table1</p>
</td>
</tr>
<tr>
<td><p>DBGrid1</p>
</td>
<td><p>DataSource</p>
</td>
<td><p>DataSource1
</td>
</tr>
</table>
<img src="/pic/clip0058.gif" width="400" height="168" border="0" alt="clip0058"></p>
Рис. 1 Тестовое приложение на этапе проектирования</p>
Обычно для перерисовки изображения в ячейках используется метод OnDrawColumnCell.</p>
Его параметр Rect - структура, описывающая занимаемый ячейкой прямоугольник, параметр Column - колонка DBGrid, в которой следует изменить способ рисования изображения. Для вывода текста используется метод TextOut свойства Canvas компонента TDBGrid.</p>
Предположим, нам нужно изменить цвет текста и фона строки в зависимости от значения какого-либо поля (например, VenueNo). Создадим обработчик события OnDrawColumnCell компонента DBGrid1.</p>
<pre>
procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; const Rect: TRect;
  DataCol: Integer; Column: TColumn; State: TGridDrawState);
begin
if (Table1.FieldByName('VenueNo').Value=1) then begin
with  DBGrid1.Canvas do begin
Brush.Color:=clGreen;
Font.Color:=clWhite;
FillRect(Rect);
TextOut(Rect.Left+2,Rect.Top+2,Column.Field.Text);
end;
end;
end;
</pre>
В результате на этапе выполнения при отображении строк, в которых значение поля VenueNo равно 1, фон ячеек будет окрашен в зеленый цвет, а текст будет выведен белым цветом.</p>
<img src="/pic/clip0059.gif" width="400" height="168" border="0" alt="clip0059"></p>
Рис. 2 Изменение цвета фона и шрифта в строках со значением поля VenueNo=1 на этапе выполнения.</p>
При выводе выделенных строк все данные в ячейках оказались выровненными по левому краю. Если мы хотим более корректно отобразить выравнивание текста в колонке, следует слегка модифицировать наш код, учтя значение свойства Alignment текущей (то есть рисуемой в данный момент) колонки:</p>
<pre>
procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; const Rect: TRect;
  DataCol: Integer; Column: TColumn; State: TGridDrawState);
begin
if (Table1.FieldByName('VenueNo').Value=1) then begin
with  DBGrid1.Canvas do begin
Brush.Color:=clGreen;
Font.Color:=clWhite;
FillRect(Rect);
if (Column.Alignment=taRightJustify) then
 TextOut(Rect.Right-2-  TextWidth(Column.Field.Text),
  Rect.Top+2,Column.Field.Text)
else
 TextOut(Rect.Left+2,Rect.Top+2,Column.Field.Text);
end;
end;
end;
</pre>
В этом случае выравнивание текста в колонках совпадает с выравниванием столбцов.</p>
Отметим, что величина смещения (в данном случае 2 пиксела), вообще говоря, зависит от гарнитуры и размера шрифта, используемого в данной колонке, и должна подбираться индивидуально.</p>
<img src="/pic/clip0060.gif" width="400" height="168" border="0" alt="clip0060"></p>
Рис. 3 Изменение цвета с учетом выравнивания текста в колонках.</p>
Если необходимо отобразить нестандартным образом не всю строку, а только некоторые ячейки, следует проанализировать имя поля, отображаемого в данной колонке, как в приведенном ниже обработчике событий.</p>
<pre>
procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; const Rect: TRect;
  DataCol: Integer; Column: TColumn; State: TGridDrawState);
begin
if (Table1.FieldByName('VenueNo').Value=1) and
(Column.FieldName='VenueNo')  then begin
with  DBGrid1.Canvas do begin
Brush.Color:=clGreen;
Font.Color:=clWhite;
FillRect(Rect);
TextOut(Rect.Right-2-  TextWidth(Column.Field.Text),
  Rect.Top+2,Column.Field.Text)
end;
end;
end;
</pre>
В результате выделенными оказываются только ячейки, для которых выполняются выбранные нами условия:</p>
<img src="/pic/clip0061.gif" width="400" height="168" border="0" alt="clip0061"></p>
Рис. 4 Выделение цветом данных в одной колонке.</p>
<p>Совет 13. Как заменить данные в столбце компонента TDBGrid</p>
Нередко в колонке DBGrid нужно вывести не реальное значение, хранящееся в поле соответствующей таблицы, а другие данные, соответствующие имеющимся (например, символьную строку вместо ее числового кода). В этом случае также используется метод TextOut свойства Canvas компонента TDBGrid:</p>
<pre>
procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; const Rect: TRect;
  DataCol: Integer; Column: TColumn; State: TGridDrawState);
begin
if  (Column.FieldName='VenueNo')  then begin
with  DBGrid1.Canvas do begin
Brush.Color:=clWhite;
FillRect(Rect);
if (Table1.FieldByName('VenueNo').Value=1) then begin
Font.Color:=clRed;
TextOut(Rect.Right-2-
  DBGrid1.Canvas.TextWidth('our venue'),
  Rect.Top+2,'our venue');
end else begin
 TextOut(Rect.Right-2-
  DBGrid1.Canvas.TextWidth('other venue'),
  Rect.Top+2,'other venue');
end;
end;
end;
end;
</pre>
<img src="/pic/clip0062.gif" width="400" height="168" border="0" alt="clip0062"></p>
Рис. 5 Замена данных в колонке другими значениями.</p>
Еще один пример - использование значков из шрифтов Windings или Webdings в качестве подставляемой строки.</p>
<pre>
procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; const Rect: TRect;
  DataCol: Integer; Column: TColumn; State: TGridDrawState);
begin
if  (Column.FieldName='VenueNo')  then begin
with  DBGrid1.Canvas do begin
Brush.Color:=clWhite;
FillRect(Rect);
Font.Name:='Wingdings';
Font.Size:=-14;
if (Table1.FieldByName('VenueNo').Value=1) then begin
Font.Color:=clRed;
TextOut(Rect.Right-2-
  DBGrid1.Canvas.TextWidth('J'),
  Rect.Top+1,'J');
end else begin
 Font.Color:=clBlack;
 TextOut(Rect.Right-2- DBGrid1.Canvas.TextWidth('F'),
  Rect.Top+1,'F');
end;
end;
end;
end;
</pre>
<img src="/pic/clip0063.gif" width="400" height="175" border="0" alt="clip0063"></p>
Рис. 6 Использование символов из шрифта Windings для выделения нужных значений в колонке.</p>
<p>Совет 14. Как поместить графическое изображение в TDBGrid</p>
Использование свойства Canvas компонента TDBGrid в методе OnDrawColumnCell позволяет не только выводить в ячейке текст методом TextOut, но и размещать в ячейках графические изображения. В этом случае используется метод Draw свойства Canvas.</p>
Модифицируем наш пример, добавив на форму компонент TImageList и поместив в него несколько изображений.</p>
<img src="/pic/clip0064.gif" width="419" height="276" border="0" alt="clip0064"></p>
Рис. 7 Компонент TImageLis с изображениями, помещаемыми в TDBGrid</p>
Модифицируем код нашего приложения:</p>
<pre>
procedure TForm1.DBGrid1DrawColumnCell(Sender: TObject; const Rect: TRect;
  DataCol: Integer; Column: TColumn; State: TGridDrawState);
var Im1: TBitmap;
begin
Im1:=TBitmap.Create;
if  (Column.FieldName='VenueNo' ) then begin
with  DBGrid1.Canvas do begin
Brush.Color:=clWhite;
FillRect(Rect);
if (Table1.FieldByName('VenueNo').Value=1)
then begin
ImageList1.GetBitmap(0,Im1);
end else begin
ImageList1.GetBitmap(2,Im1);
end;
Draw(round((Rect.Left+Rect.Right-Im1.Width)/2),Rect.Top,Im1);
end;
end;
end;
</pre>
Теперь в TDBGrid в колонке VenueNo находятся графические изображения.</p>
<img src="/pic/clip0065.gif" width="400" height="168" border="0" alt="clip0065"></p>
Рис. 8 Вывод графических изображений в колонке</p>

<p>Взято из<a href="https://delphi.chertenok.ru" target="_blank"> http://delphi.chertenok.ru</a></p>
