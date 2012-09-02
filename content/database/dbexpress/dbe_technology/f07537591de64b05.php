<h1>Соединение с сервером баз данных</h1>
<div class="date">01.01.2007</div>


<p>Для создания соединения с сервером в рамках технологии dbExpress приложение должно использовать компонент TSQLConnection. Это обязательный компонент, все остальные компоненты связаны с ним и используют его для получения данных. </p>

<p>После переноса этого компонента в модуль данных или на форму необходимо выбрать тип сервера и настроить параметры соединения. </p>

<p>property ConnectionName: string; </p>

<p>позволяет выбрать из выпадающего списка конкретное настроенное соединение. По умолчанию разработчику доступно по одному настроенному соединению для каждого сервера БД. После выбора соединения автоматически устанавливаются значения свойств: </p>

<p>property DriverName: string; определяет используемый драйвер;&nbsp; </p>

<p>property LibraryName: string; задает динамическую библиотеку драйвера dbExpress; </p>

<p>property VendorLib: string; определяет динамическую библиотеку клиентского ПО сервера&nbsp; </p>

<p>property Params: TStrings; список этого свойства содержит настройки для выбранного соединения. </p>

<p>При необходимости все перечисленные свойства можно установить дополнительно. </p>

<p>Разработчик может дополнять и изменять список настроенных соединений. Для этого используется специализированный Редактор соединений dbExpress Connections (рис. 17.1). Он открывается после двойного щелчка на компоненте TSQLConnection или выбора команды Edit Connection Properties из всплывающего меню компонента. </p>
<p>В списке слева располагаются существующие соединения. В правой части для выбранного соединения отображаются текущие настройки. При помощи кнопок на Панели инструментов можно создавать, переименовывать и удалять соединения. Настройки также можно редактировать. </p>

<p>Список соединений в левой части соответствует списку выбора свойства ConnectionName в Инспекторе объектов. Настройки соединения из правой части отображаютсяв свойствее Params. </p>

<p>Настроенные соединения и их параметры сохраняются в файле \Borland Shared\DBExpress\dbxconnections.ini. </p>

<p class="note">Примечание </p>

<p>При установке Delphi 7 поверх Delphi 6 сведения о соединениях из старого файла dbxconnections.ini добавляются в новый. </p>

<p>Конкретные значения настроек соединений зависят от используемого сервера БД и требований приложения (табл. 17.2). </p>

<p>Настройка соединения dbExpress </p>

<p>Общие настройки </p>
<p>BlobSize Задает ограничение на объем пакета данных для данных BLOB </p>
<p>DriverName  Имя драйвера </p>
<p>ErrorResourceFile Файл сообщений об ошибках </p>
<p>LocaleCode  Код локализации, определяющий влияние национальных символов на сортировку данных </p>
<p>User Name Имя пользователя </p>
<p>Password Пароль </p>

<p>DB2 </p>
<p>Database Имя клиентского ядра </p>
<p>DB2 Translsolation Уровень изоляции транзакций </p>

<p>Informix </p>
<p>HostName Имя компьютера, на котором работает сервер Informix </p>
<p>Informix Translsolation Уровень изоляции транзакции </p>
<p>Trim Char Определяет, нужно ли удалять из строковых значений полей пробелы, дополняющие значение до полной строки, заданной размером поля данных </p>

<p>Interbase </p>
<p>CommitRetain Задает поведение курсора по завершении транзакции. При значении True курсор обновляется, иначе &#8212; удаляется </p>
<p>Database Имя файла базы данных (файл GDB) </p>
<p>InterBase Translsolation Уровень изоляции транзакции </p>
<p>RoleName Роль пользователя </p>
<p>SQLDialect Используемый диалект SQL. Для IntreBase 5 возможно только одно значение -1 </p>
<p>Trim Char Определяет, нужно ли удалять из строковых значений полей пробелы, дополняющие значение до полной строки, заданной размером поля данных </p>
<p>WaitOnLocks Разрешение на ожидание занятых ресурсов </p>

<p>Microsoft SQL Server 2000 </p>
<p>Database  Имя базы данных </p>
<p>HostName Имя компьютера, на котором работает сервер MS SQL Server 2000 </p>
<p>MSSQL Translsolation Уровень изоляции транзакции </p>
<p>OS Autenification  Использование учетной записи текущего пользователя операционной системы (домена или Active Directory) при доступе к ресурсам сервера </p>

<p>MySQL </p>
<p>Database Имя базы данных </p>
<p>HostName Имя компьютера, на котором работает сервер MySQL </p>

<p>Oracle </p>
<p>AutoCommit Флаг завершения транзакции. Устанавливается только сервером </p>
<p>BlockingMode Задает режим завершения запроса. При значении True соединение дожидается окончания запроса (синхронный режим), иначе &#8212; начинает выполнение следующего (асинхронный режим) </p>
<p>Database Запись базы данных в файле TNSNames.ora </p>
<p>Multiple Transaction Поддержка управлением несколькими транзакциями в одной сессии </p>
<p>Oracle Translsolation Уровень изоляции транзакций </p>
<p>OS Autenification  Использование учетной записи текущего пользователя операционной системы (домена или Active Directory) при доступе к ресурсам сервера </p>
<p>Trim Char Определяет, нужно ли удалять из строковых значений полей пробелы, дополняющие значение до полной&nbsp; строки, заданной размером поля данных </p>

<p>После выыбора настроенного соединения или выбора типа сервера и настройки параметров соединения компонент TSQLConnection готов к работе. </p>

<p>property Connected: Boolean; </p>

<p>открывает соединение с сервером при значении True. Аналогичную операцию выполняет метод </p>

<p>procedure Open; </p>

<p>После открытия соединения все компоненты dbExpress, инкапсулирующие наборы данных и связанные с открытым компонентом TSQLConnection, получают доступ к базе данных. </p>

<p>Соединение закрывается тем же свойством connected или методом </p>

<p>procedure Close; </p>

<p>При открытии и закрытии соединения разработчик может использовать обработчики событий </p>

<p>property BeforeConnect: TNotifyEvent;&nbsp; </p>
<p>property AfterConnect: TNotifyEvent; </p>
<p>property BeforeDisconnect: TNotifyEvent;&nbsp; </p>
<p>property AfterDisconnect: TNotifyEvent; </p>

<p>Например, на стороне клиента можно организовать проверку пользователя приложения: </p>

<pre>
procedure TForml.MyConnectionBeforeConnect(Sender: TObject); 
begin 
  if MyConnection.Params.Values['User_Name']) &lt;&gt; DefaultUser then 
 &nbsp;&nbsp; begin 
 &nbsp;&nbsp;&nbsp;&nbsp; MessageDlg('Wrong user name', mtError, [mbOK], 0); 
 &nbsp;&nbsp;&nbsp;&nbsp; Abort;&nbsp; 
 &nbsp;&nbsp; end;&nbsp; 
end; 
</pre>

<p>Свойство </p>

<p>property LoginPrompt: Boolean; </p>

<p>определяет, нужно ли отображать диалог авторизации пользователя перед открытием соединения. </p>

<p>О текущем состоянии соединения можно судить по значению свойства </p>

<p>TConnectionState = (csStateClosed, csStateOpen, csStateConnecting, csStateExecuting, csStateFetching, csStateDisconnecting); </p>

<p>property ConnectionState: TConnectionState; </p>

<p>Параметры соединения можно настраивать на этапе разработки в Инспекторе объектов или Редакторе соединений (см. рис. 17.1). Также это можно сделать и непосредственно перед открытием соединения, используя свойство Params или метод </p>

<p>procedure LoadParamsFromlniFile(AFileName : String = ''); </p>

<p>который загружает заранее подготовленные параметры из INI-файла. Проверить успешность этой операции можно при помощи свойства </p>

<p>property Params Loaded: Boolean; </p>

<p>значение True которого сигнализирует об успехе загрузки. </p>

<pre>
procedure TForml.StartBtnClickfSender: TObject); 
begin 
  if MyConnection.Params.Values['DriverName'] = " then 
 &nbsp;&nbsp; MyConnection.LoadParamsFromlniFile('c:\Temp\dbxalarmconnections.ini'); 
  if MyConnection.ParamsLoaded then 
 &nbsp;&nbsp; try 
 &nbsp;&nbsp;&nbsp;&nbsp; MyConnection.Open; 
 &nbsp;&nbsp; except 
 &nbsp;&nbsp;&nbsp;&nbsp; MessageDlgt'Database connection error', mtError, [mbOK], 0); 
 &nbsp;&nbsp; end;&nbsp; 
end; 
</pre>

