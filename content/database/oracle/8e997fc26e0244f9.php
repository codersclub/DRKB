<h1>Понятия Instance, Database и т.д.</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Nomadic</div>

<p>Перевод документации:</p>

<p>Что такое ORACLE Database?</p>

<p>Это данные которые будут обрабатываться как единое целое. Database состоит из файлов операционной системы. Физически существуют database files и redo log files. Логически database files содержат словари, таблицы пользователей и redo log файлы. Дополнительно database требует одну или более копий control file.</p>

<p>Что такое ORACLE Instance?</p>

<p>ORACLE Instance обеспечивает программные механизмы доступа и управления database. Instance может быть запущен независимо от любой database (без монтирования или открытия любой database). Один instance может открыть только одну database. В то время как одна database может быть открыта несколькими Instance.</p>

<p>Instance состоит из:</p>

<p>SGA (System Global Area), которая обеспечивает коммуникацию между процессами;</p>
<p>до пяти (в последних версиях больше) бэкграундовых процессов.</p>

<p>От себя добавлю - database включает в себя tablespace, tablespace включает в себя segments (в одном файле данных может быть один или несколько сегментов, сегменты не могут быть разделены на несколько файлов). segments включают в себя extents.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
