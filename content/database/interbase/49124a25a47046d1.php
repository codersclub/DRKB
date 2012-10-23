<h1>Ошибка о файле SAA.AAA</h1>
<div class="date">01.01.2007</div>


<p>The 'SAA.AAA' file is a temporary file used in processing a query.</p>

<p>A failure involving this file generally means that InterBase has run out of disk space processing the query.</p>

<p>(Remember that this will be a temporary file on the server, so the server is out of disk space, not your local machine!)</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

<hr />Этот файл является временным, и создается когда при выполнении запроса возникает необходимость в сортировке результата. Ошибка может возникать при нехватке дискового пространства на томе, куда указывает TEMP. Для NT при работе IB в режиме сервиса необходимо изменить переменную TEMP для System (см. My Computer/Properties/Environment). Для IB 5.x и 6.0 (в архитектуре SuperServer только!) можно указать диски и размер временных файлов в файле конфигурации IBCONFIG, или в переменной окружения INTERBASE_TMP (см. Operations Guide, стр92). Например:</p>

<p>TMP_DIRECTORY "c:\" 10000000</p>
<p>TMP_DIRECTORY "e:\temp\" 100000000</p>

<p>Может быть указано несколько дисков или каталогов, которые будут использоваться последовательно. Размер должен быть указан в байтах. Кавычки для имени диска и каталога обязательны.</p>
<p>Borland Interbase / Firebird FAQ</p>
<p>Borland Interbase / Firebird Q&amp;A, версия 2.02 от 31 мая 1999</p>
<p>последняя редакция от 17 ноября 1999 года.</p>
<p>Часто задаваемые вопросы и ответы по Borland Interbase / Firebird</p>
<p>Материал подготовлен в Демо-центре клиент-серверных технологий. (Epsylon Technologies)</p>
<p>Материал не является официальной информацией компании Borland.</p>
<p>E-mail mailto:delphi@demo.ru</p>
<p>www: http://www.ibase.ru/</p>
<p>Телефоны: 953-13-34</p>
<p>источники: Borland International, Борланд АО, релиз Interbase 4.0, 4.1, 4.2, 5.0, 5.1, 5.5, 5.6, различные источники на WWW-серверах, текущая переписка, московский семинар по Delphi и конференции, листсервер ESUNIX1, листсервер mers.com.</p>
<p>Cоставитель: Дмитрий Кузьменко</p>

