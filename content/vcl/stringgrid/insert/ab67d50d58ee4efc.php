<h1>Обновление картинки в ячейке</h1>
<div class="date">01.01.2007</div>

Автор: SottNick</p>
<p>Если в таблице вы используете событие OnDrawCell для помещения в ячейку рисунка, причем различного, в зависимости, например, от соответствующего значения в двумерном массиве, и вам надо, чтобы после изменения значения в массиве обновилось изображение (Refresh не подходит, т.к. будет мелькать), то измените значение у ячейки (DrawGrid не годится):</p>
<pre>
StringGrid1.Cells[i,j]:=''; 
</pre>
<p>или</p>
<pre>
StringGrid1.Cells[i,j]:=StringGrid1.Cells[i,j]; 
</pre>
<p>если там что-то хранится</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

