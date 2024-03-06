---
Title: Управление наборами данных
Date: 01.01.2007
---


Управление наборами данных
==========================

Компонент TSQLConnection позволяет выполнять некоторые операции с
подключенными наборами данных и следить за их состоянием.

Свойство

    property DataSetCount: Integer;

возвращает число подключенных через данное соединение наборов данных.

Но это только активные наборы данных, переданные в связанные компоненты.
Общее число выполняющихся в настоящий момент запросов возвращает
свойство

    property ActiveStatements: LongWord;

Если сервер БД установил для данного соединения максимальное число
одновременно выполняющихся запросов, то оно доступно в свойстве

    property MaxStmtsPerConn: LongWord;

Поэтому перед открытием набора данных можно выполнять следующий код,
который повысит надежность приложения:

    if MyQuery.SQLConnection.ActiveStatements <= MyQuery.SQLConnection.MaxStmtsPerConn then
      MyQuery.Open
    else
      MessageDlg ('Database connection is busy', mtWarning, [mbOK], 0) ;

В случае возникновения непредвиденной ситуации все открытые через данное
соединение наборы данных можно быстро закрыть методом

    procedure CloseDataSets;

без разрыва соединения.

При необходимости компонент TSQLConnection может самостоятельно
выполнять запросы SQL, не прибегая к помощи компонента TSQLQuery или
TSQLDataSet. Для этого предназначена функция

    function Execute(const SQL: string; Params: TParams; ResultSet:Pointer=nil): Integer;

Если запрос должен содержать параметры, то необходимо сначала создать
объект - список параметров TParams и заполнить его. При этом, т. к.
объект TParams еще не связан с конкретным запросом, важен порядок
следования параметров, который должен совпадать в списке TParams и в
тексте SQL.

Если запрос возвращает результат, метод автоматически создает объект
типа TCustomSQLDataSet и возвращает указатель на него в параметр
Resultset. Функция возвращает число обработанных запросом записей.
Следующий фрагмент кода иллюстрирует применение функции Execute.

    procedure TForml.SendBtnClick(Sender: TObject);  
      var FParams: TParams; 
          FDataSet: TSQLDataSet;  
    begin 
      FParams := TParams.Create; 
      try 
        FParams.Items[0].Aslnteger := 1234; FParams.Items[1].AsInteger := 6751; 
        MyConnection.Execute('SELECT * FROM Orders WHERE OrderNo >= :Ord AND 
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

Если запрос не имеет настраиваемых параметров и не возвращает набор
данных, можно использовать функцию

    function ExecuteDirect(const SQL: string): LongWord;

которая возвращает О в случае успешного выполнения запроса или код
ошибки.

Метод

    procedure GetTableNames(List: TStrings; SystemTables: Boolean = False);

возвращает список таблиц базы данных. Параметр SystemTables позволяет
включать в формируемый список List системные таблицы.

Метод GetTableNames дополнительно управляется свойством

    TTableScope = (tsSynonym, tsSysTable, tsTable, tsView);
    TTableScopes = set of TTableScope; 
    property TableScope: TTableScopes;

которое позволяет задать тип таблиц, имена которых попадают в список.
Для каждой таблицы можно получить список полей, использовав метод

    procedure GetFieldNames(const TableName: String; List: TStrings);

и список индексов при помощи метода

    procedure GetlndexNames(const TableName: string; List: TStrings);

В обоих методах список возвращаемых значений содержится в параметре
List.

Аналогичным образом метод

    procedure GetProcedureNames(List: TStrings); 

возвращает список доступных хранимых процедур, а метод

    procedure GetProcedureParams(ProcedureName: String; List: TList);

определяет параметры отдельной процедуры.
