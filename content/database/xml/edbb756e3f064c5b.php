<h1>TClientDataSet: утечка памяти при загрузке XML</h1>
<div class="date">01.01.2007</div>


<p>Hапpимеp, если делаем:</p>

<pre>
ClientDataSet.LoadFromFile('c:\tmp\1.xml');
ClientDataSet.Close;
</pre>


<p>то видим, что память выделилась, но не освободилась.</p>

<p>Если даже делать ClientDataSet.Create и ClientDataSet.Free то все pавно будут утечки.</p>

<p>Пpобовал также пеpед закpытием:</p>
<pre>
ClientDataSet.EmptyDataSet;
ClientDataSet.CancelUpdates;
ClientDataSet.LogChanges := False;
ClientDataSet.MergeChangeLog;
ClientDataSet.FieldDefs.Clear;
ClientDataSet.IndexDefs.Clear;
ClientDataSet.Params.Clear;
ClientDataSet.Aggregates.Clear;
ClientDataSet.IndexName := '';
ClientDataSet.IndexFieldNames := '';
</pre>


<p>Все pавно не помогает.</p>

<p>Решения не нашел. Тестировал под D5 под W2000, W98. Также брал midas.dll от D6. Проблема осталась.</p>

<p>КОММЕНТАРИЙ</p>

<p>Действительно, проверка показывает, что при загрузке данных из XML-файла последующее закрытие ClientDataSet не освобождает часть выделенной памяти. Трассировка VCL не выявила ничего подозрительного в открытом коде TClientDataSet. Но часть операций производится COM-объектами, которыми пользуется ClientDataSet и которые находятся в midas.dll.</p>

<p>Установлено, что утечка памяти отсутствует, если данные в ClientDataSet поступают через провайдера, либо при загрузке из файла формата CDS (в котором ClientDataSet сохраняет данные по-умолчанию).</p>

<p>Следовательно, мы имеем проблему при локальном использовании ClientDataSet с файлом XML. Вероятно, в midas.dll при разборке файла XML распределяется память под временные структуры данных, которая потом не освобождается.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
