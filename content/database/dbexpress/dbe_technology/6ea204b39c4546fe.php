<h1>Драйверы доступа к данным</h1>
<div class="date">01.01.2007</div>


<p>Технология dbExpress обеспечивает доступ к серверу баз данных при помощи драйвера, реализованного как динамическая библиотека. Для каждого сервера имеется своя динамическая библиотека. </p>

<p>Драйверы dbExpress </p>

<p>Сервер БД&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Драйвер&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Клиентское ПО </p>

<p>DB2&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Dbexpdb2.dll&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Db2cli.dll </p>
<p>InterBase&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Dbexpint.dll&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;GDS32.DLL </p>
<p>Informix&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Dbexpinf.dll&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Isqlb09a.dll </p>
<p>MS SQL Server Dbexpmss.dll&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;OLE DB </p>
<p>MySQL&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Dbexpmys.dll&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;LIBMYSQL.DLL </p>
<p>Oracle&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;Dbexpora.dll&nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;OCI.DLL </p>

<p>Перечисленные в табл. файлы находятся в папке \Delphi7\Bin. </p>

<p>Для доступа к данным сервера драйвер должен быть установлен на компьютере клиента. Для доступа к данным драйвер взаимодействует с клиентским ПО сервера, которое также должно быть инсталлировано на клиентской стороне. </p>

<p>Стандартные настройки для каждого драйвера хранятся в файле \Borland Shared\DBExpress\dbxdrivers.ini. </p>

