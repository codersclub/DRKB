<h1>Отладка приложений с технологией dbExpress</h1>
<div class="date">01.01.2007</div>


<p>Наряду с обычными методами отладки исходного кода, в dbExpress существует возможность контроля запросов, проходящих на сервер через соединение. Для этого используется компонент TSQLMonitor. </p>

<p>Через свойство </p>

<p>property SQLConnection: TSQLConnection; </p>

<p>компонент связывается с отлаживаемым соединением. Затем компонент включается установкой Active = True. </p>

<p>Теперь во время выполнения приложения сразу после открытия соединения свойство </p>

<p>property TraceList: TStrings; </p>

<p>будет заполняться информацией обо всех проходящих командах. Содержимое этого списка можно сохранить в файле при помощи метода </p>

<p>procedure SaveToFile(AFileName: string); </p>

<p>Эту же информацию можно автоматически добавлять в текстовый файл, определяемый свойством </p>

<p>property FileName: string; </p>

<p>но только тогда, когда свойство </p>

<p>property AutoSave: Boolean; </p>

<p>будет иметь значение True. Свойство </p>

<p>property MaxTraceCount: Integer; </p>

<p>определяет максимальное число контролируемых команд, а также управляет процессом контроля. При значении -1 ограничения снимаются, а при значении 0 контроль останавливается. Текущее число проверенных команд содержится в свойстве </p>

<p>property TraceCount: Integer; </p>

<p>Перед записью команды в список вызывается метод-обработчик </p>

<p>TTraceEvent = procedure(Sender: TObject; CBInfo: pSQLTRACEDesc; var LogTrace: Boolean) of object;&nbsp; </p>

<p>property OnTrace: TTraceEvent; </p>

<p>а сразу после записи в список вызывается </p>

<p>TTraceLogEvent = procedure (Sender: TObject; CBInfo: pSQLTRACEDesc) of object; </p>

<p>property OnLogTrace: TTraceLogEvent; </p>

<p>Таким образом, разработчик получает компактный и симпатичный компонент, позволяющий без усилий получать информацию о прохождении команд в соединении. </p>

<p>Если же компонент TSQLMonitor не подходит, можно воспользоваться методом </p>

<p>procedure SetTraceCallbackEvent(Event: TSQLCallbackEvent; IClientlnfo: Integer); </p>

<p>компонента TSQLConnection. Параметр процедурного типа Event определяет функцию, которая будет вызываться при выполнении каждой команды. Параметр iclientinfo должен содержать любое число. </p>

<p>Он позволяет разработчику самостоятельно определить функцию типа </p>

<p>TSQLCallbackEvent: </p>

<p>TRACECat = TypedEnum; </p>

<p>TSQLCallbackEvent = function(CallType: TRACECat; CBInfo: Pointer): CBRType; stdcall; </p>

<p>Эта функция будет вызываться каждый раз при прохождении команды. Текст команды будет передаваться в буфер CBInfo. Разработчику необходимо лишь выполнить запланированные действия с буфером внутри функции. </p>

<p>Рассмотрим в качестве примера следующий исходный код. </p>

<p>function GetTracelnfо(CallType: TRACECat; CBInfo: Pointer): CBRType;stdcall; </p>
<p>begin </p>
<p>  if Assigned(Forml.TraceList) then Forml.TraceList.Add(pChar(CBinfo)); </p>
<p>end; </p>

<p>procedure TForml.MyConnectionBeforeConnect(Sender: TObject); </p>
<p>begin </p>
<p>  TraceList := TStringList.Create;&nbsp; </p>
<p>end; </p>

<p>procedure TForml.MyConnectionAfterDisconnect(Sender: TObject); </p>
<p>begin </p>
<p>  if Assigned(TraceList) then </p>
<p>  begin </p>
<p> &nbsp;&nbsp; TraceList.SaveToFile('с:\Temp\TraceInfo.txt'); </p>
<p> &nbsp;&nbsp; TraceList.Free; </p>
<p>  end; </p>
<p>end; </p>

<p>procedure TForml.StartBtnClick(Sender: TObject); </p>
<p>begin </p>
<p>  MyConnection.SetTraceCallbackEvent(GetTracelnfo, 8); </p>
<p>  MyConnection.Open; </p>
<p>  {...} </p>
<p>  MyConnection.Close; </p>
<p>end; </p>

<p>Перед открытием соединения в методе-обработчике BeforeConnection создается объект типа TStringList. После закрытия соединения этот объект сохраняется в файле и уничтожается. </p>

<p>Перед открытием соединения (метод-обработчик нажатия кнопки Start) при помощи метода SetTraceCallbackEvent с соединением связывается функция GetTracelnfo. </p>

<p>Таким образом, по мере прохождения команд информация о них будет накапливаться в списке. После закрытия соединения список сохраняется в текстовом файле. </p>

<p class="note">Примечание&nbsp; </p>

<p>В своей работе компонент TSQLMonitor также использует вызовы метода SetTraceCallbackEvent. Поэтому одновременно применять компонент и собственные функции нельзя. </p>

