---
Title: TCustomADODataSet
Date: 01.01.2007
---


TCustomADODataSet
=================

Класс TCustomADODataSet инкапсулирует механизм доступа к хранилищу
данных через ADO. Этот класс наполняет абстрактные методы общего предка
TDataSet функциями конкретного механизма доступа к данным.

Поэтому здесь мы рассмотрим только уникальные свойства и методы класса
TCustomADODataSet, обеспечивающие работу с ADO.

Соединение набора данных с хранилищем данных ADO осуществляется через
компонент TADOConnection (свойство connection) или путем задания
параметров соединения через свойство connectionstring

**Набор данных**

Перед открытием набора данных необходимо установить тип используемой при
редактировании записей блокировки. Для этого применяется свойство

    type TADOLockType = (ItUnspecified, ItReadOnly, ItPessimistic,
      ItOptimistic, ItBatchOptimistic); property LockType: TADOLockType;

- ItUnspecified - блокировка задается источником данных, а не
компонентом; 
- ItReadOnly - набор данных откроется в режиме только для чтения;
- ItPessimistic - редактируемая запись блокируется на все время
редактирования до момента сохранения в хранилище данных;
- ItOptimistic - запись блокируется только на время сохранения изменений
в хранилище данных;
- ItBatchOptimistic - запись блокируется на время сохранения в хранилище
данных при вызове метода updateBatch.

**Примечание **

Для того чтобы установка блокировки сработала, свойство LockType должно
быть обязательно модифицировано до открытия набора данных.

Набор данных открывается методом Open и закрывается методом close. Также
можно использовать свойство

    property Active: Boolean;

Текущее состояние набора данных можно определить свойством

    type
    TObjectState = (stClosed, stOpen, stConnecting, stExecuting, stretching);
    TObjectStates = set of TObjectState;
    
    property RecordsetState: TObjectStates;

Набор данных в компонентах ADO основан на использовании объекта набора
записей ADO, прямой доступ к этому объекту возможен при помощи свойства

    property Recordset: _Recordset;

Но поскольку все основные методы интерфейсов объекта набора записей ADO
перекрыты методами класса, в обычных случаях прямой доступ к объекту вам
не понадобится. После обновления набора данных вызывается
метод-обработчик

    TRecordsetEvent = procedure(DataSet: TCustomADODataSet; const Error: Error;
    var EventStatus: TEventStatus) of object; property OnFetchComplete: TRecordsetEvent;

где Error - ссылка на объект ошибки ADO, если она возникла.

Если же набор данных работает в асинхронном режиме, при обновлении
вызывается метод-обработчик

    TFetchProgressEvent = procedure(DataSet: TCustomADODataSet; Progress,
      MaxProgress: Integer; var EventStatus: TEventStatus) of object; 
    property OnFetchProgress: TFetchProgressEvent;

где параметр Progress показывает долю выполнения операции.

**Курсор набора данных**

Для набора данных ADO в зависимости от его назначения можно выбрать тип
и местоположение используемого курсора. Местоположение курсора задается
свойством

    type TCursorLocation = (clUseServer, clUseClient);
    property CursorLocation: TCursorLocation;

Курсор может находиться на сервере (CIUseServer) или на клиенте
(CIUseClient).

Серверный курсор используется при работе с большими наборами данных,
которые нецелесообразно пересылать клиенту целиком. При этом несколько
снижается скорость работы клиентского набора данных.

Клиентский курсор обеспечивает передачу набора данных клиенту. Это
положительно сказывается на быстродействии, но такой курсор разумно
использовать только для небольших наборов данных, не загружающих канал
связи с сервером.

При использовании клиентского курсора необходимо дополнительно
установить свойство

    TMarshalOption = (moMarshalAll, moMarshalModifiedOnly);
    property MarshalOptions: TmarshalOption

которое управляет обменом данных клиента с сервером. Если соединение с
сервером быстрое, можно использовать значение moMarshalAll, разрешающее
возврат серверу всех записей набора данных. В противном случае для
ускорения работы компонента можно применить свойство
moMarshalModifiedOnly, обеспечивающее возврат только модифицированных
клиентом записей.

Тип курсора определяется свойством

    TCursorType = (ctUnspecified, CtOpenForwardOnly, ctKeyset, ctDynamic, ctStatic);
    property CursorType: TCursorType;

- ctunspecified - курсор не задан, тип курсора определяется
возможностями источника данных;
- ctOpenForwardOnly - однонаправленный курсор, допускающий перемещение
только вперед; используется при необходимости быстрого одиночного
прохода по всем записям набора данных;
- ctKeyset - двунаправленный локальный курсор, не обеспечивающий
просмотр добавленных и удаленных другими пользователями записей;
- ctDynamic - двунаправленный курсор, отображает все изменения, требует
наибольших затрат ресурсов;
- ctStatic - двунаправленный курсор, полностью игнорирует изменения,
внесенные другими пользователями.

**Примечание**

Если курсор расположен на клиенте (CursorType = ciusedient), то для него
доступен только один тип - ctStatic.

Соответственно до и после каждого перемещения курсора в наборе данных
вызываются методы - обработчики:

    TRecordsetReasonEvent = procedure(DataSet: TCustomADODataSet;
      const Reason: TEventReason; 
      var EventStatus: TEventStatus) of object;
    property OnWillMove: TRecordsetReasonEvent;

и

    TPRecordsetErrorEvent = procedure(DataSet: TCustomADODataSet;
      const Reason: TEventReason; const Error: Error; var EventStatus:
      TEventStatus) if object; 
    property OnMoveComplete: TRecordsetErrorEvent;

где параметр Reason позволяет узнать, какой метод вызвал это
перемещение.

**Локальный буфер**

После передачи клиенту записи набора данных размещаются в локальном
буфере, размер которого определяется свойством

    property CacheSize: Integer;

Значение свойства есть число записей, помещаемых в локальный буфер, и
оно не может быть меньше 1. Очевидно, что при достаточно большом размере
буфера компонент будет обращаться к источнику данных не так часто, но
при этом большой буфер заметно замедлит открытие набора данных. Кроме
этого, при выборе размера локального буфера необходимо учитывать
доступную компоненту память. Это можно сделать путем несложных
вычислений:

    CacheSizelnMem := ADODataSet.CacheSize * ADODataSet.RecordSize;

где RecordSize - свойство

    property RecordSize: Word;

возвращающее размер одной записи в байтах.

Как видите, компоненты ADO не избежали общей проблемы клиентских данных -
при плохом качестве соединения работа приложения замедляется. Однако
кое-что все-таки сделать можно. Если при навигации по записям вам не
требуется отображать данные в визуальных компонентах пользовательского
интерфейса, свойство property BlockReadSize: Integer;

позволяет организовать блочную пересылку данных. Оно задает число
записей, помещаемых в один блок. При этом набор данных переходит в
состояние dsBlockRead. По умолчанию блочная пересылка не используется и
значение свойства равно 0. Также можно ограничить максимальный размер
набора данных. Свойство

    property MaxRecords: Integer

задает максимальное число записей набора данных. По умолчанию свойство
имеет значение 0 и набор данных не ограничен.

Общее число записей набора данных на этот момент возвращает свойство
только для чтения

    property RecordCount: Integer;

При достижении последней записи набора данных вызывается
метод-обработчик

    TEndOfRecordsetEvent = procedure (DataSet: TCustomADODataSet;
      var MoreData: WordBool; var EventStatus: TEventStatus) of object;
    property OnEndOfRecordset: TEndOfRecordsetEvent;

При этом параметр MoreData показывает, действительно ли достигнут конец
набора данных. Если MoreData = True, то это означает, что в хранилище
данных еще имеются записи, не переданные клиенту.

**Состояние записи**

Класс TCustomADODataSet обладает дополнительными возможностями, которые
позволяют отслеживать состояние каждой записи.

Для текущей записи набора данных можно определить ее состояние. Для
этого предназначено свойство

    TRecordStatus = (rsOK, rsNew, rsModified, rsDeleted, rsUnmodified,
      rslnvalid, rsMultipleChanges, rsPendingChanges, rsCanceled,
      rsCantRelease, rsConcurrencyViolation, rsIntegrityViolation,
      rsMaxChangesExceeded, rsObjectOpen, rsOutOfMemory, rsPermissionDenied,
      rsSchemaViolation, rsDBDeleted);
    property RecordStatus: TRecordStatusSet;

где

- rsOK - запись успешно сохранена;
- rsNew - запись добавлена;
- rsModified - запись была изменена;
- rsDeleted - запись удалена;
- rsUnmodified - запись без изменений;
- rslnvalid - запись не может быть сохранена из-за неверной закладки;
- rsMultipleChanges - запись не может быть сохранена из-за множественных изменений;
- rsPendingChanges - запись не может быть сохранена из-за ссылки на несохраненные изменения;
- rsCanceled - операция с записью была отменена;
- rsCantRelease - запись заблокирована;
- rsConcurrencyViolation - запись не может быть сохранена из-за типа блокировки;
- rsintegrityvioiation - нарушена ссылочная целостность;
- rsMaxChangesExceeded - слишком много изменений;
- rsObjectOpen - конфликт с объектом базы данных;
- rsoutofMemory - недостаток памяти,
- rsPermissionDenied - нет доступа;
- rsSchemaViolation - нарушение структуры данных;
- rsDBDeleted - запись удалена в БД.

Как видите, благодаря этому свойству состояние отдельной записи может
быть определено очень точно.

Кроме этого, метод

    type
    TUpdateStatus = (usUnmodified, usModifled, uslnserted, usDeleted);
    function UpdateStatus: TUpdateStatus; override;

возвращает информацию о состоянии текущей записи.

Соответственно до и после изменения записи вызываются методы-обработчики

    TWillChangeRecordEvent = procedure(DataSet: TCustomADODataSet;
      const Reason: TEventReason;  const RecordCount: Integer; var EventStatus:
      TEventStatus) of object;
    property OnWillChangeRecord: TWillChangeRecordEvent;

И

    TRecordChangeCompleteEvent = procedure(DataSet: TCustomADODataSet;
      const Reason: TEventReason; const RecordCount: Integer; const Error: Error; 
    var EventStatus: TEventStatus) of object;
    property OnRecordChangeComplete: TrecordChangeCompleteEvent;

где параметр Reason позволяет узнать, какой метод изменил записи, а
параметр RecordCount возвращает число измененных записей.

**Фильтрация**

Помимо обычной фильтрации, основанной на свойствах Filter, Filtered и
методе-обработчике onFilterRecord, класс TCustomADODataSet предоставляет
разработчику дополнительные возможности.

Свойство

    TFilterGroup = (fgUnassigned, fgNone, fgPendingRecords,
      fgAffectedRecords, fgFetchedRecords, fgPredicate,
      fgConflictingRecords); 
    property FilterGroup: TFilterGroup;

задает групповой фильтр для записей, основываясь на информации о
состоянии каждой записи набора данных, подобно рассмотренному выше
свойству RecordStatus.

Фильтрация возможна по следующим параметрам:

- fgUnassigned - фильтр не задан;
- fgNone - все ограничения, заданные фильтром, снимаются, отображаются
все записи набора данных;
- fgPendingRecords - отображаются измененные записи, несохраненные в
хранилище данных при вызове метода updateBatch или cancelBatch;
- fgAffectedRecords - показываются записи, обработанные при последнем
сохранении в хранилище данных;
- fgFetchedRecords - имеем записи, полученные при последнем обновлении из источника данных;
- fgPredicate - видны только удаленные записи;
- fgConfiictingRecords - отображаются модифицированные записи, при
сохранении которых в хранилище данных возникла ошибка.

Для того чтобы групповая фильтрация заработала, необходимы два
дополнительных условия. Во-первых, фильтрация должна быть включена -
свойство Filtered должно иметь Значение True. 

Во-вторых, свойство LockType должно иметь значение ItBatchOptimistic.

    with ADODataSet do
    begin
       Close;
       LockType := ItbatchOptimistic;
       Filtered := True;
       FilterGroup := fgFetchedRecords;
       Open;
    end;

Метод

    procedure FilterOnBookmarks(Bookmarks: array of const);

включает фильтрацию по существующим закладкам. Для этого предварительно
необходимо при помощи метода GetBookmark установить закладки на
интересующих записях. При вызове метода FilterOnBookmarks автоматически
очищается свойство Filter, а свойству FilterGroup присваивается значение
gUnassigned.

**Поиск**

Быстрый и гибкий поиск по полям текущего индекса набора данных
обеспечивает метод

    SeekOption = (soFirstEQ, soLastEQ, soAfterEQ, soAfter, soBeforeEQ, soBefore);
    function Seek(const KeyValues: Variant; SeekOption: TSeekOption = soFirstEQ): Boolean;

В параметре KeyValues должны быть перечислены необходимые значения полей
индекса. Параметр SeekOption управляет процессом поиска:

- soFirstEQ - курсор устанавливается на первую найденную запись;
- soLastEQ - курсор устанавливается на последнюю найденную запись;
- soAfterEQ - курсор устанавливается на найденную запись или, если
запись не найдена, сразу после того места, где она могла находиться;
- soAfter - курсор устанавливается сразу после найденной записи;
- soBeforeEQ - курсор устанавливается на найденную запись или, если
запись не найдена, перед тем местом, где она могла находиться;
- soBefore - курсор устанавливается перед найденной записью.

Свойство

    property Sort: WideString;

предоставляет простой способ сортировки по произвольному сочетанию
полей. Оно должно включать через запятую имена нужных полей и признак
прямого или обратного порядка сортировки:

    ADODataSet.Sort := 'FirstField DESC';

Если порядок сортировки не указан, по умолчанию задается прямой порядок.

**Команда ADO**

Для выполнения запросов к источнику данных любой компонент ADO
инкапсулирует специальный объект команды ADO.

При использовании компонентов-потомков класса TCustomADODataSet обычно
нет необходимости применять объект команды напрямую. И хотя все реальное
взаимодействие объекта набора данных ADO с источником данных
осуществляется через объект команды, настройка и выполнение команды
скрыты в свойствах и методах компонентов ADO. Тем не менее в классе
TCustomADODataSet доступ к объекту команды можно получить при помощи
свойства 

    property Command: TADOCommand;

При необходимости выполнить команду ADO, не связанную с конкретным
набором данных, разработчик может использовать отдельный компонент
TADOCommand, также расположенный на странице ADO Палитры компонентов.

Тип команды задается свойством

    type
    TCommandType = (cmdUnknown, cmdText, cmdTable, cmdStoredProc, cmdFile, cmdTableDirect);
    property CommandType: TCommandType;

- cmdunknown - тип команды неизвестен и будет определен источником данных;
- cmdText - текстовая команда, интерпретируемая источником данных
(например запрос SQL); текст должен быть составлен с учетом правил для
конкретного источника данных;
- cmdTable - команда на получение набора данных таблицы из хранилища данных;
- cmdstoredProc - команда на выполнение хранимой процедуры;
- cmdFile - команда на получение набора данных, сохраненного в файле в
формате, используемым конкретным источником данных;
- cmdTableoirect - команда на получение набора данных таблицы напрямую,
например из файла таблицы.

Текст команды, представленный свойством

    property CommandText: WideString;

обязательно должен быть согласован с ее типом.

Для ограничения времени ожидания выполнения команды используется
свойство

    property CommandTimeout: Integer;

В компонентах наборов данных ADO команды выполняется при выполнении
следующих операций:

- открытие и закрытие набора данных;
- выполнение запросов и хранимых процедур;
- обновление набора данных;
- сохранение изменений;
- групповые операции.

Разработчик может повлиять на способ выполнения команды. Для этого он
может изменить свойство

    type
    TExecuteOption = (eoAsyncExecute, eoAsyncFetch, eoAsyncFetchNonBlocking, eoExecuteNoRecords);
    TExecuteOptions = set of TExecuteOption;
    property ExecuteOptions: TExecuteOptions;

- eoAsyncExecute - асинхронное выполнение команды;
- eoAsyncFetch - асинхронное выполнение команды на обновление набора данных;
- eoAsyncFetchNonBlocking - асинхронное выполнение команды на обновление
набора данных без установки блокировки;
- eoExecuteNoRecords - выполнение команды не требует возвращения набора
данных.

**Групповые операции**

Как уже рассказывалось выше, наборы данных ADO используют на клиентской
стороне локальный кэш для хранения данных и сделанных изменений.
Благодаря наличию этого кэша и появилась возможность реализовать
групповые операции. В этом режиме все сделанные изменения не передаются
немедленно источнику данных, а накапливаются в локальном кэше. Это
повышает скорость работы и позволяет сохранять сразу группу
модифицированных записей.

Из отрицательных сторон этого метода стоит отметить, что пока изменения
находятся на клиенте, они недоступны другим пользователям. В данной
ситуации могут возникать потери данных.

Для перевода набора данных в режим групповых операций необходимо
выполнить следующие условия.

Набор данных должен использовать клиентский курсор:

    ADODataSet.CursorLocation := clUseClient;

Курсор должен иметь тип ctstatic:

    ADODataSet.CursorType := ctstatic;

Блокировка должна иметь значение itBatchoptimistic:

    ADODataSet.LockType := ItBatchOptimistic;

Для передачи сделанных изменений в хранилище данных в компонентах ADO
используется метод

    procedure UpdateBatch(AffectRecords: TAffectRecords = arAll);

Для отмены всех сделанных, но не сохраненных методом UpdateBatch
изменений применяется метод

    procedure CancelBatch(AffectRecords: TAffectRecords = arAll);

Используемый в методах тип TAffectRecords позволяет задать тип записей,
к которым применяется данная операция:

    TAffectRecords = (arCurrent, arFiltered, arAll, arAHChapters);

- arCurrent - операция выполняется только для текущей записи;
- arFiltered - операция выполняется для записей из работающего фильтра;
- arAll - операция выполняется для всех записей;
- arAllchapters - операция выполняется для всех записей текущего набора
данных (включая невидимые из-за включенного фильтра), а также для всех
вложенных наборов данных.
