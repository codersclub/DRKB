<h1>Управление наборами данных</h1>
<div class="date">01.01.2007</div>


<p>Компонент TSQLConnection позволяет выполнять некоторые операции с подключенными наборами данных и следить за их состоянием.</p>

<p>Свойство</p>

<p>property DataSetCount: Integer;</p>

<p>возвращает число подключенных через данное соединение наборов данных.</p>

<p>Но это только активные наборы данных, переданные в связанные компоненты. Общее число выполняющихся в настоящий момент запросов возвращает свойство</p>

<p>property ActiveStatements: LongWord;</p>

<p>Если сервер БД установил для данного соединения максимальное число одновременно выполняющихся запросов, то оно доступно в свойстве</p>

<p>property MaxStmtsPerConn: LongWord;</p>

<p>Поэтому перед открытием набора данных можно выполнять следующий код, который повысит надежность приложения:</p>

<p>if MyQuery.SQLConnection.ActiveStatements &lt;= MyQuery.SQLConnection.MaxStmtsPerConn then</p>
<p>  MyQuery.Open</p>
<p>else</p>
<p>  MessageDlg ('Database connection is busy', mtWarning, [mbOK] , 0) ;</p>

<p>В случае возникновения непредвиденной ситуации все открытые через данное соединение наборы данных можно быстро закрыть методом</p>

<p>procedure CloseDataSets;</p>

<p>без разрыва соединения.</p>

<p>При необходимости компонент TSQLConnection может самостоятельно выполнять запросы SQL, не прибегая к помощи компонента TSQLQuery или TSQLDataSet. Для этого предназначена функция</p>

<p>function Execute(const SQL: string; Params: TParams; ResultSet:Pointer=nil): Integer;</p>

<p>Если запрос должен содержать параметры, то необходимо сначала создать объект &#8212; список параметров TParams и заполнить его. При этом, т. к. объект TParams еще не связан с конкретным запросом, важен порядок следования параметров, который должен совпадать в списке TParams и в тексте SQL.</p>

<p>Если запрос возвращает результат, метод автоматически создает объект типа TCustomSQLDataSet и возвращает указатель на него в параметр Resultset. Функция возвращает число обработанных запросом записей. Следующий фрагмент кода иллюстрирует применение функции Execute.</p>
<pre>
procedure TForml.SendBtnClick(Sender: TObject);  
  var FParams: TParams; 
      FDataSet: TSQLDataSet;  
begin 
  FParams := TParams.Create; 
  try 
    FParams.Items[0].Aslnteger := 1234; FParams.Items[1].AsInteger := 6751; 
    MyConnection.Execute('SELECT * FROM Orders WHERE OrderNo &gt;= :Ord AND 
                          EmpNo = :Emp', FParams, FDataSet); 
    if Assigned(FDataSet) then 
      with FDataSet do 
        begin 
          Open; 
          while Not EOF do 
            begin  
              {...}  
              Next ; 
            end; 
          Close; 
        end; 
  finally 
    FParams.Free;  
  end;  
end; 
</pre>

<p>Если запрос не имеет настраиваемых параметров и не возвращает набор данных, можно использовать функцию</p>

<p>function ExecuteDirect(const SQL: string): LongWord;</p>

<p>которая возвращает О в случае успешного выполнения запроса или код ошибки.</p>

<p>Метод</p>

<p>procedure GetTableNames(List: TStrings; SystemTables: Boolean = False);</p>

<p>возвращает список таблиц базы данных. Параметр SystemTables позволяет включать в формируемый список List системные таблицы.</p>

<p>Метод GetTableNames дополнительно управляется свойством</p>

<p>TTableScope = (tsSynonym, tsSysTable, tsTable, tsView);</p>
<p>TTableScopes = set of TTableScope;</p>
<p>property TableScope: TTableScopes;</p>

<p>которое позволяет задать тип таблиц, имена которых попадают в список. Для каждой таблицы можно получить список полей, использовав метод</p>

<p>procedure GetFieldNames(const TableName: String; List: TStrings);</p>

<p>и список индексов при помощи метода</p>

<p>procedure GetlndexNames(const TableName: string; List: TStrings);</p>

<p>В обоих методах список возвращаемых значений содержится в параметре List.</p>

<p>Аналогичным образом метод</p>

<p>procedure GetProcedureNames(List: TStrings);</p>

<p>возвращает список доступных хранимых процедур, а метод</p>

<p>procedure GetProcedureParams(ProcedureName: String; List: TList);</p>

<p>определяет параметры отдельной процедуры.</p>

