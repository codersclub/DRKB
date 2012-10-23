<h1>Запросы и параметры, или как избавится от многих проблем</h1>
<div class="date">01.01.2007</div>


<p>Где я? О чём вы?</p>
<p>Компонент TQuery имеет свойство Params:TParams, а компонент TADOQuery имеет свойство Parameters:TParameters. Эти объекты позволяют в уже готовом запросе подставить какие-либо значения. Делается это таким незамысловатым способом:</p>
<pre>

 
ADOQuery1.Active:=False;
ADOQuery1.SQL.text:='Select * From MyTable Where MyField=:prm';
ADOQuery1.Parameters.ParseSQL(ADOQuery1.SQL.text, true);
ADOQuery1.Parameters.ParamByName('prm').Value:='чего-то там';
ADOQuery1.Active:=True;
</pre>

<p>Для BDE код будет собственно таким:</p>
<pre>

 
Query1.Active:=False;
Query1.SQL.text:='Select * From MyTable Where MyField=:prm';
Query1.Params.ParseSQL(Query1.SQL.text, true);
Query1.Params.ParamByName('prm').Value:= 'чего-то там';
Query1.Active:=True;
</pre>

<p>А зачем это нужно?</p>
<p>1) Если запрос один и тот же но в зависимости от условий надо его задать с другими значениями. Параметры здесь работают немного быстрее и с ними удобнее работать чем с динамическим посторением SQL каждый раз:</p>
<p>...подготавливаем запрос один раз...</p>
<pre>

 
ADOQuery1.Active:=False;
ADOQuery1.SQL.text:='Select * From MyTable Where MyField=:prm';
ADOQuery1.Parameters.ParseSQL(ADOQuery1.SQL.text, true);
</pre>

<p>... всё запрос готов ...</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);

begin
  ADOQuery1.Active:=False;
  ADOQuery1.Parameters.ParamByName('prm').Value:=Edit1.text;
  ADOQuery1.Active:=True;
end;
</pre>

<p>2)При передаче даты и времени. Тут прикол вот в чём. Допустим стоит у вас SQL Server в США и использует формат времени и даты как "01/20/04 1PM", а клиент у вас работает один в Канаде где формат даты "20/01/04 01:00 PM", а другой в России где формат даты "20/01/04 13:00". При отсылке запроса с датой в виде строки надо обязательно согласовывать форматы даты времени клиента и сервера, а при передаче параметров не надо! Дело в том что преобразование параметра происходит на сервере, и сервер его сам преобразует в тот формат который ему нужен!</p>
<pre>

 
ADOQuery1.Active:=False;
ADOQuery1.SQL.text:='Select * From MyTable Where LastDate&gt;:prm';
ADOQuery1.Parameters.ParseSQL(ADOQuery1.SQL.text, true);
ADOQuery1.Parameters.ParamByName('prm').Value:=now;
ADOQuery1.Active:=True;
</pre>

<p>3) При необходимости использовать в запросе двоичные данные или Memo поля использование параметров - это единственный путь</p>
<pre>

 
ADOQuery1.Active:=False;
ADOQuery1.SQL.text:='Insert Into MyTable (id, MyPicture)';
ADOQuery1.SQL.Add('Values (:Id, :pic)');
ADOQuery1.Parameters.ParseSQL(ADOQuery1.SQL.text, true);
ADOQuery1.Parameters.ParamByName('id').Value:=now;
ADOQuery1.Parameters.ParamByName('pic').LoadFromFile('c:\mypic.bmp', ftGraphic);
ADOQuery1.ExecSQL;
</pre>

<div class="author">Автор: Vit</div>
<hr /><p class="note">Примечание от Anatoly Podgoretsky</p>
<p>Для ран тайм можно указать про добавление параметров, определение их типов, поскольку у людей часто возникают проблемы с типами параметров, с присвоением значений через AsФункции и через Value.</p>
<pre>
with ADOQuery1.Parameters.AddParameter do begin
  Name := 'prm';
  DataType := ftDateTime;
  Direction := pdInput;
  Value := Now;
end;
</pre>

<p>Есть и другие полезные свойства, например Attributes</p>
<p>строка ADOQuery1.Parameters.ParamByName('prm').Value:=now;</p>
<p>не нужна, но может использоваться.</p>
<p>Что здесь сделано?</p>
<p>1. Создан явный параметр</p>
<p>2. ему дано имя</p>
<p>3. явно указан тип</p>
<p>4. явно указано направление, что этот параметр входной</p>
<p>5. и присвоено ему значение, эквивалент ParamByName</p>
<p>что это дает:</p>
<p>Это снимает все разночтения, которые могут возникнуть при автоматическом разборе выражения с типом и присвоением ему значения.</p>
<hr /><p class="note">Примечание от Петровича</p>
<p>Внесу и свою лепту</p>
<p>К параметрам запроса можно обращаться и по индексу. Например так:</p>
<pre>
with  ADOQuery1  do begin
  SQL.text:='UPDATE Customers SET Addr1=:p WHERE CustNo=:c';
  Parameters[0].Value := 'г.Арбатов';
  Parameters[1].Value := 753;
  ExecSQL;
end;
</pre>

<p>Это полностью эквивалентно:</p>
<pre>
with  ADOQuery1  do begin
  SQL.text:='UPDATE Customers SET Addr1=:p WHERE CustNo=:c';
  Parameters.ParamByName('p').Value := 'г.Арбатов';
  Parameters.ParamByName('c').Value := 753;
  ExecSQL;
end;
</pre>

<p>Кстати, обращаться по именам можно и чуть короче:</p>
<pre>
with  ADOQuery1  do begin
  SQL.text:='UPDATE Customers SET Addr1=:p WHERE CustNo=:c';
  Parameters.ParamValues['p'] := 'г.Арбатов';
  Parameters.ParamValues['c'] := 753;
  ExecSQL;
end;
</pre>

<p>Но, вернусь к обращению по индексу.</p>
<p>Так вот, по индексу, к Parameters лучше никогда не обращаться. Или, делать это с особой осторожностью.</p>
<p>Например, если усложнить предыдущий запрос:</p>
<pre>
with  ADOQuery1  do begin
  SQL.text:='UPDATE Customers SET Addr1=:p , Addr2=:p WHERE CustNo=:c';
  Parameters[0].Value := 'г.Арбатов';
  Parameters[1].Value := 753;
  ExecSQL;
end;
</pre>

<p>то результат выполнения будет отличаться от варианта:</p>
<pre>
with  ADOQuery1  do begin
  SQL.text:='UPDATE Customers SET Addr1=:p , Addr2=:p  WHERE CustNo=:c';
  Parameters.ParamValues['p'] := 'г.Арбатов';
  Parameters.ParamValues['c'] := 753;
  ExecSQL;
end;
</pre>

<p>Все дело в том, что разбор SQL-оператора на уровне компонет Delphi весьма прост, и на мой взгляд делается не совсем корректно.</p>
<p>А именно, не смотря на то, что во втором варианте SQL-оператора упоминаются лишь два параметра: p и c (параметр p упоминается дважды), Delphi создаст ТРИ параметра в массиве Params. Поэтому, оператор Parameters[1].Value := 753; выполнит присваивание значения не параметру с именем c, а второму экземпляру параметра p. А значение параметра c останется равным NULL. Соответственно, при выполнении ExecSQL ошибки возникнуть не должно, но результат будет неправильным. А вот при обращении по имени, все будет хорошо! Наверное, при передаче параметров запроса на SQL-сервер (или соответствующий движок БД), сами компоненты "вытаскивают" значения параметров тоже по имени. Поэтому, не смотря на то что после:</p>
<p>  Parameters.ParamValues['p'] := 'г.Арбатов';</p>
<p>  Parameters.ParamValues['c'] := 753;</p>
<p>заполненными будут лишь параметры с индексами 0 и 2, на правильной работе это не скажется, поскольку до параметра с индексом 1 по имени вообще нельзя "достучаться".</p>
<p>Казалось-бы, зачем так много говорить об этой проблеме? Можно ведь вообще не использовать доступ по индексу, как я и советовал ранее. Но, лично я все-таки использую его. Вот например небольшой объектик которым я люблю пользоваться. Может кому и пригодится. Приведу пример для ADO, но подобное существует и для других методов доступа к БД.</p>
<pre>
type
  tDbAdo = class
    private
      fConnection :TADOConnection;
    public
      constructor Create (aADOConnection :TADOConnection);
 
      function CreateQuery  (SQLText :String; fParams :array of const; qParams :array of Variant) :TADOQuery;
        // Возвращает закрытый TADOQuery с заполнеными SQL.Text и Parameters.
        // Ответственность за уничтожение возвращенного TADOQuery лежит на вызывающем!
 
      function ExecSql      (SQLText :String; fParams :array of const; qParams :array of Variant) :Integer;
        // Выполняет SQL-оператор, и возвращает RowAffected
 
      function GetField     (SQLText :String; fParams :array of const; qParams :array of Variant) :Variant;
        // Возвращает значение первого поля первой записи результата SQL-запроса
 
      function CreateSelect (SQLText :String; fParams :array of const; qParams :array of Variant) :TADOQuery;
        // Возвращает открытый TADOQuery с результатом SQL-запроса.
        // Ответственность за уничтожение возвращенного TADOQuery лежит на вызывающем!
 
      function GetRecCount  (const TableName :string)                            :Integer;    overload;
        // Возвращает число записей в таблице TableName
 
      function GetRecCount  (const TableName, FieldName :string; Value :Variant) :Integer;    overload;
        // Возвращает число записей в таблице TableName у которых значение поля FieldName равно Value
 
      property Connection :TADOConnection  read fConnection;
        // TADOConnection с которым соеденен данный tDbAdo
    end;
 
 
function SQLInfo (SQLText :string; fParams :array of const; qParams :array of Variant) :String;
 
  function VarToSqlConstStr (v :Variant) :String;
  begin
    case  VarType(v)  of
      varEmpty, varNull
        : Result := 'NULL';
      varSmallint, varInteger, varSingle, varDouble, varCurrency, varShortInt,
      varByte, varWord, varLongWord, varInt64
        : Result := v;
      varDate, varOLEStr, varStrArg, varString
        : begin Result := Trim(v); if Result='' then Result:='NULL' else Result:=QuotedStr(Result); end;
      varBoolean
        : Result := 'NY'[Ord(Boolean(v))];
      else
        raise EConvertError.Create('VarToSqlConstStr: значение неизвестного типа '+IntToStr(Ord(VarType(v))));
    end;
  end;
 
var i :Integer;
begin
  try
    Result := Format(SQLText,fParams)+'|';
    for i := 0 to High(qParams) do  Result := Result + VarToSqlConstStr(qParams[i]) +',';
    SetLength(Result,Length(Result)-1);
  except
    Result := ExMsg(SQLText);
  end;
end;
 
 
constructor tDbAdo.Create (aADOConnection :TADOConnection);
begin
  inherited Create();
  fConnection := aADOConnection;
end;
 
function tDbAdo.CreateQuery (SQLText :String; fParams :array of const; qParams :array of Variant) :TADOQuery;
var i : Integer;
begin
   Result := TADOQuery.Create(Self.Connection);
   with  Result  do try
     Connection := Self.Connection;
     SQL.Text := Format(SQLText,fParams);
     if High(qParams)+1 &lt; Parameters.Count  then
        raise Exception.CreateFmt('CreateADOQuery: Передано параметров (%d) меньше чем требует SQL-запрос (%d)',[High(qParams)+1,Parameters.Count]);
     for i := 0 to Parameters.Count-1 do
       Parameters[i].Value := qParams[i]; // &lt;- вот доступ к параметрам по индексу
   except
     Result.Free;
     raise;
   end;
end;
 
function tDbAdo.ExecSql (SQLText :String; fParams :array of const; qParams :array of Variant) : Integer;
begin
  try
    with  CreateQuery(SQLText,fParams,qParams)  do try
      Result := ExecSQL;
    finally
      Free
    end;
  except
    ExMsg('ExecSql: Ошибка выполнения SQL-оператора:'^M^J^I+SQLInfo(SQLText,fParams,qParams));
    raise;
  end;
end;
 
function tDbAdo.CreateSelect (SQLText :String; fParams :array of const; qParams :array of Variant) :TADOQuery;
begin
  Result := CreateQuery(SQLText,fParams,qParams);
  try
    Result.Open;
  except
    Result.Free;
    ExMsg('CreateSelect: Ошибка выполнения SQL-оператора:'^M^J^I+SQLInfo(SQLText,fParams,qParams));
    raise;
  end;
end;
 
function tDbAdo.GetField (SQLText :String; fParams :array of const; qParams :array of Variant) :Variant;
begin
  with  CreateSelect(SQLText,fParams,qParams)  do try
    Result := Fields[0].Value;
  finally
    Free;
  end;
end;
 
function tDbAdo.GetRecCount (const TableName :string)                            :Integer;
begin
  Result := GetField('SELECT Count(1) FROM %s',[TableName],[]);
end;
 
function tDbAdo.GetRecCount (const TableName, FieldName :string; Value :Variant) :Integer;
begin
  Result := GetField('SELECT Count(1) FROM %s WHERE %s=:v',[TableName,FieldName],[Value]);
end;
</pre>

<p>Тут правда я использую некоторые функции из моей библиотеки. Нужный модуль ( awString.pas ) я уже выкладывал то-ли здесь, то-ли на Vingrade. Ну а кому лень искать, все нужные функции я добавлю в конец поста.</p>
<p>Теперь, как енто пользовать.</p>
<p>Например, кладем на форму (я обычно делаю жто в Data-модуле) ADOConnection1: TADOConnection.</p>
<p>Описываем соединение с поставляемой Borland демо-базой данных:</p>
<p>ADOConnection1.ConnectionString := 'FILE NAME=C:\Program Files\Common Files\System\OLE DB\Data Links\DBDEMOS.udl'</p>
<p>Затем, в OnCreate формы пишем:</p>
<p>  ADOConnection1.Open;</p>
<p>  MyDB := tDbAdo.Create(ADOConnection1);</p>
<p>Переменную MyDB описываем например как глобал:</p>
<p>var</p>
<p>  MyDB :tDbAdo;</p>
<p>Ну а далее все просто. Например:</p>
<pre>
 
procedure TForm3.Button1Click(Sender: TObject);
begin
  ShowMessage( 'Всего стран: '+IntToStr(
               MyDB.GetRecCount('country')
             ));
  ShowMessage( 'Всего стран в северной америке: '+IntToStr(
               MyDB.GetRecCount('Country','Continent','North America')
             ));
  ShowMessage( 'Всего стран в южной америке: '+IntToStr(
               MyDB.GetRecCount('Country','Continent','South America')
             ));
 
  ShowMessage( 'Площадь Канады: '+IntToStr(
               MyDB.GetField('SELECT Area FROM Country WHERE Name = :p0',[],['Canada'])
             ));
 
  with  TStringList.Create  do try
 
    // получение списка стран южной америки с численностью населения менее 10 000 000
    with  MyDB.CreateSelect('SELECT Name, Population FROM Country'
                           +' WHERE (Continent = :Continent)'
                           +  ' AND (Population &lt; :Population)'
                           ,[],['South America',10000000])  do try
      while  not Eof  do begin
        Add(Fields[0].AsString+' '+Fields[1].AsString);
        Next;
      end;
    finally
      Free;
    end;
 
    ShowMessage( 'Список стран южной америки с численностью населения менее 10 000 000:'^M^J
                +Text
               );
  finally
    Free;
  end;
end;
</pre>
<p>Вот и все.</p>
<p>Ах, да. Как обещал, необходимые функции:</p>
<pre>
var GetLocationInfoStrFunc :function (Addr :Pointer) :String =Nil;
// Процедура испльзуемая для получения информации об адресе Addr (имя модуля,
// процедуры, и пр.).
// Если определена, то используется функцией GetExText.
 
function LocationInfoStr (Addr :Pointer) :String;
begin
  if  Assigned(GetLocationInfoStrFunc)  then
    Result := GetLocationInfoStrFunc(Addr)
  else
    Result := '['+SysUtils.IntToHex(Cardinal(Addr),8)+']';
end;
 
function LastExcept :Exception;
// Возвращает объект последнего исключения или Nil (если вызвана вне except .. end)
var
  c :TClass;
  o :tObject;
  s1,s2 :String;
begin
  o := ExceptObject;
  if  o = nil  then
    Result := Nil
  else if  o is Exception  then
    Result := Exception(o)
  else begin
    // Исключение возникло за пределами нашего EXE-файла, например в Dll
    // или ExceptObject вообще не имеет в предках класса Exception!
    // Возвращать его нельзя, поскольку полноценная работа с ним невозможна.
    // В частности, если это Exception из Dll, то его поле Message, имеющее
    // тип LongString нельзя будет переприсваивать - память под текущую
    // строку выделена не нашим распределителем памяти.
    // Можно было-бы заменить его собственным экземпляром, освободив текущий
    // экземпляр, но нам недоступна переменная System.RaiseListPtr. И кроме
    // того возможны ситуации когда обработка текущего исключения возобновится
    // в Dll, тогда опять возникнет проблемма.
    // Не нахожу ничего лучшего, как возбудить исключение с соответствующим
    // текстом ошибки.
    // Если в предках ExceptObject есть Exception, то включить его Message
    // в текст возбуждаемонго исключения.
    c := o.ClassType;
    while (c &lt;&gt; nil) and (not c.ClassNameIs('Exception')) do
      c := c.ClassParent;
 
    if  c = nil  then begin  // в иерархии o нет 'Exception' - в принципе это нонсенс
      s1 := 'В предках ExceptObject отсутствует Exception.';
      s2 := '';
      end
    else begin  // Есть. Перенесем его Message
      s1 := 'ExceptObject не принадлежащий модулю.';
      s2 := ^M^J^I'  Message = "'+Exception(o).Message+'"';
    end;
    raise EInvalidCast.CreateFmt('Ошибка LastExcept: %s'^M^J^I'  ExceptObject = %s at %s%s'
                                   ,[s1,o.ClassName,LocationInfoStr(ExceptAddr),s2]);
  end;
end;
 
function GetExMsg (e :Exception) :String;
begin
  if e = Nil  then
    Result := ''
  else with e do begin
    Result := Message;
    //
    //if  ClassName = 'EInOutError'  then
    //  Result := 'Ошибка в/в ('+IntToStr(EInOutError(e).ErrorCode)+')'
    //            +^M^J^I+Result;
  end;
end;
 
function GetExText (e :Exception; ExAddr :Pointer =Nil) :String;
var s :String;
begin
  if e = Nil  then
    Result := ''
  else with e do begin
    Result := GetExMsg(e);
 
    s := ClassName;
    if  s = 'Exception'  then  Exit;
 
    if  ExAddr&lt;&gt;nil  then
      s := s + ' at '+LocationInfoStr(ExAddr);
 
    if  e.ClassNameIs('EInOutError')  then
      s := s + ' (Ошибка в/в '+IntToStr(EInOutError(e).ErrorCode)+')';
 
    if  Result&lt;&gt;''  then
      s := s + ^M^J^I + Result;
 
    Result := s;
  end;
end;
 
 
function ExMsg  (e :Exception; const Msg :String ='')         :String; overload;
begin
  if e = Nil  then
    Result := 'No exception'
  else begin
    Result := GetExMsg(e);
    if  Msg &lt;&gt; ''  then
      Result := Msg + ^M^J^I + Result;
    e.Message := Result;
  end;
end;
 
function ExMsg  (              const Msg :String ='')         :String; overload;
begin
  Result := ExMsg(LastExcept,Msg);
end;
 
function ExMsg  (const Fmt:String; const Args:array of const) :String; overload;
begin
  Result := ExMsg(Format(Fmt,Args));
end;
</pre>


