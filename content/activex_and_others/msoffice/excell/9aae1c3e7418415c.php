<h1>Экспорт документов Excel</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: JB, https://asportal.h16.ru</div>

<p>Эта статья первая из цикла статей посвященных экспорту документов в MS Excel. В ней мы рассмотрим подключение к Excel, заполнению ячеек и простейшее оформление документа.</p>
<p>Я не буду углубляться в теорию, рассказывать о том как работает OLE механизм, начнем с самого главного.</p>
<p>Подключение.</p>
<p>Для подключения к Excel и работы с ним нам понадобится переменная типа Variant:</p>
<p>Excel:Variant;</p>
<p>Далее создаем OLE объект:</p>
<p>Excel:=CreateOleObject('Excel.Application');</p>
<p>Добавляем новую книгу:</p>
<p>Excel.Workbooks.Add;</p>
<p>Показываем Excel:</p>
<p>Excel.Visible:=true;</p>
<p>Так же нам понадобятся константы:</p>
<p>const</p>
<p>xlContinuous=1;</p>
<p>xlThin=2;</p>
<p>xlTop = -4160;</p>
<p>xlCenter = -4108;</p>
<p>Текст ячеек.</p>
<p>Теперь до любой ячейки мы можем добраться следующим образом:</p>
<p>Excel.ActiveWorkBook.WorkSheets[1].Cells[1, 2]:='Текст ячейки (1,2)';</p>
<p>Объект Range, выделение диапазона, объединение ячеек, выравнивание.</p>
<p>Представьте такую ситуацию: необходимо объединить несколько ячеек и выровнять текст в них по центру.</p>
<p>Выделяем:</p>
<p>Excel.ActiveWorkBook.WorkSheets[1].Range['A1:G1'].Select;</p>
<p>Объединяем:</p>
<p>Excel.ActiveWorkBook.WorkSheets[1].Range['A1:G1'].Merge;</p>
<p>И выравниваем:</p>
<p>Excel.Selection.HorizontalAlignment:=xlCenter;</p>
<p>Границы и перенос по словам.</p>
<p>Для начала выделяем нужный диапазон а затем...</p>
<p>Показываем границы:</p>
<p>Excel.Selection.Borders.LineStyle:=xlContinuous;</p>
<p>Excel.Selection.Borders.Weight:=xlThin;</p>
<p>И включаем перенос по словам:</p>
<p>Excel.Selection.WrapText:=true;</p>
<p>Пример.</p>
<p>Пример можно скачать здесь</p>
<p>Параметры страницы.</p>
<p>Начнем с полей страницы. Во первых для того чтобы добраться до параметров страницы у листа Excel имеется свойство объект PageSetup его мы и будем использовать. Для установки размеров полей необходимо изменить соответствующие свойства PageSetup, вот эти свойства:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>LeftMargin - Левое поле</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>RightMargin - Правое поле</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>TopMargin - Верхнее поле</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>BottomMargin - Нижнее поле</td></tr></table></div><p>Значение размеров полей необходимо указывать в пикселях, к чему мы не очень привыкли, поэтому воспользуемся функцией InchesToPoints объекта Application, которая переводит значение в дюймах в значение в пикселях. Теперь напишем процедуру которая подключит Excel и установит поля равные 0.44 дюйма (приблизительно 1 см):</p>
<pre>
procedure Connect;
var
  Excel:Variant;
begin
  Excel:=CreateOleObject('Excel.Application');
  Excel.Workbooks.Add;
 
  Excel.ActiveSheet.PageSetup.LeftMargin:= Excel.Application.InchesToPoints(0.44);
  Excel.ActiveSheet.PageSetup.RightMargin:= Excel.Application.InchesToPoints(0.44);
  Excel.ActiveSheet.PageSetup.TopMargin:= Excel.Application.InchesToPoints(0.44);
  Excel.ActiveSheet.PageSetup.BottomMargin:= Excel.Application.InchesToPoints(0.44);
end;
</pre>
<p>Иногда полезно уметь установить и ориентацию страницы:</p>
<p>  Excel.ActiveSheet.PageSetup.Orientation:= 2;</p>
<p>Здесь значение ориентации = 2, означает альбомную, при книжной ориентации присвойте Orientation значение 1.</p>
<p>Вы наверное не раз встречали такой отчет в котором таблица с большим количеством строк размещается на нескольких страницах в таких случаях очень удобны сквозные строки, они печатаются на каждой странице отчета:</p>
<p>  Excel.ActiveSheet.PageSetup.PrintTitleRows:='$2:$3';</p>
<p>Здесь мы указываем вторую и третью строки для печати на каждой странице.</p>
<p>Шрифты и цвета.</p>
<p>Для установки шрифта и размера текста выделите нужный диапазон и установите свойство Name объекта-свойства Font объекта Selection или свойство Size для изменения размера:</p>
<pre>
 
  Excel.ActiveWorkBook.WorkSheets[1].Range['F1'].Select;
  Excel.Selection.Font.Name:='Courier New';
  Excel.Selection.Font.Size:=18;
</pre>
<p>Если Вы хотите установить жирный или, например, наклонный стиль написания текста установите соответствующие свойства:</p>
<pre>
  Excel.ActiveWorkBook.WorkSheets[1].Range['G1'].Select;
  Excel.Selection.Font.Bold:=true; // Для жирного текста
  Excel.Selection.Font.Italic:=true; // Для наклонного текста
</pre>
<p>Для указания цвета текста измените свойство ColorIndex все того же объекта Font:</p>
<pre>
  Excel.ActiveWorkBook.WorkSheets[1].Range['A1'].Select;
  Excel.Selection.Font.ColorIndex:=3;
</pre>
<p>Вот несколько индексов цветов:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>Индекс - Цвет</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>0 - Авто</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>2 - Белый</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>3 - Красный</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>5 - Синий</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>6 - Желтый</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>10 - Зеленый</td></tr></table></div><p>Для изменения цвета фона ячейки используйте объект Interior свойства Selection:</p>
<pre>
  Excel.ActiveWorkBook.WorkSheets[1].Range['H1'].Select;
  Excel.Selection.Interior.ColorIndex:=3; // Цвет
</pre>
<p>Колонтитулы.</p>
<p>Для добавления колонтитула к документу достаточно указать его содержание:</p>
<pre>
  Excel.ActiveSheet.PageSetup.LeftFooter:='Левый нижний колонтитул';
  Excel.ActiveSheet.PageSetup.CenterFooter:='Центральный нижний колонтитул';
  Excel.ActiveSheet.PageSetup.RightFooter:='Правый нижний колонтитул';
  Excel.ActiveSheet.PageSetup.LeftHeader:='Левый верхний колонтитул';
  Excel.ActiveSheet.PageSetup.CenterHeader:='Центральный верхний колонтитул';
  Excel.ActiveSheet.PageSetup.RightHeader:='Правый верхний колонтитул';
</pre>
<p>Для изменения размера шрифта добавьте к колонтитулу управляющий символ "&amp;" и размер шрифта:</p>
<pre>
  Excel.ActiveSheet.PageSetup.LeftFooter:='&amp;7Левый нижний колонтитул';
</pre>

