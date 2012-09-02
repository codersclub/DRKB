<h1>Access to table disabled because of previous error. Read failure</h1>
<div class="date">01.01.2007</div>


<p>При добавлении новых записей с помощью метода TTable.AppendRecord в индексированную таблицу FoxPro через какое-то время (то есть при одновременном добавлении большого количества записей) возникает ошибка: </p>

<p>"Access to table disabled because of previous error. Read failure. File &lt;имя_файла.cdx&gt;".</p>

<p>Возможно, причина заключается в том, что операции чтения-записи в файл, содержащий таблицу FoxPro, особенно при использовании кэширования, предоставляемого операционной системой, конфликтуют с содержимым индексного файла (это часто происходит при многопользовательской работе). Дело в том, что ранние версии dBase, FoxPro, Clipper работали с неподдерживаемыми индексами, то есть индексные файлы не обновлялись одновременно с таблицей, и для их синхронизации требовалось выполнять специальные операции. Но соответствующие средства разработки, применявшиеся в то время, обычно не поддерживали никаких аналогов транзакций - записи чаще всего вставлялись по одной. </p>

<p>В случае применения старых версий формата FoxPro следует избегать кэширования при выполнении дисковых операций с файловым сервером, содержащим базу данных FoxPro. Кроме того, следует проверить и, если необходимо, изменить в настройках BDE параметры MINBUFSIZE, MAXBUFSIZE, LOCAL SHARE - возможно, проблема заключается в недостаточной величине буферов BDE для кэширования данных или в одновременном доступе к данным приложений, использующих и не использующих BDE.</p>

<p>Еще одним из способов решения этой проблемы (самым радикальным) является замена FoxPro на какую-нибудь из серверных СУБД. Например, InterBase неплохо справляется с одновременным вводом большого количества записей благодаря некоторым специфическим особенностям архитектуры этого сервера. </p>

<p>Наталия Елманова</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


