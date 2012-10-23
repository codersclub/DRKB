<h1>Поиск файлов</h1>
<div class="date">01.01.2007</div>


<p>Теперь поговорим о поиске файлов. Для этой цели могут использоваться процедуры FindFirst, FindNext, FindClose, при участии переменной типа TSearchRec которая хранит информацию о текущем статусе поиска и характеристики последнего найденного файла.</p>
<p>Пример иллюстрирующий поиск всех файлов и каталогов в определенном каталоге:</p>
<pre>Var SearchRec:TSearchRec;
...
If FindFirst('c:\Windows\*.*', faAnyFile, SearchRec)=0 then
repeat
{Вот здесь мы можем делать с найденным файлом что угодно
SearchRec.name - имя файла
ExpandFileName(SearchRec.name) - имя файла с полным путем} 
until FindNext(SearchRec) &lt;&gt; 0;
FindClose(SearchRec);
</pre>

<p>Примечания по приведенному коду:</p>
<p>1) Первыми в список могут попадать файлы с именами "." и ".." - это ДОСовские имена для переходов на "родительский уровень", иногда нужна обработка для их игнорирования.</p>
<p>2) FindFirst в качестве первого параметра принимает шаблон для поиска, так как он был принят для ДОС. Если шаблон не включает путь то файлы будут искаться в текущем каталоге.</p>
<p>3) FindFirst требует задания атрибута для файла - здесь мы искали все файлы, если надо какие-то определенные (например только скрытые, или только каталоги) то надо это указать, список всех атрибутов я уже приводил выше.</p>
<p>4) SearchRec переменная связывает во едино FindFirst и FindNext, но требует ресурсов для своей работы, поэтому желательно ее освободить после поиска процедурой FindClose(SearchRec) - на самом деле утечки памяти небольшие, но если программа работает в цикле и долгое время пожирание ресурсов будет значительным.</p>
<p>5)FindFirst/FindNext - работают не открывая файлы, поэтому они корректно находят даже Swap файлы Windows...</p>
<p>Поиск файлов по дереву каталогов с заходом в подкаталоги разобран <a href="b81.htm">здесь</a></p>
