<h1>Как изменить цвет сетки таблицы?</h1>
<div class="date">01.01.2007</div>

<p>Информация о стиле, цвете и других параметрах ячейки таблицы содержится в элементах коллекции Borders, которые, по сути, представляют собой линии, ограничивающие и пересекающие ячейку. Выбор элемента коллекции производится через константы WdBorderBottom, WdBorderHorizontal, WdBorderLeft, WdBorderRight, WdBorderTop, wdBorderVertical. Цвет сетки определяется индексом, который записывается в поле ColorIndex элемента коллекции. Оператор установки цвета для Delphi выглядит следующим образом, смотрите пример:</p>
<pre class="delphi">
W.ActiveDocument.Tables.Item(tab_).Columns.Item(col_).Cells.Item(row_).Borders.Item(wdBorderTop).ColorIndex:=wdDarkRed;
</pre>

где tab_ - номер таблицы, col_ - номер колонки, row_ - номер строки, wdBorderTop - верхняя граница ячейки, wdDarkRed - цветовой индекс. Значения цветовых индексов и констант, определяющих выбор элемента коллекции Borders, можно определить опытным путем, запустив макрос Word. Например:</p>
<pre class="vb">
Sub Макрос16()
'
' Макрос16 Макрос
' Макрос записан 29.07.03 Корняков Василий Николаевич
'
 MsgBox (wdBorderTop)
End Sub
</pre>
</p>
