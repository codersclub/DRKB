<h1>Использование таблиц Access при помощи ODBC</h1>
<div class="date">01.01.2007</div>


<p>Из приложений Delphi вы можете получить доступ к .MDB-файлам Microsoft Access, используя драйверы ODBC. Delphi действительно может дать все необходимое, но некоторые вещи не столь очевидные. Вот шаги для достижения вашей цели.</p>

<p>Что вам нужно: Первое: проверьте, установлен ли ODBC Administrator (файл ODBCADM.EXE в WINDOWS\SYSTEM, вам также необходим файл DBCINST.DLL для установки новых драйверов и ODBC.DLL). Администратор ODBC должен присутствовать в Панели Управления в виде иконки ODBC. Если у вас его не было, то после установки Delphi он должен появиться. Если вы получаете сообщение типа "Your ODBC is not up-to-date IDAPI needs ODBC greater then 2.0", у вас имеется старая версия администратора и вы должны обновить ее до версии, включенной в поставку Delphi. Проверьте, имеете ли вы доступ к драйверу Access ODBC, установленному в Windows. Вы можете сделать это, щелкнув на "Drivers" в диалоговом окне "Data Sources", появляющемся при запуске ODBC Administrator. Delphi должна в диалоге добавить пункты Access Files (*.mdb) и Access Data (*.mdb), работающие с файлами Access 1.10 и использующие драйвер SIMBA.DLL (имейте в виду, что для данного DLL необходимы также файлы RED110.DLL и SIMADMIN.DLL, устанавливаемые для вас Delphi). Данные файлы должны поставляться с дистрибутивом вашей программы как часть ReportSmith Runtime библиотеки. Если вы хотите работать с файлами Access 2.0 или 2.5, вам необходимо иметь другой набор драйверов от Microsoft. Ключевой файл - MSAJT200.DLL, также необходимы файлы MSJETERR.DLL и MSJETINT.DLL. В США набор ODBC Desktop Drivers, Version 2.0. стоит $10.25. Он также доступен в январском выпуске MSDN, Level 2 (Development Platform) CD4 \ODBC\X86 как часть ODBC 2.1 SDK. Очевидно есть обновление этих драйверов для файлов Access 2.5 на форуме MSACCESS CompuServe. Имейте в виду, что драйвер Access ODBC, поставляемый с некоторыми приложениями Microsoft (например, MS Office) могут использоваться только другими MS-приложениями. К сожалению, они могут сыграть с вами злую шутку: сначала заработать, а потом отказать в совершенно неподходящий момент! Поэтому не обращайте внимания (запретите себе обращать внимание!) на строчку "Access 2.0 for MS Office (*.mdb)" в списке драйверов ODBC Administrator. Вы можете установить новые ODBC драйверы с помощью ODBC Administrator в Панели Управления.</p>

<p>Добавление источника данных ODBC (Data Source): если у вас имеются все необходимые файлы, можете начинать. Представленный здесь пример использует драйвер Access 1.10, обеспечиваемый Delphi. Используя ODBC Administrator, установите источник данных для ваших файлов Access: щелчок на кнопке "Add" в окне "data sources" выведет диалог "Add Data Source", выберите Access Files (*.mdb) (или что-либо подходящее, в зависимости от установленных драйверов). В диалоге "ODBC Microsoft Access Setup" необходимо ввести имя в поле "Data Source Name". В данном примере мы используем "My Test". Введите описание "Data Source" в поле Description. Щелкните на "Select Database" для открытия диалога "Select Database". Перейдите в директорию, где хранятся ваши Access .MDB-файлы и выберите один. Мы выберем файл TEST.MDB в директории C:\DELPROJ\ACCESS. Нажмите OK в диалоге "Setup". Теперь в списке источников данных (Data Sources) должен появиться "My Test" (Access Files *.mdb). Нажмите Close для выхода из ODBC Administrator. Используя этот метод, вы можете установить и другие, необходимые вам, источники данных.</p>

<p>Настройка Borland Database Engine: загрузите теперь Borland Database Engine (BDE) Configuration Utility. На странице "Drivers" щелкните на кнопке New ODBC Driver. Имейте в виду, что это добавит драйвер Access в BDE и полностью отдельное управление дополнительно к драйверам Access в Windows, устанавливаемым при помощи ODBC Administrator. В открывшемся диалоге Add ODBC Driver в верхнем поле редактировании введите ACCESS (или что-то типа этого). BDE автоматически добавит на первое место ODBC_. В combobox, расположенном немного ниже, выберите Access Files (*.mdb). Выберите Data Source в следующем combobox (Default Data Source Name), это должен быть источник данных, который вы установили с помощью ODBC Administration Utility. Здесь можно не беспокоиться о вашем выборе, поскольку позднее это можно изменить (позже вы узнаете как это можно сделать). Нажмите OK. После установки драйвера BDE, вы можете использовать его более чем с одним источником данных ODBC, применяя различные псевдонимы (Alias) для каждого ODBC Data Source. Для установки псевдонима переключитесь на страницу "Aliases" и нажмите на кнопку "New Alias". В диалоговом окне "Add New Alias" введите необходимое имя псевдонима в поле "Alias Name". В нашем примере мы используем MY_TEST (не забывайте, что пробелы в псевдониме недопустимы). В combobox Alias Type выберите имя ODBC-драйвера, который вы только что создали (в нашем случае ODBC_ACCESS). Нажмите OK. Если вы имеете более одного ODBC Data Source, измените параметр ODBC DSN ("DSN" = "Data Source Name") в списке "Parameters" псевдонима на подходящий источник данных ODBC Data Source, как установлено в ODBC Administrator. Имейте в виду, что вы не должны ничего добавлять в параметр Path (путь), так как ODBC Data Source уже имеет эту информацию. Если вы добавляете параметр Path, убедитесь, что путь правильный, в противном случае ничего работать не будет! Теперь сохраните конфигурацию BDE, выбирая пункты меню File|Save, и выходите из Database Engine Configuration Utility.</p>

<p>В Delphi: Создайте новый проект и расположите на форме компоненты Table и DataSource из вкладки Data Access палитры компонентов. Затем из вкладки Data Controls выберите компонент DBGrid и также расположите его на форме. В Table, в Инспекторе Объектов, назначьте свойству DatabaseName псевдоним MY_TEST, установленный нами в BDE Configuration Utility. Теперь спуститесь ниже и раскройте список TableName. Вас попросят зарегистрироваться в базе данных Access MY_TEST. Обратите внимание, что если бюджет не установлен, то User Name и Password можно не заполнять, просто нажмите на кнопку OK. После некоторой паузы раскроется список, содержащий доступные таблицы для ODBC Data Source указанного псевдонима BDE. Выберите TEST. В DataSource, в Инспекторе Объектов, назначьте свойству DataSet таблицу Table1. В DBGrid, также в Инспекторе Объектов, назначьте свойству DataSource значение DataSource1. Возвратитесь к таблице, и в том же Инспекторе Объектов установите свойство Active в True. Данные из таблицы TEST отобразятся в табличной сетке. Это все! Одну вещь все-таки стоит упомянуть: если вы создаете приложение, использующее таблицы Access и запускаете его из-под Delphi IDE, то при попытке изменения данных в таблице(ах) вы получите ошибку. Если же вы запустите скомпилированный .EXE-файл вне Delphi (предварительно Delphi закрыв), то все будет ОК. Сообщения об ошибках ODBC, к несчастью, очень туманные и бывает достаточно трудно понять его источник в вашем приложении, в этом случае проверьте установку ODBC Administrator и BDE Configuration Utility, они также могут помочь понять источник ошибки. Для получения дополнительной информации обратитесь к ODBC 2.0 Programmer's Reference или SDK Guide от Microsoft Press (ISBN 1-55615-658-8, цена в США составляет $24.95). В этом документе вы получите исчерпывающую информацию о возможных ошибках при использовании Access-файлов посредством ODBC. Также здесь вы можете найти рапорты пользователей о найденных ошибках, в том числе и при использовании Delphi. Более того, я выяснил, что большинство описанных проблем возникает при неправильных настройках ODBC, т.е. те шаги, которые я описал выше. Надеюсь, что с развитием технологии доступа к базам данных такие сложности уйдут в прошлое. Кроме того, имейте в виду, что если вам необходимо создать новую таблицу Access 1.10, вы можете воспользоваться Database Desktop, включаемый в поставку Delphi.</p>

<p>Авторы данной технологии Ralph Friedman (CompuServe 100064,3102), Bob Swart и Chris Frizelle.</p>
<p>Взято из Советов по Delphi, Сборник Kuliba</p>

<div class="author">Автор: Валентин Озеров, mailto:webmaster@webinspector.com</div>

<hr />

Может кто-нибудь, предпочтительно из персонала Borland, ПОЖАЛУЙСТА, дать мне ПОЛНЫЙ рассказ о том, как с помощью Delphi и сопутствующего программного обеспечения получить доступ и работать с базами данных MS Access. Среди прочего, мне необходимо узнать...</p>

<p>Нижеследующая инструкция в точности повторяет ту технологию, с которой я работаю на данный момент, надеюсь, что это поможет.</p>

<p>Драйвер ODBC, предусмотренный для доступа к Access 2.0, разработан только для работы в пределах среды Microsoft Office. Для работы со связкой ODBC/Access в Delphi, вам необходим Microsoft ODBC Desktop Driver kit, part# 273-054-030, доступный через Microsoft Direct за $10.25US (если вы живете не в США, воспользуйтесь службой WINEXT). Он также доступен в январском выпуске MSDN, Level 2 (Development Platform) CD4 \ODBC\X86 как часть ODBC 2.1 SDK. Имейте в виду, что смена драйверов (в частности Desktop Drivers) может негативно сказаться на работе других приложений Microsoft. Для информации (и замечаний) обращайтесь в форум WINEXT.</p>

<p>Также вам необходимы следующие файлы ODBC:</p>

<p> Минимум:</p>
<p>  ODBC.DLL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 03.10.1994, Версия 2.00.1510</p>
<p>  ODBCINST.DLL&nbsp;&nbsp; 03.10.1994, Версия 2.00.1510</p>
<p>  ODBCINST.HLP&nbsp;&nbsp; 11.08.1993</p>
<p>  ODBCADM.EXE&nbsp;&nbsp;&nbsp; 11.08.1993, Версия 1.02.3129</p>

<p> Рекомендуется:</p>
<p>  ODBC.DLL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 12.07.1994, Версия 2.10.2401</p>
<p>  ODBCINST.DLL&nbsp;&nbsp; 12.07.1994, Версия 2.10.2401</p>
<p>  ODBCINST.HLP&nbsp;&nbsp; 12.07.1994</p>
<p>  ODBCADM.EXE&nbsp;&nbsp;&nbsp; 12.07.1994, Версия 2.10.2309</p>

<p>Нижеследующие шаги приведут вас к искомой цели:</p>

<table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">1.</td><td>Используя администратора ODBC, установите источник данных (datasource) для вашей базы данных. Не забудьте задать путь к вашему mdb-файлу. Для нашего примера создайте источник с именем MYDSN.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">2.</td><td>Загрузите утилиту BDE Configuration.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">3.</td><td>Выберите пункт "New Driver".</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">4.</td><td>Назначьте драйверу имя (в нашем случае ODBC_MYDSN).</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">5.</td><td>В выпадающем списке драйверов выберите "Microsoft Access Driver (*.mdb)</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">6.</td><td>В выпадающем списке имен выберите MYDSN</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">7.</td><td>Перейдите на страницу "Alias" (псевдонимы).</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">8.</td><td>Выберите "New Alias" (новый псевдоним).</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">9.</td><td>Введите MYDSN в поле имени.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">10.</td><td>Для Alias Type (тип псевдонима) выберите ODBC_MYDSN.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">11.</td><td>На форме Delphi разместите компоненты DataSource, Table, и DBGrid.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">12.</td><td>Установите DBGrid1.DataSource на DataSource1.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">13.</td><td>Установите DataSource1.DataSet на Table1.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">14.</td><td>Установите Table1.DatabaseName на MYDSN.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">15.</td><td>В свойстве TableName компонента Table1 щелкните на стрелочку "вниз" и вы увидите диалог "Login". Нажмите OK и после короткой паузы вы увидите список всех имен ваших таблиц. Выберите одно.</td></tr></table><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="27">16.</td><td>Установите свойство Active Table1 в True и данные вашей таблицы появятся в табличной сетке.</td></tr></table>
<hr />
<p class="note">Примечание Vit</p>
<p>С появлением и продвижением микрософтом OLE DB и реализацией в Дельфи ADO (начиная с версии 5.0) работа с MS Access через ODBC перестала быть актуальной. За исключением особых случаев рекомендуется пользоваться именно ADO линейкой компонентов для связи с MS Access</p>

