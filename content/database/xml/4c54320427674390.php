<h1>TClientDataSet: некорректное формирование XML</h1>
<div class="date">01.01.2007</div>


<p>Delphi5 build 5.62, midas.dll v5.0.5.63</p>

<p>При использовании SaveToFile('file.xml', dfXML) формируется некорректный текст XML, если набор данных содержит изменения, т.е. при непустом Delta.</p>

<p>Пример:</p>

<p>Набор данных состоит их двух полей</p>

<p>IntField: integer</p>
<p>StrField: string(20)</p>

<p>После ввода</p>

<p>  1    aaa</p>
<p>  2    bbb</p>
<p>  3    ccc</p>
<p>  4    ddd</p>

<p>и сохранения текст XML имеет вид:</p>
<pre>
&lt;?xml version="1.0" standalone="yes"?&gt;  &lt;DATAPACKET Version="2.0"&gt;
&lt;METADATA&gt;&lt;FIELDS&gt;&lt;FIELD attrname="IntField" fieldtype="i4"/&gt;
&lt;FIELD attrname="StrField" fieldtype="string" WIDTH="20"/&gt;&lt;/FIELDS&gt;
&lt;PARAMS CHANGE_LOG="1 0 4 2 0 4 3 0 4 4 0 4"/&gt;&lt;/PARAMS&gt;&lt;/METADATA&gt;
&lt;ROWDATA&gt;&lt;ROW RowState="4" IntField="1" StrField="aaa"/&gt;
&lt;ROW RowState="4" IntField="2" StrField="bbb"/&gt;
&lt;ROW RowState="4" IntField="3" StrField="ccc"/&gt;
&lt;ROW RowState="4" IntField="4" StrField="ddd"/&gt;
&lt;/ROWDATA&gt;&lt;/DATAPACKET&gt;
</pre>

<p>Ошибочным явлается наличие тэга &lt;/PARAMS&gt;, т.к. открывающий тэг &lt;PARAMS.../&gt; уже содержит ограничитель "/"</p>

<p>После вызова MergeChangeLog, CancelUpdates или ApplyUpdates сохраняется корректный XML.</p>

<p>КОММЕНТАРИЙ</p>

<p>Проблема заключена именно в midas.dll. При проверке в Delphi 5 update pack 1 (build 6.18) баг не проявляется - XML формируется корректно. Если же сменить midas.dll на старую - версии 5.0.5.63 - получаем вышеописанный результат.</p>

<p>Скачать тест StoneTest_22.zip (2.3K)</p>

<p>Мораль сей басни такова: ставьте свежие сервиспаки.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
