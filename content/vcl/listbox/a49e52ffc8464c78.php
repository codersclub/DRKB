<h1>Как добавлять колонки в обычный TListBox?</h1>
<div class="date">01.01.2007</div>


<p>Класс TListbox содержит свойство TabWith:</p>
<pre>
ListBox1.TabWith := 50; 
ListBox1.Items.Add('Column1'^I'Column2');  // ^I это символ Tab
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

