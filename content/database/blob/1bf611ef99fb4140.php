<h1>Приемы работы с BLOB (OLE/Memo) полями</h1>
<div class="date">01.01.2007</div>


<p>Загрузка файла из TImage:</p>

<pre>
      QAll.Edit;
      QAll.FieldByName('Logo').assign(Image.Picture);
      QAll.post; 
</pre>


<p>Чтение файла из таблицы в TImage:</p>
<pre>
  Image.Picture.assign(QAll.FieldByName('Logo')); 
</pre>


<p>Загрузка данных в поле:</p>
<pre>
(Table1.DataSource2.Fields.Field[01] As TBlobField).LoadFromStream  
</pre>


<p>Загрузка данных через параметры:</p>

<p>Запрос </p>
<pre>Insert into MyTable (MyBlobField)
Values (:Something) 
</pre>


<p>В коде:</p>

<pre>
(Query1.parameters.parambyname('Something') as TBlobField).LoadFromFile ...
(Query1.parameters.parambyname('Something') as TBlobField).LoadFromStream ...
(Query1.parameters.parambyname('Something') as TBlobField).assign ... 
</pre>



<div class="author">Автор: Vit</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

