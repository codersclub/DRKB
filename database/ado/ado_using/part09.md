---
Title: TADOConnection
Date: 01.01.2007
---


TADOConnection
==============

::: {.date}
01.01.2007
:::

Компонент TADOConnection предназначен для управления соединением с
объектами хранилища данных ADO. Он обеспечивает доступ к хранилищу
данных компонентам ADO, инкапсулирующим набор данных (см. ниже).

Применение этого компонента дает разработчику ряд преимуществ:

все компоненты доступа к данным ADO обращаются к хранилищу данных через
одно соединение;

возможность напрямую задать объект провайдера соединения;

доступ к объекту соединения ADO;

возможность выполнять команды ADO;

выполнение транзакций;

расширенное управление соединением при помощи методов-обработчиков
событий.

Настройка соединения

Перед открытием соединения необходимо задать его параметры. Для этого
предназначено свойство

property ConnectionString: WideString;

которое подробно рассматривалось в разд. "Компонент TADOConnection".
Добавим лишь, что набор параметров изменяется в зависимости от типа
провайдера и может настраиваться как вручную, так и при помощи
специального редактора параметров соединения, который вызывается двойным
щелчком на компоненте TADOConnection, перенесенным на форму, или щелчком
на кнопке в поле редактирования свойства ConnectionString в Инспекторе
объектов. Здесь можно настроить соединение через свойство
ConnectionString (радиокнопка Use Connection String) или загрузить
параметры соединения из файла с расширением udl (радиокнопка Use Data
Link File).

Файл UDL  представляет собой обычный текстовый файл, в котором
указывается название параметра и через знак равенства его значение.
Параметры разделяются точкой с запятой.

[oledb]

Everything after this line is an OLE DB initstring

Provider=Microsoft.Jet.OLEDB.4.0;Data Source=C:\\Program Files\\Common
Files\\Borland Shared\\Data\\DBDEMOS.mdb

Если файл параметров соединения отсутствует, настройку придется
осуществлять вручную. Для этого следует нажать кнопку Build. В
результате появляется диалоговое окно Data Link Properties, в котором
можно настроить параметры соединения вручную. Оно представляет собой
четырехстраничный блокнот, позволяющий вам этап за этапом задать все
необходимые параметры.

Первая страница Provider позволяет выбрать провайдер OLE DB для
конкретного типа источника данных из числа провайдеров, установленных в
системе. Здесь вы видите провайдеры не только для серверов БД, но и
служб, установленных в операционной системе. Состав элементов управления
следующих страниц зависит от типа источника данных, но различается не
так уж сильно. Далее практически везде необходимо задать источник данных
(имя сервера, базу данных, файл и т. д.), режим аутентификации
пользователя, а также определить имя и пароль пользователя.

Следующая страница Connection настраивает источник данных.

На первом этапе требуется выбрать имя сервера из доступных для данного
компьютера.

Второй этап определяет режим аутентификации пользователя. Это либо
система безопасности Windows, либо собственная система аутентификации
сервера. Здесь же надо определить имя и пароль пользователя.

Третий этап предназначен для выбора базы данных сервера.

По окончании настройки источника данных вы можете проверить соединение,
нажав кнопку Test Connection.

Страница Advanced  задает дополнительные параметры соединения. В
зависимости от типа хранилища данных некоторые элементы этой страницы
могут быть недоступны.

Список Impersonation level определяет возможности клиентов при
подключении в соответствии с полномочиями их ролей. В списке могут быть
выбраны следующие значения:

Anonymous --- роль клиента недоступна серверу;

Identify --- роль клиента опознается сервером, но доступ к системным
объектам заблокирован;

Impersonate --- процесс сервера может быть представлен защищенным
контекстом клиента;

Delegate --- процесс сервера может быть представлен защищенным
контекстом клиента, при этом сервер может осуществлять другие
подключения.

Список Protection level позволяет задать уровень защиты данных. В списке
могут быть выбраны следующие значения:

None --- подтверждение не требуется;

Connect --- подтверждение необходимо только при подключении; 

Call --- подтверждение источника данных при каждом запросе; 

Pkt --- подтверждение получения от клиента всех данных;

Pkt Integrity --- подтверждение получения от клиента всех данных с
соблюдением целостности;

Pkt Privacy --- подтверждение получения от клиента всех данных с
соблюдением целостности и защита шифрованием.

В поле Connect timeout можно задать время ожидания соединения в
секундах. По истечении этого времени процесс прерывается.

При необходимости список Access permissions задает права доступа к
отдельным видам выполняемых операций. В списке можно выбрать следующие
значения:

Read --- только чтение;

ReadWrite --- чтение и запись;

Share Deny None --- полный доступ всем на чтение и запись;

Share Deny Read --- чтение запрещено всем;

Share Deny Write --- запись запрещена всем;

Share Exclusive --- чтение и запись запрещена всем;

Write --- только запись.

Последняя страница All позволяет просмотреть и при необходимости
изменить все сделанные настройки (для этого предназначена кнопка Edit
Value...) для выбранного провайдера.

После подтверждения сделанных в диалоге настроек из них формируется
значение свойства Connectionstring.

Управление соединением

Соединение с хранилищем данных ADO открывается и закрывается при помощи
свойства

property Connected: Boolean;

или методов

procedure Open; overload;

procedure Openfconst UserlD: WideString; const Password: WideString);
overload;

и

procedure Close;

Метод open является перегружаемым при необходимости использования
удаленного или локального соединения. Для удаленного соединения
применяется вариант с параметрами UserID и Password.

До и после открытия и закрытия соединения разработчик может использовать
соответствующие стандартные методы-обработчики событий:

property BeforeConnect: TNotifyEvent;

property BeforeDisconnect: TNotifyEvent; 

property AfterConnect: TNotifyEvent; 

property AfterDisconnect: TNotifyEvent;

Кроме этого, компонент TADOConnection имеет дополнительные
методы-обработчики. После получения подтверждения от провайдера о том,
что соединение будет открыто, перед его реальным открытием вызывается
метод

TWillConnectEvent = procedure(Connection: TADOConnection; var
Connectionstring, UserlD, Password: WideString; var ConnectOptions:
TConnectOption; 

var EventStatus: TEventStatus) of object;

property OnWillConnect: TWillConnectEvent;

Параметр Connection содержит указатель на вызвавший обработчик
компонент.

Параметры Connectionstring, userID и Password определяют строку
параметров, имя и пароль пользователя.

Соединение может быть синхронным или асинхронным, что и определяется
параметром ConnectOptions типа TConnectOption:

type TConnectOption = (coConnectUnspecified, coAsyncConnect);

coConnectunspecified --- синхронное соединение всегда ожидает результат
последнего запроса;

coAsyncConnect --- асинхронное соединение может выполнять новые запросы,
не дожидаясь ответа от предыдущих запросов.

Наконец, параметр Eventstatus позволяет определить успешность выполнения
посланного запроса на соединение:

type TEventStatus = (esOK, esErrorsOccured, esCantDeny, esCancel,
esUnwantedEvent);

esOK --- запрос на соединение выполнен успешно;

esErrorsOccured --- в процессе выполнения запроса возникла ошибка;

esCantDeny --- соединение не может быть прервано;

esCancel --- соединение было прервано до открытия;

esUnwantedEvent --- внутренний флаг ADO.

Например, в случае успешного соединения можно выбрать синхронный режим
работы компонента:

procedure TForml.ADOConnectionWillConnect(Connection: TADOConnection;

var ConnectionString, UserlD, Password: WideString;

var ConnectOptions: TConnectOption;

var Eventstatus: TEventStatus); 

begin

if Eventstatus = esOK then ConnectOptions := coConnectunspecified; 

end;

Кстати, параметр синхронности/асинхронности можно также задать при
помощи свойства

ConnectOptions property ConnectOptions: TConnectOption;

После открытия соединения для выполнения собственного кода можно
использовать метод-обработчик

TConnectErrorEvent = procedure(Connection: TADOConnection; Error: Error;

var Eventstatus: TEventStatus) of object; 

property OnConnectComplete: TConnectErrorEvent;

Здесь, если в процессе открытия соединения возникла ошибка, параметр
Eventstatus будет равен esErrorsOccured, а параметр Error содержит
объект ошибки ADO.

Теперь перейдем к вспомогательным свойствам и методам компонента
TADOConnection, обеспечивающим соединение.

Для ограничения времени открытия соединения для медленных каналов связи
используется свойство

property ConnectionTimeout: Integer;

задающее время ожидания открытия соединения в секундах. По умолчанию оно
равно 15 сек.

Также можно определить реакцию компонента на неиспользуемое соединение.
Если через соединение не подключен ни один активный компонент, свойство

property KeepConnection: Boolean;

в значении True сохраняет соединение открытым. Иначе, после закрытия
последнего связанного компонента ADO, соединение закрывается.

При необходимости провайдер соединения ADO определяется напрямую
свойством

property Provider: WideString;

Имя источника данных по умолчанию задается свойством

property DefaultDatabase: WideString;

Но если этот же параметр указан в строке соединения, то он перекрывает
собой значение свойства.

При необходимости прямой доступ к объекту соединения OLE DB обеспечивает
свойство

property ConnectionObject: \_Connection;

При открытии соединения необходимо вводить имя пользователя и его
пароль. Появление стандартного диалога управляется свойством

property LoginPrompt: Boolean;

Без этого диалога для задания данных параметров можно использовать
свойство Connectionstring, метод open (см. выше) или метод-обработчик

type TLoginEvent = procedure(Sender:TObject; Username, Password: string)
of object;

property OnLogin: TLoginEvent;

Свойство

type TConnectMode = (cmUnknown, cmRead, cmWrite, cinReadWrite,
cmShareDenyRead, cmShareDenyWrite, cmShareExclusive, cmShareDenyNone);

property Mode: TConnectMode;

задает доступные для соединения операции:

cmUnknown --- разрешение неизвестно или не может быть установлено;

cmRead --- разрешение на чтение;

cmwrite --- разрешение на запись;

cmReadWrite --- разрешение на чтение и запись;

cmshareDenyRead --- разрешение на чтение для других соединений
запрещено;

cmshareoenywrite --- разрешение на запись для других соединений
запрещено;

cmShareExciusive --- разрешение на открытие для других соединений
запрещено;

cmshareDenyNone --- открытие других соединений с разрешениями запрещено.

Доступ к связанным наборам данных и командам ADO

Компонент TADOconnection обеспечивает доступ ко всем компонентам,
которые используют его для доступа к хранилищу данных ADO. Все открытые
таким образом наборы данных доступны через индексированное свойство

property DataSets[Index: Integer]: TCustomADODataSet;

Каждый элемент этого списка содержит дескриптор компонента доступа к
данным ADO (тип TCustomADODataSet). Общее число связанных компонентов с
наборами данных возвращается свойством

property DataSetCount: Integer;

Для этих компонентов можно централизованно установить тип используемого
курсора при помощи свойства

type TCursorLocation = (clUseServer, clUseClient); property
CursorLocation: TCursorLocation;

Значение clUseClient задает локальный курсор на стороне клиента, что
позволяет выполнять любые операции с данными, в том числе не
поддерживаемые сервером.

Значение cIUseServer задает курсор на сервере, который реализует только
возможности сервера, но обеспечивает быструю обработку больших массивов
данных.

Например:

for i := 0 to ADOConnection.DataSetCount --- 1 do

begin

   if ADOConnection.DataSets[i].Active = True then     
ADOConnection.DataSets[i].Close;

   ADOConnection.DataSets[i].CursorLocation := clUseClient;

end;

Помимо наборов данных компонент TADOConnection обеспечивает выполнение
команд ADO. Команду ADO инкапсулирует специальный компонент TADOCommand,
который рассматривается ниже. Все команды ADO, работающие с хранилищем
данных через это соединение, доступны для управления через
индексированное свойство

property Commands[Index: Integer]: TADOCommand

Каждый элемент этого списка представляет собой экземпляр класса
TADOCommand.

Общее число доступных команд возвращается свойством

property CommandCount: Integer

Например, сразу после открытия соединения можно выполнить все связанные
команды ADO, реализовав таким образом нечто вроде скрипта:

procedure TForml.ADOConnectionConnectComplete(Connection:
TADOConnection; 

const Error: Error; var EventStatus: TEventStatus); 

var i, ErrorCnt: Integer;

begin

if EventStatus = esOK then

   for i := 0 to ADOConnection.CommandCount --- 1 do

    try

       if ADOConnection.Commands[i].CommandText \<\> then
                           ADOConnection.Commands[i].Execute;

     except

       on E: Exception do Inc(ErrorCnt);

   end; 

end;

Однако компонент TADOConnection может выполнять команды ADO
самостоятельно, без помощи других компонентов. Для этого используется
перегружаемый метод

function Execute(const CommandText: WideString; ExecuteOptions:
TExecuteOptions = []: \_RecordSet; overload;

procedure Execute(const CommandText: WideString; var RecordsAffected:

Integer; ExecuteOptions: TExecuteOptions =
[eoExecuteNoRecords];overload;

Выполнение команды осуществляется процедурой Execute (если команда не
возвращает набор записей) или одноименной функцией Execute (если команда
возвращает набор записей).

Параметр commandText должен содержать текст команды. Параметр
RecordsAffected возвращает число обработанных командой записей (если они
есть). Параметр

type

TExecuteOption = (eoAsyncExecute, eoAsyncFetch, eoAsyncFetchNonBlocking,
eoExecuteNoRecords);

TExecuteOptions = set of TExecuteOption;

задает условия выполнения команды:

eoAsyncExecute --- команда выполняется асинхронно (соединение не будет
ожидать окончания выполнения команды, а продолжит работу, обработав
сигнал о завершении команды, когда он поступит);

eoAsyncFetch --- команда получает необходимые записи также асинхронно;

eoAsyncFetchNonBlocking --- команда получает необходимые записи также
асинхронно, но при этом созданная нить не блокируется;

eoExecuteNoRecords --- команда не должна возвращать записи.

Если источник данных принял команду для выполнения и сообщил об этом
соединению, вызывается метод-обработчик

TWillExecuteEvent = procedure(Connection: TADOConnection;

var CommandText: WideString; var CursorType: TCursorType; var LockType:

TADOLockType; var ExecuteOptions: TExecuteOptions;  var EventStatus:

TEventStatus; const Command: \_Command;

const Recordset: \_Recordset) of object;

property OnWillExecute: TWillExecuteEvent;

После выполнения команды вызывается метод-обработчик

TExecuteCompleteEvent = procedure(Connection: TADOConnection;
RecordsAffected: Integer; const Error: Error; var EventStatus:
TEventStatus; 

const Command: \_Command; const Recordset: \_Recordset) of object;

property OnExecuteComplete: TExecuteCompleteEvent;

Объект ошибок ADO

Все ошибки времени выполнения, возникающие при открытом соединении,
сохраняются в специальном объекте ADO, инкапсулирующем коллекцию
сообщений об ошибках. Доступ к объекту возможен через свойство

property Errors: Errors;

Транзакции

Компонент TADOconnection позволяет выполнять транзакции. Методы

function BeginTrans: Integer;

procedure CommitTrans; 

procedure RollbackTrans;

обеспечивают начало, фиксацию и откат транзакции соответственно.
Методы-обработчики

TBeginTransCompleteEvent = procedure(Connection: TADOConnection;

TransactionLevel: Integer; 

const Error: Error; var EventStatus: TEventStatus) of object;

property OnBeginTransComplete: TBeginTransCompleteEvent;
TConnectErrorEvent = procedure(Connection: TADOConnection; Error: Error;
var EventStatus: TEventStatus) of object;

property OnCornmitTransComplete: TConnectErrorEvent;

вызываются после начала и фиксации транзакции. Свойство

type TIsolationLevel = (ilUnspecified, ilChaos, ilReadUncommitted,
ilBrowse, ilCursorStability, ilReadCorranitted, ilRepeatableRead,
ilSerializable, illsolated); 

property IsolationLevel: TIsolationLevel;

позволяет задать уровень изоляции транзакции:

IlUnspecifed --- уровень изоляции не задается;

Ilichaos --- изменения более защищенных транзакций не перезаписываются
данной транзакцией;

IlReadUncommitted --- незафиксированные изменения других транзакций
видимы;

IlBrowse --- незафиксированные изменения других транзакций видимы;

IlCursorStability --- изменения других транзакций видимы только после
фиксации;

IlReadCommitted --- изменения других транзакций видимы только после
фиксации;

IlRepeatableRead --- изменения других транзакций не видимы, но доступны
при обновлении данных;

ISerializable --- транзакция выполняется изолированно от других
транзакций;

Ilisolated --- транзакция выполняется изолированно от других транзакций.

Свойство

TXactAttribute = (xaCommitRetaining, xaAbortRetaining); property
Attributes: TXactAttributes;

задает способ управления транзакциями при их фиксации и откате:

xaCommitRetaining --- после фиксации очередной транзакции автоматически
начинается выполнение новой;

xaAbortRetaining --- после отката очередной транзакции автоматически
начинается выполнение новой.
