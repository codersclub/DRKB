<h1>Провайдеры ADO</h1>
<div class="date">01.01.2007</div>


<p>Провайдеры ADO обеспечивают соединение приложения, использующего данные через ADO, с источником данных (сервером SQL, локальной СУБД, файловой системой и т. д.). Для каждого типа хранилища данных должен существовать провайдер ADO.</p>
<p>Провайдер "знает" о местоположении хранилища данных и его содержании, умеет обращаться к данным с запросами и интерпретировать возвращаемую служебную информацию и результаты запросов с целью их передачи приложению.</p>
<p>Список установленных в данной операционной системе провайдеров доступен для выбора при установке соединения через компонент TADOConnection.</p>
<p>При инсталляции Microsoft ActiveX Data Objects в операционной системе устанавливаются следующие стандартные провайдеры.</p>
<p> Microsoft Jet OLE DB Provider обеспечивает соединение с данными СУБД Access при посредстве технологии DАО.</p>
<p> Microsoft OLE DB Provider for Microsoft Indexing Service обеспечивает доступ только для чтения к файлам и Internet-ресурсам Microsoft Indexing Service.</p>
<p> Microsoft OLE DB Provider for Microsoft Active Directory Service обеспечивает доступ к ресурсам службы каталогов (Active Directory Service).</p>
<p> Microsoft OLE DB Provider for Internet Publishing позволяет использовать ресурсы, предоставляемые Microsoft FrontPage, Microsoft Internet Information Server, HTTP-файлы.</p>
<p> Microsoft Data Shaping Service for OLE DB позволяет использовать иерархические наборы данных.</p>
<p> Microsoft OLE DB Simple Provider предназначен для организации доступа к источникам данных, поддерживающим только базисные возможности OLE DB.</p>
<p> Microsoft OLE DB Provider for ODBC drivers обеспечивает доступ к данным, которые уже "прописаны" при помощи драйверов ODBC. Однако реальное использование столь экзотичных вариантов соединений представляется проблематичным. Драйверы ODBC и так славятся своей медлительностью, поэтому дополнительный слой сервисов здесь ни к чему.</p>
<p> Microsoft OLE DB Provider for Oracle обеспечивает соединение с сервером Oracle.</p>
<p> Microsoft OLE DB Provider for SQL Server обеспечивает соединение с сервером Microsoft SQL Server.</p>
