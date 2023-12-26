---
Title: Команды ADO
Date: 01.01.2007
---


Команды ADO
===========

::: {.date}
01.01.2007
:::

Команде ADO, которой мы уделяли так много внимания в этой главе в VCL
Delphi, соответствует компонент TADOCormand. Методы этого компонента во
многом совпадают с методами класса TCustomADODataSet, хотя этот класс не
является предком компонента. Он предназначен для выполнения команд,
которые не возвращают наборы данных.

Так как компоненту TADOCommand нет необходимости обеспечивать работу
набора записей, его непосредственным предком является класс TComponent.
К его функциональности просто добавлен механизм соединения с БД через
ADO и средства представления команды.

Команда передается в хранилище данных ADO через собственное соединение
или через компонент TAOocormection, аналогично другим компонентам ADO
(см. выше).

Текстовое представление выполняемой команды должно содержаться в
свойстве

property CommandText: WideString;

Однако команду можно задать и другим способом. Прямая ссылка на нужный
объект команды ADO может быть задана свойством

property CommandObject: \_Command;

Тип команды определяется свойством

type TCommandType = (cmdUnknown, cmdText, cmdTable, cmdStoredProc,
cmdFile, cmdTableDirect);

property CommandType: TCommandType;

Так как тип TCommandType также используется в классе TCustomADODataSet,
где необходимо представлять все возможные виды команд, по отношению к
компоненту TADOcommand этот тип обладает избыточностью. Здесь нельзя
установить значения cmdTable, cmdFile, cmdTableDirect, а тип
cmdStoredProc должен обозначать только те хранимые процедуры, которые не
возвращают набор данных.

Если команда должна содержать текст запроса SQL, свойство CommandType
должно иметь значение cmdText.

Для вызова хранимой процедуры необходимо задать тип cmdStoredProc, a в
свойстве CommandText ввести имя процедуры.

Если для выполнения команды необходимо задать параметры, используется
свойство

property Parameters: TParameters;

Выполнение команды осуществляется методом Execute:

function Execute: \_RecordSet; overload;

function Execute(const Parameters: OleVariant): \_Recordset;overload;

function Execute(var RecordsAffected: Integer; var Parameters:
OleVariant;    ExecuteOptions: TExecuteOptions = \[\]): \_RecordSet;
overload;

Разработчик может использовать любую из представленных нотаций
перегружаемого метода:

параметр RecordsAffected возвращает число обработанных записей;

параметр Parameters задает параметры команды;

параметр ExecuteOptions определяет условия выполнения команды:

TExecuteOption = (eoAsyncExecute, eoAsyncFetch, eoAsyncFetchNonBlocking,
eoExecuteNoRecords);

TExecuteOptions = set of TExecuteOption;

eoAsyncExecute --- асинхронное выполнение команды; 

eoAsyncFetch --- асинхронная передача данных;

eoAsyncFetchNonBlocking --- асинхронная передача данных без блокирования
потока;

eoExecuteNoRecords --- если команда возвращает набор записей, то они не
передаются в компонент.

При работе с компонентом TADOConnection желательно использовать опцию
eoExecuteNoRecords.

Для прерывания выполнения команды используется метод

procedure Cancel;

Текущее состояние команды можно определить свойством

type

TObjectState = (stClosed, stOpen, stConnecting, stExecuting,
stFetching);

TObjectStates = set of TObjectState; property States: TObjectStates;
