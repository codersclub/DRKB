<h1>Kylix Tutorial. Часть 3. Работа с базами данных через dbExpress. Коннект &ndash; есть коннект</h1>
<div class="date">01.01.2007</div>


<p>Как говорилось раньше, SQLConnection предназначен для </p>
<p>  1. Подключения к базе данных с заданными параметрами</p>
<p>  2. Управления параметрами соединения и драйвера БД.</p>
<p>  3. Получения списка установленных драйверов баз данных и доступных соединений</p>
<p>  4. Создания, удаления, редактирования соединений.</p>
<p>  5. Управление транзакциями</p>
<p>  6. Выполнение SQL операторов</p>
<p>  7. Получение метаданных</p>


<p>Подключения к базе данных</p>
<p>Подключение к базе данных осуществляется установкой св-ва Connected в True, либо вызвом метода Open. Отключение - установка Connected в False или вызов метода Close. Перед подключением необходимо установить имя соединения (св-во ConnectionName). </p>
<p>Пример установления соединения в run-time:</p>

<p>  SQLConnection1.Connected:=false;</p>
<p>  SQLConnection1.ConnectionName:='test_connect';</p>
<p>  SQLConnection1.Connected:=true;</p>

<p>Управления параметрами соединения и драйвера БД.</p>
<p>Значения параметров по умолчанию для соединений хранятся в файле &lt;домашняя директория пользователя&gt;/.borland/dbxconnections или при отсутствии файлов по указанному пути в /usr/local/etc/dbxconnections.conf. Он представляет собой текстовый файл формата ini файлов. То есть содержит набор секций, заключенных в квадратные скобки и параметров в формате Имя параметра=значение параметра. Вот кускок этого файла:</p>

<p>[DB2Connection]</p>
<p>DriverName=DB2</p>
<p>BlobSize=-1</p>
<p>Database=DBNAME</p>

<p>Для драйверов настройки по умолчанию хранятся по указанным выше путям в файле dbxdrivers</p>
<p>Для получения настроек, в принципе можно анализировать содержимое этих файлов, написав собственный код, однако гораздо удобнее пользоваться стандартными решениями. Свойство Params типа TStrings предоставляет нам доступ к параметрам соединения. </p>

<p>Пример - установка имени и пароля пользователя: </p>
<p>SQLConection1.Params.Values['User_Name']:='SYSDBA';</p>
<p>SQLConection1.Params.Values['Password']:='masterkey';</p>

<p>Свойство LoadParamsOnConnect типа Boolean позволяет управлять автоматической установкой св-в DriverName и Params в значения по умолчанию для данного соединения перед установкой соединения. Данное св-во полезно лишь во время выполнения приложения при смене имени соединения. Во время разработки загрузка установка св-в по умолчанию происходит автоматически.</p>

<p>Получения списка установленных драйверов баз данных и доступных соединений</p>
<p>Способ №1: анализировать содержимое файлов dbxconnections и dbxdrivers. Неудобно надо писать много собственного кода (который уже написан программистами Borland).</p>

<p>Способ №2. Использование функций из модуля SqlExpr</p>
<p>  GetDriverNames(List: TStrings; DesignMode:Boolean = True) - получение списка доступных драйверов.</p>
<p>  List - список для заполнения именами драйверов</p>
<p>  DesignMode - в каком режиме разработки (true) или выполнения программы (false) вызывается функция.</p>
<p>Пример получение списка драйверов dbExpress:</p>
<pre>
procedure TForm1.Button2Click(Sender:TObject);
begin
  // cb_drivers - это комбобокс для отображения списка драйверов
  GetDriverNames(cb_drivers.Items, false);
end;
 
procedure GetConnectionNames(List: TStrings; Driver:string = ''; DesignMode:Boolean = True);
</pre>


<p>Получение списка доступных соединений.</p>
<p>List - список для заполнения именами драйверов</p>
<p>Driver - имя драйвера, к которому подключаются соединения</p>
<p>DesignMode - в каком режиме разработки (true) или выполнения программы (false) вызывается функция.</p>

<p>Пример получение списка соединений доступных для INTERBASE:</p>
<pre>
procedure TForm1.Button1Click(Sender:TObject);
begin
  // cb_conn - это комбобокс для отображения списка драйверов
  GetDriverNames(cb_conn.Items, 'INTERBASE', false);
end;
</pre>


<p>Использование данных функций удобно, но не дает полного контроля за соединениями. Сами эти функции в своей работе используют интерфейс IConnectionAdmin.</p>

<p>Способ №3 Использование интерфейса IConnectionAdmin (определен в модуле DBConnAdmin). Данный способ дает наиболее мощные возможности по работе с соединениями.</p>
<p>Пример получение списка драйверов:</p>
<pre>
Var
  ConnAdm: IConnectionAdmin;
Begin
  // Получаем ссылку на интрефейс
  ConnAdm:=GetConnctionAdmin;
  ConnAdm. GetConnectionNames(cb_drivers);
End;
</pre>

<p>Методы интерфейса IConnectionAdmin;</p>
<pre>
 
IConnectionAdmin = interface
    // Получение имен драйверов доступа к серверам БД
    function GetDriverNames(List: TStrings): Integer;
    // Получение параметров драйвера по умолчанию
    function GetDriverParams(const DriverName: string; Params: TStrings): Integer;
    // Получение имен файлов библиотек 
    procedure GetDriverLibNames(const DriverName: string;
      var LibraryName, VendorLibrary: string);
    // Получание списка соединений, доступных  для  заданного типа драйвера
    function GetConnectionNames(List: TStrings; DriverName: string): Integer;
   // Получение параметров соединения по умолчанию 
   function GetConnectionParams(const ConnectionName: string; Params: TStrings): Integer;
   // Получение значения параметра соединения
    procedure GetConnectionParamValues(const ParamName: string; Values: TStrings);
   // Добавление нового соединения
    procedure AddConnection(const ConnectionName, DriverName: string);
   // Удаление соединения
    procedure DeleteConnection(const ConnectionName: string);
   // Изменение параметров соединения по умолчанию
    procedure ModifyConnection(const ConnectionName: string; Params: TStrings);
   // Изменение имени соединения
    procedure RenameConnection(const OldName, NewName: string);
   //  Изменение параметров драйвера по умолчанию
    procedure ModifyDriverParams(const DriverName: string; Params: TStrings);
  end;
</pre>

<p>Создания, удаления, редактирования соединений.</p>
<p>Наверно, Вы уже догадались, что данные операции выполняются методами интерфейса IconnectionAdmin. Можно также и руками поправить файлы с конфигурациями, а можно двойным щелчком мыши на компоненте SQLConnection открыть диалог редактирования - выбирайте, что Вам удобнее.</p>

<p>Управление транзакциями</p>
<p>Вообще говоря, можно подтверждать или откатывать транзакции, передавая SQL запросы commit или rollback. Однако в SQLConnection определены специальные методы для управления транзакциями.</p>
<p>Начать новую транзакцию можно вызовом процедуры</p>

<p>Procedure StartTransaction( TransDesc: TTransactionDesc);</p>

<p>В качестве параметра передается структура с описанием транзакции, поля структуры:</p>
<p> &nbsp; TransactionID: LongWord - уникальный (уникальность обеспечивает программист) идентификатор транзакции.</p>
<p>  GlobalID:LongWord - как написано в доке, используется для транзакций в Oracle, зачем пока не ясно</p>
<p>  IsolationLevel - уровень изоляции транзакции, значения</p>
<p> &nbsp; xilDIRTYREAD - "грязное" чтение, транзакция видит все изменения других транзакций, даже если они еще не подтверждены</p>
<p> &nbsp; xilREADCOMMITES - видны только результаты подтвержденных транзакций, но изменения, сделанные другими после старта транзакции (во время ее выполнения) не видны в транзакции.</p>
<p> &nbsp; xilREPEATABLEREAD - гарантируется состоятельность полученных данных, даже если другие транзакции подтверждаются после старта текущей транзакции.</p>
<p> &nbsp; XilCUSTOM - специфический для данного сервера БД уровень изоляции, значение уровня изоляции определяется членом структуры CustomIsolationLevel. На данный момент не поддерживается в dbExpress</p>

<p>  CustomIsolationLevel:LongWord - см выше</p>

<p>Завершаться транзакции, как известно, могут либо подтверждением, либо откатом изменений. </p>
<p>Подтверждение </p>
<p> &nbsp; Procedure Commit (TransDesc: TTransactionDesc);</p>
<p> &nbsp; TransDesc - структура с описанием подтверждаемой транзакции</p>

<p>Откат</p>
<p> &nbsp; Procedure Rollback (TransDesc: TTransactionDesc);</p>
<p> &nbsp; TransDesc - структура с описанием откатываемой транзакции</p>

<p>Другие методы и свойства, связанные с управлением транзакциями</p>
<p>  TransactionLevel: SmallInt - идентификатор текущей транзакции, совпадает с TransactionID в описании транзакции</p>
<p>  TransactionSupported : LongBool - поддерживает ли БД транзакции</p>
<p>  InTransaction: Boolean - открыта ли транзакция?</p>

<p>Выполнение SQL операторов</p>
<p>В SQLConnection определены два метода для выполнения запросов к БД.</p>

<p>Function Execute (const SQL: string; Params:TParams; ResultSet: Pointer = nil):integer; </p>
<p>Выполняет запрос определенный в параметре SQL c параметрами, переданными в Params. Если в результате запроса были получены записи, то в ResultSet возвращается указатель на TCustomSQLDataSet, содержащий полученные записи. Возвращает количество полученных записей.</p>
<p>Если запрос не содержит параметров и не возвращает записей проще использовать вызов</p>

<p>Function ExecuteDirect(const SQL: string):LongWord;</p>
<p>Возвращает 0 при успешном завершении и код ошибки в случае неудачи.</p>

<p>Получение метаданных</p>
<p>В SQLConnection определен ряд методов для получения метаданных.</p>

<p>Получение списка таблиц и списка полей в таблице</p>

<p>Procedure GetTableNames(List: TStrings; SystemTables: boolean = false);</p>
<p>Если установить SystemTables в True будут выбраны только системные таблицы, в обратном случае набор таблиц определяется установками св-ва TableScope.</p>
<p>ВНИМАНИЕ: я пробовал устанавливать в TableScope все элементы, но при этом не получал списка таблиц (должны выбираться и системные и обычные таблицы)- кривые руки? Скорее глюк. Может Вам повезет больше. </p>
<p>Список полей может быть получен вызвом метода GetFieldNames</p>
<p>В SQLConnection он определен как </p>

<p>Procedure GetFieldNames(const TableName: string; List: TStrings);</p>

<p>Получение списка процедур и их параметров</p>
<p>  GetProcedureNames и GetProcedureParams</p>

<p>Получение списка индексов</p>
<p>  GetIndexNames</p>

<div class="author">Автор: Mike Goblin </div>
<p>Взято с сайта <a href="https://www.delphimaster.ru/" target="_blank">https://www.delphimaster.ru/</a></p>

<p>с разрешения автора.</p>

