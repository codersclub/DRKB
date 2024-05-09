---
Title: Kylix Tutorial. Часть 3. Работа с базами данных через dbExpress. Коннект - есть коннект
Date: 06.07.2008
Author: Mike Goblin, mgoblin@mail.ru
Source: <https://www.delphimaster.ru/>
---


Kylix Tutorial. Часть 3. Работа с базами данных через dbExpress. Коннект - есть коннект
========================================================================================

Как говорилось раньше, SQLConnection предназначен для:

1. Подключения к базе данных с заданными параметрами
2. Управления параметрами соединения и драйвера БД.
3. Получения списка установленных драйверов баз данных и доступных соединений
4. Создания, удаления, редактирования соединений.
5. Управления транзакциями
6. Выполнения SQL операторов
7. Получения метаданных

**Подключение к базе данных**

Подключение к базе данных осуществляется установкой свойства Connected в
True, либо вызвом метода Open. Отключение - установка Connected в False
или вызов метода Close. Перед подключением необходимо установить имя
соединения (свойство ConnectionName).

Пример установления соединения в run-time:

    SQLConnection1.Connected:=false;
    SQLConnection1.ConnectionName:='test_connect';
    SQLConnection1.Connected:=true;

**Управление параметрами соединения и драйвера БД.**

Значения параметров по умолчанию для соединений хранятся в файле
`<домашняя директория пользователя>/.borland/dbxconnections` или при
отсутствии файлов по указанному пути в
`/usr/local/etc/dbxconnections.conf`.
Он представляет собой текстовый файл
формата ini файлов. То есть содержит набор секций, заключенных в
квадратные скобки и параметров в формате Имя параметра=значение
параметра. Вот кускок этого файла:

    [DB2Connection]
    DriverName=DB2
    BlobSize=-1
    Database=DBNAME

Для драйверов настройки по умолчанию хранятся по указанным выше путям в
файле dbxdrivers

Для получения настроек, в принципе можно анализировать содержимое этих
файлов, написав собственный код, однако гораздо удобнее пользоваться
стандартными решениями. Свойство Params типа TStrings предоставляет нам
доступ к параметрам соединения.

Пример - установка имени и пароля пользователя:

    SQLConection1.Params.Values['User_Name']:='SYSDBA';
    SQLConection1.Params.Values['Password']:='masterkey';

Свойство LoadParamsOnConnect типа Boolean позволяет управлять
автоматической установкой свойств DriverName и Params в значения по
умолчанию для данного соединения перед установкой соединения. Данное
свойство полезно лишь во время выполнения приложения при смене имени
соединения. Во время разработки загрузка установка свойств по умолчанию
происходит автоматически.

**Получение списка установленных драйверов баз данных и доступных соединений**

Способ №1
: анализировать содержимое файлов dbxconnections и dbxdrivers.  
Неудобно, надо писать много собственного кода (который уже написан
программистами Borland).

Способ №2
: Использование функций из модуля SqlExpr

**Получение списка доступных драйверов:**

    GetDriverNames(List: TStrings;
                   DesignMode:Boolean = True)

`List` - список для заполнения именами драйверов  
`DesignMode` - в каком режиме разработки (true) или выполнения программы
(false) вызывается функция.

Пример получения списка драйверов dbExpress:

    procedure TForm1.Button2Click(Sender:TObject);
    begin
      // cb_drivers - это комбобокс для отображения списка драйверов
      GetDriverNames(cb_drivers.Items, false);
    end;


**Получение списка доступных соединений:**

    procedure GetConnectionNames(List: TStrings;
                                 Driver:string = '';
                                 DesignMode:Boolean = True);

`List` - список для заполнения именами драйверов

`Driver` - имя драйвера, к которому подключаются соединения

`DesignMode` - в каком режиме разработки (true) или выполнения программы
(false) вызывается функция.

Пример получения списка соединений, доступных для INTERBASE:

    procedure TForm1.Button1Click(Sender:TObject);
    begin
      // cb_conn - это комбобокс для отображения списка драйверов
      GetDriverNames(cb_conn.Items, 'INTERBASE', false);
    end;

Использование данных функций удобно, но не дает полного контроля за
соединениями. Сами эти функции в своей работе используют интерфейс
IConnectionAdmin.

Способ №3.
: Использование интерфейса IConnectionAdmin (определен в модуле
DBConnAdmin). Данный способ дает наиболее мощные возможности по работе с
соединениями.

Пример - получение списка драйверов:

    Var
      ConnAdm: IConnectionAdmin;
    Begin
      // Получаем ссылку на интрефейс
      ConnAdm:=GetConnctionAdmin;
      ConnAdm. GetConnectionNames(cb_drivers);
    End;

Методы интерфейса IConnectionAdmin;

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

**Создание, удаление, редактирование соединений.**

Наверно, Вы уже догадались, что данные операции выполняются методами
интерфейса IconnectionAdmin. Можно также и руками поправить файлы с
конфигурациями, а можно двойным щелчком мыши на компоненте SQLConnection
открыть диалог редактирования - выбирайте, что Вам удобнее.

**Управление транзакциями**

Вообще говоря, можно подтверждать или откатывать транзакции, передавая
SQL запросы commit или rollback. Однако в SQLConnection определены
специальные методы для управления транзакциями.

Начать новую транзакцию можно вызовом процедуры

    Procedure StartTransaction( TransDesc: TTransactionDesc);

В качестве параметра передается структура с описанием транзакции, поля
структуры:

- TransactionID: LongWord - уникальный (уникальность обеспечивает
программист) идентификатор транзакции.
- GlobalID:LongWord - как написано в доке, используется для транзакций в
Oracle, зачем пока не ясно
- IsolationLevel - уровень изоляции транзакции, значения
- xilDIRTYREAD - "грязное" чтение, транзакция видит все изменения
других транзакций, даже если они еще не подтверждены
- xilREADCOMMITES - видны только результаты подтвержденных транзакций,
но изменения, сделанные другими после старта транзакции (во время ее
выполнения) не видны в транзакции.
- xilREPEATABLEREAD - гарантируется состоятельность полученных данных,
даже если другие транзакции подтверждаются после старта текущей
транзакции.
- XilCUSTOM - специфический для данного сервера БД уровень изоляции,
значение уровня изоляции определяется членом структуры
CustomIsolationLevel. На данный момент не поддерживается в dbExpress
- CustomIsolationLevel:LongWord - см выше

Завершаться транзакции, как известно, могут либо подтверждением, либо
откатом изменений.

**Подтверждение**

- Procedure Commit (TransDesc: TTransactionDesc);
- TransDesc - структура с описанием подтверждаемой транзакции

**Откат**

- Procedure Rollback (TransDesc: TTransactionDesc);
- TransDesc - структура с описанием откатываемой транзакции

**Другие методы и свойства, связанные с управлением транзакциями**

- `TransactionLevel: SmallInt` - идентификатор текущей транзакции, совпадает
с TransactionID в описании транзакции

- `TransactionSupported : LongBool` - поддерживает ли БД транзакции

- `InTransaction: Boolean` - открыта ли транзакция?

**Выполнение SQL операторов**

В SQLConnection определены два метода для выполнения запросов к БД.

    Function Execute (const SQL: string;
                      Params:TParams;
                      ResultSet: Pointer = nil):integer;

Выполняет запрос определенный в параметре SQL c параметрами, переданными
в Params. Если в результате запроса были получены записи, то в ResultSet
возвращается указатель на TCustomSQLDataSet, содержащий полученные
записи. Возвращает количество полученных записей.

Если запрос не содержит параметров и не возвращает записей проще
использовать вызов

    Function ExecuteDirect(const SQL: string):LongWord;

Возвращает 0 при успешном завершении и код ошибки в случае неудачи.

**Получение метаданных**

В SQLConnection определен ряд методов для получения метаданных.

Получение списка таблиц и списка полей в таблице:

    Procedure GetTableNames(List: TStrings; SystemTables: boolean = false);

Если установить SystemTables в True будут выбраны только системные
таблицы, в обратном случае набор таблиц определяется установками свойства
TableScope.

> **ВНИМАНИЕ:**  
> я пробовал устанавливать в TableScope все элементы, но при
> этом не получал списка таблиц (должны выбираться и системные и обычные
> таблицы) - кривые руки? Скорее глюк. Может Вам повезет больше.

Список полей может быть получен вызвом метода GetFieldNames.
В SQLConnection он определен как

    Procedure GetFieldNames(const TableName: string; List: TStrings);

`GetProcedureNames` и `GetProcedureParams` - Получение списка процедур и их параметров.

`GetIndexNames` - Получение списка индексов.

Автор: Mike Goblin

Взято с сайта <https://www.delphimaster.ru/>  
с разрешения автора.
