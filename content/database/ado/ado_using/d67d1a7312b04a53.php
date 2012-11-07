<h1>TADOConnection</h1>
<div class="date">01.01.2007</div>


<p>Компонент TADOConnection предназначен для управления соединением с объектами хранилища данных ADO. Он обеспечивает доступ к хранилищу данных компонентам ADO, инкапсулирующим набор данных (см. ниже).</p>
<p>Применение этого компонента дает разработчику ряд преимуществ:</p>
<p> все компоненты доступа к данным ADO обращаются к хранилищу данных через одно соединение;</p>
<p> возможность напрямую задать объект провайдера соединения;</p>
<p> доступ к объекту соединения ADO;</p>
<p> возможность выполнять команды ADO;</p>
<p> выполнение транзакций;</p>
<p> расширенное управление соединением при помощи методов-обработчиков событий.</p>
<p>Настройка соединения</p>
<p>Перед открытием соединения необходимо задать его параметры. Для этого предназначено свойство</p>
<p>property ConnectionString: WideString;</p>
<p>которое подробно рассматривалось в разд. "Компонент TADOConnection". Добавим лишь, что набор параметров изменяется в зависимости от типа провайдера и может настраиваться как вручную, так и при помощи специального редактора параметров соединения, который вызывается двойным щелчком на компоненте TADOConnection, перенесенным на форму, или щелчком на кнопке в поле редактирования свойства ConnectionString в Инспекторе объектов. Здесь можно настроить соединение через свойство ConnectionString (радиокнопка Use Connection String) или загрузить параметры соединения из файла с расширением udl (радиокнопка Use Data Link File).</p>
<p>Файл UDL  представляет собой обычный текстовый файл, в котором указывается название параметра и через знак равенства его значение. Параметры разделяются точкой с запятой.</p>
<p>[oledb]</p>
<p>Everything after this line is an OLE DB initstring</p>
<p>Provider=Microsoft.Jet.OLEDB.4.0;Data Source=C:\Program Files\Common Files\Borland Shared\Data\DBDEMOS.mdb</p>
<p>Если файл параметров соединения отсутствует, настройку придется осуществлять вручную. Для этого следует нажать кнопку Build. В результате появляется диалоговое окно Data Link Properties, в котором можно настроить параметры соединения вручную. Оно представляет собой четырехстраничный блокнот, позволяющий вам этап за этапом задать все необходимые параметры.</p>
<p>Первая страница Provider позволяет выбрать провайдер OLE DB для конкретного типа источника данных из числа провайдеров, установленных в системе. Здесь вы видите провайдеры не только для серверов БД, но и служб, установленных в операционной системе. Состав элементов управления следующих страниц зависит от типа источника данных, но различается не так уж сильно. Далее практически везде необходимо задать источник данных (имя сервера, базу данных, файл и т. д.), режим аутентификации пользователя, а также определить имя и пароль пользователя.</p>
<p>Следующая страница Connection настраивает источник данных.</p>
<p>На первом этапе требуется выбрать имя сервера из доступных для данного компьютера.</p>
<p>Второй этап определяет режим аутентификации пользователя. Это либо система безопасности Windows, либо собственная система аутентификации сервера. Здесь же надо определить имя и пароль пользователя.</p>
<p>Третий этап предназначен для выбора базы данных сервера.</p>
<p>По окончании настройки источника данных вы можете проверить соединение, нажав кнопку Test Connection.</p>
<p>Страница Advanced  задает дополнительные параметры соединения. В зависимости от типа хранилища данных некоторые элементы этой страницы могут быть недоступны.</p>
<p>Список Impersonation level определяет возможности клиентов при подключении в соответствии с полномочиями их ролей. В списке могут быть выбраны следующие значения:</p>
<p> Anonymous &#8212; роль клиента недоступна серверу;</p>
<p> Identify &#8212; роль клиента опознается сервером, но доступ к системным объектам заблокирован;</p>
<p> Impersonate &#8212; процесс сервера может быть представлен защищенным контекстом клиента;</p>
<p> Delegate &#8212; процесс сервера может быть представлен защищенным контекстом клиента, при этом сервер может осуществлять другие подключения.</p>
<p>Список Protection level позволяет задать уровень защиты данных. В списке могут быть выбраны следующие значения:</p>
<p> None &#8212; подтверждение не требуется;</p>
<p> Connect &#8212; подтверждение необходимо только при подключении;</p>
<p>  Call &#8212; подтверждение источника данных при каждом запросе;</p>
<p> Pkt &#8212; подтверждение получения от клиента всех данных;</p>
<p> Pkt Integrity &#8212; подтверждение получения от клиента всех данных с соблюдением целостности;</p>
<p> Pkt Privacy &#8212; подтверждение получения от клиента всех данных с соблюдением целостности и защита шифрованием.</p>
<p>В поле Connect timeout можно задать время ожидания соединения в секундах. По истечении этого времени процесс прерывается.</p>
<p>При необходимости список Access permissions задает права доступа к отдельным видам выполняемых операций. В списке можно выбрать следующие значения:</p>
<p>Read &#8212; только чтение;</p>
<p>ReadWrite &#8212; чтение и запись;</p>
<p> Share Deny None &#8212; полный доступ всем на чтение и запись;</p>
<p>  Share Deny Read &#8212; чтение запрещено всем;</p>
<p> Share Deny Write &#8212; запись запрещена всем;</p>
<p> Share Exclusive &#8212; чтение и запись запрещена всем;</p>
<p> Write &#8212; только запись.</p>
<p>Последняя страница All позволяет просмотреть и при необходимости изменить все сделанные настройки (для этого предназначена кнопка Edit Value...) для выбранного провайдера.</p>
<p>После подтверждения сделанных в диалоге настроек из них формируется значение свойства Connectionstring.</p>
<p>Управление соединением</p>
<p>Соединение с хранилищем данных ADO открывается и закрывается при помощи свойства</p>
<p>property Connected: Boolean;</p>
<p>или методов</p>
<p>procedure Open; overload;</p>
<p>procedure Openfconst UserlD: WideString; const Password: WideString); overload;</p>
<p>и</p>
<p>procedure Close;</p>
<p>Метод open является перегружаемым при необходимости использования удаленного или локального соединения. Для удаленного соединения применяется вариант с параметрами UserID и Password.</p>
<p>До и после открытия и закрытия соединения разработчик может использовать соответствующие стандартные методы-обработчики событий:</p>
<p>property BeforeConnect: TNotifyEvent;</p>
<p>property BeforeDisconnect: TNotifyEvent;</p>
<p>property AfterConnect: TNotifyEvent;</p>
<p>property AfterDisconnect: TNotifyEvent;</p>
<p>Кроме этого, компонент TADOConnection имеет дополнительные методы-обработчики. После получения подтверждения от провайдера о том, что соединение будет открыто, перед его реальным открытием вызывается метод</p>
<p>TWillConnectEvent = procedure(Connection: TADOConnection; var Connectionstring, UserlD, Password: WideString; var ConnectOptions: TConnectOption;</p>
<p>var EventStatus: TEventStatus) of object;</p>
<p>property OnWillConnect: TWillConnectEvent;</p>
<p>Параметр Connection содержит указатель на вызвавший обработчик компонент.</p>
<p>Параметры Connectionstring, userID и Password определяют строку параметров, имя и пароль пользователя.</p>
<p>Соединение может быть синхронным или асинхронным, что и определяется параметром ConnectOptions типа TConnectOption:</p>
<p>type TConnectOption = (coConnectUnspecified, coAsyncConnect);</p>
<p>coConnectunspecified &#8212; синхронное соединение всегда ожидает результат последнего запроса;</p>
<p>coAsyncConnect &#8212; асинхронное соединение может выполнять новые запросы, не дожидаясь ответа от предыдущих запросов.</p>
<p>Наконец, параметр Eventstatus позволяет определить успешность выполнения посланного запроса на соединение:</p>
<p>type TEventStatus = (esOK, esErrorsOccured, esCantDeny, esCancel, esUnwantedEvent);</p>
<p>esOK &#8212; запрос на соединение выполнен успешно;</p>
<p>esErrorsOccured &#8212; в процессе выполнения запроса возникла ошибка;</p>
<p>esCantDeny &#8212; соединение не может быть прервано;</p>
<p>esCancel &#8212; соединение было прервано до открытия;</p>
<p>esUnwantedEvent &#8212; внутренний флаг ADO.</p>
<p>Например, в случае успешного соединения можно выбрать синхронный режим работы компонента:</p>
<p>procedure TForml.ADOConnectionWillConnect(Connection: TADOConnection;</p>
<p> var ConnectionString, UserlD, Password: WideString;</p>
<p> var ConnectOptions: TConnectOption;</p>
<p> var Eventstatus: TEventStatus);</p>
<p>begin</p>
<p>  if Eventstatus = esOK then ConnectOptions := coConnectunspecified;</p>
<p>end;</p>
<p>Кстати, параметр синхронности/асинхронности можно также задать при помощи свойства</p>
<p>ConnectOptions property ConnectOptions: TConnectOption;</p>
<p>После открытия соединения для выполнения собственного кода можно использовать метод-обработчик</p>
<p>TConnectErrorEvent = procedure(Connection: TADOConnection; Error: Error;</p>
<p> var Eventstatus: TEventStatus) of object;</p>
<p>property OnConnectComplete: TConnectErrorEvent;</p>
<p>Здесь, если в процессе открытия соединения возникла ошибка, параметр Eventstatus будет равен esErrorsOccured, а параметр Error содержит объект ошибки ADO.</p>
<p>Теперь перейдем к вспомогательным свойствам и методам компонента TADOConnection, обеспечивающим соединение.</p>
<p>Для ограничения времени открытия соединения для медленных каналов связи используется свойство</p>
<p>property ConnectionTimeout: Integer;</p>
<p>задающее время ожидания открытия соединения в секундах. По умолчанию оно равно 15 сек.</p>
<p>Также можно определить реакцию компонента на неиспользуемое соединение. Если через соединение не подключен ни один активный компонент, свойство</p>
<p>property KeepConnection: Boolean;</p>
<p>в значении True сохраняет соединение открытым. Иначе, после закрытия последнего связанного компонента ADO, соединение закрывается.</p>
<p>При необходимости провайдер соединения ADO определяется напрямую свойством</p>
<p>property Provider: WideString;</p>
<p>Имя источника данных по умолчанию задается свойством</p>
<p>property DefaultDatabase: WideString;</p>
<p>Но если этот же параметр указан в строке соединения, то он перекрывает собой значение свойства.</p>
<p>При необходимости прямой доступ к объекту соединения OLE DB обеспечивает свойство</p>
<p>property ConnectionObject: _Connection;</p>
<p>При открытии соединения необходимо вводить имя пользователя и его пароль. Появление стандартного диалога управляется свойством</p>
<p>property LoginPrompt: Boolean;</p>
<p>Без этого диалога для задания данных параметров можно использовать свойство Connectionstring, метод open (см. выше) или метод-обработчик</p>
<p>type TLoginEvent = procedure(Sender:TObject; Username, Password: string) of object;</p>
<p>property OnLogin: TLoginEvent;</p>
<p>Свойство</p>
<p>type TConnectMode = (cmUnknown, cmRead, cmWrite, cinReadWrite, cmShareDenyRead, cmShareDenyWrite, cmShareExclusive, cmShareDenyNone);</p>
<p>property Mode: TConnectMode;</p>
<p>задает доступные для соединения операции:</p>
<p>cmUnknown &#8212; разрешение неизвестно или не может быть установлено;</p>
<p>cmRead &#8212; разрешение на чтение;</p>
<p>cmwrite &#8212; разрешение на запись;</p>
<p>cmReadWrite &#8212; разрешение на чтение и запись;</p>
<p>cmshareDenyRead &#8212; разрешение на чтение для других соединений запрещено;</p>
<p>cmshareoenywrite &#8212; разрешение на запись для других соединений запрещено;</p>
<p>cmShareExciusive &#8212; разрешение на открытие для других соединений запрещено;</p>
<p>cmshareDenyNone &#8212; открытие других соединений с разрешениями запрещено.</p>
<p>Доступ к связанным наборам данных и командам ADO</p>
<p>Компонент TADOconnection обеспечивает доступ ко всем компонентам, которые используют его для доступа к хранилищу данных ADO. Все открытые таким образом наборы данных доступны через индексированное свойство</p>
<p>property DataSets[Index: Integer]: TCustomADODataSet;</p>
<p>Каждый элемент этого списка содержит дескриптор компонента доступа к данным ADO (тип TCustomADODataSet). Общее число связанных компонентов с наборами данных возвращается свойством</p>
<p>property DataSetCount: Integer;</p>
<p>Для этих компонентов можно централизованно установить тип используемого курсора при помощи свойства</p>
<p>type TCursorLocation = (clUseServer, clUseClient); property CursorLocation: TCursorLocation;</p>
<p>Значение clUseClient задает локальный курсор на стороне клиента, что позволяет выполнять любые операции с данными, в том числе не поддерживаемые сервером.</p>
<p>Значение cIUseServer задает курсор на сервере, который реализует только возможности сервера, но обеспечивает быструю обработку больших массивов данных.</p>
<p>Например:</p>
<p>for i := 0 to ADOConnection.DataSetCount &#8212; 1 do</p>
<p>  begin</p>
<p>    if ADOConnection.DataSets[i].Active = True then       ADOConnection.DataSets[i].Close;</p>
<p>    ADOConnection.DataSets[i].CursorLocation := clUseClient;</p>
<p>  end;</p>
<p>Помимо наборов данных компонент TADOConnection обеспечивает выполнение команд ADO. Команду ADO инкапсулирует специальный компонент TADOCommand, который рассматривается ниже. Все команды ADO, работающие с хранилищем данных через это соединение, доступны для управления через индексированное свойство</p>
<p>property Commands[Index: Integer]: TADOCommand</p>
<p>Каждый элемент этого списка представляет собой экземпляр класса TADOCommand.</p>
<p>Общее число доступных команд возвращается свойством</p>
<p>property CommandCount: Integer</p>
<p>Например, сразу после открытия соединения можно выполнить все связанные команды ADO, реализовав таким образом нечто вроде скрипта:</p>
<p>procedure TForml.ADOConnectionConnectComplete(Connection: TADOConnection;</p>
<p>  const Error: Error; var EventStatus: TEventStatus);</p>
<p>var i, ErrorCnt: Integer;</p>
<p>begin</p>
<p>  if EventStatus = esOK then</p>
<p>    for i := 0 to ADOConnection.CommandCount &#8212; 1 do</p>
<p>      try</p>
<p>        if ADOConnection.Commands[i].CommandText &lt;&gt; then                             ADOConnection.Commands[i].Execute;</p>
<p>      except</p>
<p>        on E: Exception do Inc(ErrorCnt);</p>
<p>      end;</p>
<p>end;</p>
<p>Однако компонент TADOConnection может выполнять команды ADO самостоятельно, без помощи других компонентов. Для этого используется перегружаемый метод</p>
<p>function Execute(const CommandText: WideString; ExecuteOptions: TExecuteOptions = []): _RecordSet; overload;</p>
<p>procedure Execute(const CommandText: WideString; var RecordsAffected:</p>
<p> Integer; ExecuteOptions: TExecuteOptions = [eoExecuteNoRecords]);overload;</p>
<p>Выполнение команды осуществляется процедурой Execute (если команда не возвращает набор записей) или одноименной функцией Execute (если команда возвращает набор записей).</p>
<p>Параметр commandText должен содержать текст команды. Параметр RecordsAffected возвращает число обработанных командой записей (если они есть). Параметр</p>
<p>type</p>
<p>TExecuteOption = (eoAsyncExecute, eoAsyncFetch, eoAsyncFetchNonBlocking, eoExecuteNoRecords);</p>
<p>TExecuteOptions = set of TExecuteOption;</p>
<p>задает условия выполнения команды:</p>
<p> eoAsyncExecute &#8212; команда выполняется асинхронно (соединение не будет ожидать окончания выполнения команды, а продолжит работу, обработав сигнал о завершении команды, когда он поступит);</p>
<p> eoAsyncFetch &#8212; команда получает необходимые записи также асинхронно;</p>
<p> eoAsyncFetchNonBlocking &#8212; команда получает необходимые записи также асинхронно, но при этом созданная нить не блокируется;</p>
<p> eoExecuteNoRecords &#8212; команда не должна возвращать записи.</p>
<p>Если источник данных принял команду для выполнения и сообщил об этом соединению, вызывается метод-обработчик</p>
<p>TWillExecuteEvent = procedure(Connection: TADOConnection;</p>
<p>  var CommandText: WideString; var CursorType: TCursorType; var LockType:</p>
<p>  TADOLockType; var ExecuteOptions: TExecuteOptions;  var EventStatus:</p>
<p>  TEventStatus; const Command: _Command;</p>
<p>  const Recordset: _Recordset) of object;</p>
<p>property OnWillExecute: TWillExecuteEvent;</p>
<p>После выполнения команды вызывается метод-обработчик</p>
<p>TExecuteCompleteEvent = procedure(Connection: TADOConnection; RecordsAffected: Integer; const Error: Error; var EventStatus: TEventStatus;</p>
<p>const Command: _Command; const Recordset: _Recordset) of object;</p>
<p>property OnExecuteComplete: TExecuteCompleteEvent;</p>
<p>Объект ошибок ADO</p>
<p>Все ошибки времени выполнения, возникающие при открытом соединении, сохраняются в специальном объекте ADO, инкапсулирующем коллекцию сообщений об ошибках. Доступ к объекту возможен через свойство</p>
<p>property Errors: Errors;</p>
<p>Транзакции</p>
<p>Компонент TADOconnection позволяет выполнять транзакции. Методы</p>
<p>function BeginTrans: Integer;</p>
<p>procedure CommitTrans;</p>
<p>procedure RollbackTrans;</p>
<p>обеспечивают начало, фиксацию и откат транзакции соответственно. Методы-обработчики</p>
<p>TBeginTransCompleteEvent = procedure(Connection: TADOConnection;</p>
<p>TransactionLevel: Integer;</p>
<p>const Error: Error; var EventStatus: TEventStatus) of object;</p>
<p>property OnBeginTransComplete: TBeginTransCompleteEvent; TConnectErrorEvent = procedure(Connection: TADOConnection; Error: Error; var EventStatus: TEventStatus) of object;</p>
<p>property OnCornmitTransComplete: TConnectErrorEvent;</p>
<p>вызываются после начала и фиксации транзакции. Свойство</p>
<p>type TIsolationLevel = (ilUnspecified, ilChaos, ilReadUncommitted, ilBrowse, ilCursorStability, ilReadCorranitted, ilRepeatableRead, ilSerializable, illsolated);</p>
<p>property IsolationLevel: TIsolationLevel;</p>
<p>позволяет задать уровень изоляции транзакции:</p>
<p>IlUnspecifed &#8212; уровень изоляции не задается;</p>
<p>Ilichaos &#8212; изменения более защищенных транзакций не перезаписываются данной транзакцией;</p>
<p>IlReadUncommitted &#8212; незафиксированные изменения других транзакций видимы;</p>
<p>IlBrowse &#8212; незафиксированные изменения других транзакций видимы;</p>
<p>IlCursorStability &#8212; изменения других транзакций видимы только после фиксации;</p>
<p>IlReadCommitted &#8212; изменения других транзакций видимы только после фиксации;</p>
<p>IlRepeatableRead &#8212; изменения других транзакций не видимы, но доступны при обновлении данных;</p>
<p>ISerializable &#8212; транзакция выполняется изолированно от других транзакций;</p>
<p>Ilisolated &#8212; транзакция выполняется изолированно от других транзакций.</p>
<p>Свойство</p>
<p>TXactAttribute = (xaCommitRetaining, xaAbortRetaining); property Attributes: TXactAttributes;</p>
<p>задает способ управления транзакциями при их фиксации и откате:</p>
<p> xaCommitRetaining &#8212; после фиксации очередной транзакции автоматически начинается выполнение новой;</p>
<p> xaAbortRetaining &#8212; после отката очередной транзакции автоматически начинается выполнение новой.</p>

