<h1>Запись картинки в ADO-таблицу</h1>
<div class="date">01.01.2007</div>


<pre>
ADOQuery1.Edit;
TBLOBField(ADOQuery1.FieldByName('myField')).LoadFromFile('c:\my.bmp');
ADOQuery1.Post;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<p class="note">Примечание Vit</p><p>Похоже имеется ввиду запросы вида "Select * From..."</p>
