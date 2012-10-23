<h1>Включение WAL на NetWare ухудшает производительность на 80% при вставках записей, и только на 15% &ndash; при обновлениях</h1>
<div class="date">01.01.2007</div>


<p>Файл WAL должен быть расположен на другом винчестере чем основная БД. (это-же относится и к теневой БД). В этом случае ухудшения производительности не будет. Кроме этого вы должны учитывать, что запись в WAL происходит синхронно с БД, поэтому сравнивать "производительность" WAL с асинхронными изменениями в БД некорректно.</p>
<div class="author">Автор: <a href="mailto:delphi@demo.ru" target="_blank">Дмитрий Кузьменко</a> (<a href="https://www.ibase.ru" target="_blank">https://www.ibase.ru</a>)</div>
