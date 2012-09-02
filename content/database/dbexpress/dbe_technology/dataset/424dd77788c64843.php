<h1>TSQLStoredProc</h1>
<div class="date">01.01.2007</div>


<p>Компонент TSQLStoredProc инкапсулирует функциональность хранимых процедур для их выполнения в рамках технологии dbExpress. Он подобен другим своим аналогам. Подробнее о функциях компонентов хранимых процедур см. часть III. Имя хранимой процедуры определяется свойством </p>
<p>property StoredProcName: string; </p>
<p>Для работы с входными и выходными параметрами предназначено свойство </p>
<p>property Params: TParams; </p>
<p>Внимание </p>
<p>При работе с параметрами желательно использовать обращение к конкретному параметру по имени при помощи метода ParamByName. При работе с некоторыми серверами порядок следования параметров до выполнения процедуры и после может изменяться. </p>
<p>Процедура выполняется методом </p>
<p>function ExecProc: Integer; virtual; </p>
<p>если она не возвращает набор данных. Иначе используются свойство Active или метод open. </p>
<p>Если хранимая процедура возвращает несколько связанных наборов данных (подобно иерархическим запросам ADO), доступ к следующему набору данных осуществляет метод </p>
<p>function NextRecordSet: TCustomSQLDataSet; </p>
<p>автоматически создавая объект типа TCustomSQLDataSet для инкапсуляции новых данных. Возврат к предыдущему набору данных возможен, если вы определили объектные переменные для каждого набора данных: </p>
<pre>
var SecondSet: TCustomSQLDataSet; 
 
MyProc.Open; 
while Not MyProc.Eof do 
  begin 
    {...} 
    Next; 
  end; 
SecondSet := MyProc.NextRecordSet;  
SecondSet.Open; {...} 
SecondSet.Close;  
MyProc.Close; 
</pre>

