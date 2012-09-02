<h1>Команды ADO</h1>
<div class="date">01.01.2007</div>


<p>Команде ADO, которой мы уделяли так много внимания в этой главе в VCL Delphi, соответствует компонент TADOCormand. Методы этого компонента во многом совпадают с методами класса TCustomADODataSet, хотя этот класс не является предком компонента. Он предназначен для выполнения команд, которые не возвращают наборы данных. </p>

<p>Так как компоненту TADOCommand нет необходимости обеспечивать работу набора записей, его непосредственным предком является класс TComponent. К его функциональности просто добавлен механизм соединения с БД через ADO и средства представления команды. </p>

<p>Команда передается в хранилище данных ADO через собственное соединение или через компонент TAOocormection, аналогично другим компонентам ADO (см. выше). </p>

<p>Текстовое представление выполняемой команды должно содержаться в свойстве </p>

<p>property CommandText: WideString; </p>

<p>Однако команду можно задать и другим способом. Прямая ссылка на нужный объект команды ADO может быть задана свойством </p>

<p>property CommandObject: _Command; </p>

<p>Тип команды определяется свойством </p>

<p>type TCommandType = (cmdUnknown, cmdText, cmdTable, cmdStoredProc, cmdFile, cmdTableDirect); </p>

<p>property CommandType: TCommandType; </p>

<p>Так как тип TCommandType также используется в классе TCustomADODataSet, где необходимо представлять все возможные виды команд, по отношению к компоненту TADOcommand этот тип обладает избыточностью. Здесь нельзя установить значения cmdTable, cmdFile, cmdTableDirect, а тип cmdStoredProc должен обозначать только те хранимые процедуры, которые не возвращают набор данных. </p>

<p>Если команда должна содержать текст запроса SQL, свойство CommandType должно иметь значение cmdText. </p>

<p>Для вызова хранимой процедуры необходимо задать тип cmdStoredProc, a в свойстве CommandText ввести имя процедуры. </p>

<p>Если для выполнения команды необходимо задать параметры, используется свойство </p>

<p>property Parameters: TParameters; </p>

<p>Выполнение команды осуществляется методом Execute: </p>

<p>function Execute: _RecordSet; overload; </p>
<p>function Execute(const Parameters: OleVariant): _Recordset;overload; </p>
<p>function Execute(var RecordsAffected: Integer; var Parameters: OleVariant;&nbsp;&nbsp;&nbsp; ExecuteOptions: TExecuteOptions = []): _RecordSet; overload; </p>

<p>Разработчик может использовать любую из представленных нотаций перегружаемого метода: </p>

<p> параметр RecordsAffected возвращает число обработанных записей; </p>
<p> параметр Parameters задает параметры команды; </p>
<p> параметр ExecuteOptions определяет условия выполнения команды: </p>

<p>TExecuteOption = (eoAsyncExecute, eoAsyncFetch, eoAsyncFetchNonBlocking, eoExecuteNoRecords); </p>
<p>TExecuteOptions = set of TExecuteOption; </p>

<p>eoAsyncExecute &#8212; асинхронное выполнение команды;&nbsp; </p>

<p>eoAsyncFetch &#8212; асинхронная передача данных; </p>

<p>eoAsyncFetchNonBlocking &#8212; асинхронная передача данных без блокирования потока; </p>

<p>eoExecuteNoRecords &#8212; если команда возвращает набор записей, то они не передаются в компонент. </p>

<p>При работе с компонентом TADOConnection желательно использовать опцию eoExecuteNoRecords. </p>

<p>Для прерывания выполнения команды используется метод </p>

<p>procedure Cancel; </p>

<p>Текущее состояние команды можно определить свойством </p>

<p>type </p>

<p>TObjectState = (stClosed, stOpen, stConnecting, stExecuting, stFetching); </p>

<p>TObjectStates = set of TObjectState; property States: TObjectStates; </p>


