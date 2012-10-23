<h1>Генератор SQL-запросов Insert / Update</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Mike Heydon</div>

<p>Вам ещё не надоело динамически генерировать SQL запросы insert и update ? Давайте посмотрим, как можно раз и навсегда упростить этот процесс.</p>

<p>Допустим Вы создавали запрос следующим образом (типы параметров Data1:string Data2: integer Data3:TdateTime) </p>

<pre>
SqlCmd := 'insert into MyTable (Field1,Field2,Field2) values (' +   
                QuotedStr(Data1) + ',' + IntToStr(Data2) + ',' + 'to_date(' 
                + QuotedStr(FormatdateTime('dd/mm/yyyy',Data3)) + ',' 
                + QuotedStr('dd/mm/yyyy') + '))'; 
</pre>


<p>{Ужасно! ещё хуже, когда количество колонок увеличивается} </p>

<p>А если сделать функцию типа .. </p>
<pre>
SqlCmd := SqlInsert([Data1,Data2,Variant(Data3)], 
                   'MyTable', 
                   ['Field1','Field2','Field3']); 
</pre>


<p>она эмулирует строку запроса наподобие .. </p>

<p>insert into MyTable </p>
<p>(Fields1,Field2,Field3) </p>
<p>values ('Sweets',934,to_date('21/05/2001','dd/mm/yyyy')) </p>

<p>неправда ли она более проста в использовании ? </p>

<p>Здесь представлены функции SqlInsert и SqlUpdate. Вы наверное заметили, что я передаю TDateTime приведённый как Variant. Причина кроется в том, что VType в array of const не имеете TDateTime типа и даты просто представлены как vtExtended.</p>

<p>Функция SqlInsert имеет 2 переопределённых вызова, которые позволяют Вам включить или выполнить массив имён колонок. </p>

<p>Посмотрим, как выглядят эти функции:</p>
<pre>
interface 
 
const CrLf = #13#10;  // Возврат и перевод каретки 
 
// Прототипы функций 
 
function SqlInsert(Values : array of const; 
                   TableName : string; 
                   ColNames : array of string) : string; overload; 
 
function SqlInsert(Values : array of const; 
                   TableName : string) : string; overload; 
 
function SqlUpdate(Values : array of const; 
                   TableName : string; 
                   ColNames : array of string; 
                   WhereClause : string) : string; 
 
// --------------------------------------------------------------------------- 
implementation 
 
// Помещаем TDateTime в Values (array of const) 
// Представлен как Variant 
 
function SqlInsert(Values : array of const; 
                   TableName : string; 
                   ColNames : array of string) : string; 
var RetVar : string; 
    i : integer; 
begin 
  RetVar := 'insert into ' + TableName + CrLf + 
            '(' + ColNames[0]; 
  for i := 1 to High(ColNames) do 
     RetVar := RetVar + ',' + ColNames[i]; 
  RetVar := RetVar + ')' + CrLf; 
 
  RetVar := RetVar + 'values ('; 
 
  for i := 0 to High(Values) do begin 
     case Values[i].VType of 
          vtInteger, 
          vtInt64    : RetVar := RetVar + IntToStr(Values[i].VInteger); 
          vtChar     : RetVar := RetVar + QuotedStr(Values[i].VChar); 
          vtString   : RetVar := RetVar + QuotedStr(Values[i].VString^); 
          vtPChar    : RetVar := RetVar + QuotedStr(Values[i].VPChar); 
          vtExtended : RetVar := RetVar + FloatToStr(Values[i].VExtended^); 
          vtAnsiString : RetVar := RetVar + 
                         QuotedStr(string(Values[i].VAnsiString)); 
          // TDateTime - иначе получаем как vtExtended 
          vtVariant  : RetVar := RetVar + 'to_date(' + 
                       QuotedStr(FormatdateTime('dd/mm/yyyy', 
                       TDateTime(Values[i].VVariant^))) + ',' + 
                       QuotedStr('dd/mm/yyyy') + ')'; 
     else 
       RetVar := RetVar + '??????'; 
     end; 
 
     RetVar := RetVar + ','; 
  end; 
 
  Delete(RetVar,length(RetVar),1); 
  RetVar := RetVar + ')'; 
  if High(Values) &lt; High(ColNames) then 
     ShowMessage('SQL Insert - Not enough values.'); 
  if High(Values) &gt; High(ColNames) then 
     ShowMessage('SQL Insert - Too many values.'); 
 
  Result := RetVar; 
end; 
 
 
function SqlInsert(Values : array of const; 
                   TableName : string) : string; overload; 
var RetVar : string; 
    i : integer; 
begin 
  RetVar := 'insert into ' + TableName + CrLf; 
  RetVar := RetVar + 'values ('; 
 
  for i := 0 to High(Values) do begin 
     case Values[i].VType of 
          vtInteger, 
          vtInt64    : RetVar := RetVar + IntToStr(Values[i].VInteger); 
          vtChar     : RetVar := RetVar + QuotedStr(Values[i].VChar); 
          vtString   : RetVar := RetVar + QuotedStr(Values[i].VString^); 
          vtPChar    : RetVar := RetVar + QuotedStr(Values[i].VPChar); 
          vtExtended : RetVar := RetVar + FloatToStr(Values[i].VExtended^); 
          vtAnsiString : RetVar := RetVar + 
                         QuotedStr(string(Values[i].VAnsiString)); 
          // TDateTime - иначе получаем как vtExtended 
          vtVariant  : RetVar := RetVar + 'to_date(' + 
                       QuotedStr(FormatdateTime('dd/mm/yyyy', 
                       TDateTime(Values[i].VVariant^))) + ',' + 
                       QuotedStr('dd/mm/yyyy') + ')'; 
     else 
       RetVar := RetVar + '??????'; 
     end; 
 
     RetVar := RetVar + ','; 
  end; 
 
  Delete(RetVar,length(RetVar),1); 
  RetVar := RetVar + ')'; 
 
  Result := RetVar; 
end; 
 
 
function SqlUpdate(Values : array of const; 
                   TableName : string; 
                   ColNames : array of string; 
                   WhereClause : string) : string; 
var RetVar,Parm : string; 
    i : integer; 
begin 
  RetVar := 'update ' + TableName + ' set' + CrLf; 
 
  for i := 0 to Min(High(Values),High(ColNames)) do begin 
     case Values[i].VType of 
          vtInteger, 
          vtInt64    : Parm := IntToStr(Values[i].VInteger); 
          vtChar     : Parm := QuotedStr(Values[i].VChar); 
          vtString   : Parm := QuotedStr(Values[i].VString^); 
          vtPChar    : Parm := QuotedStr(Values[i].VPChar); 
          vtExtended : Parm := FloatToStr(Values[i].VExtended^); 
          vtAnsiString : Parm := QuotedStr(string(Values[i].VAnsiString)); 
          // TDateTime - иначе получаем как vtExtended 
          vtVariant  : Parm := 'to_date(' + 
                       QuotedStr(FormatdateTime('dd/mm/yyyy', 
                       TDateTime(Values[i].VVariant^))) + ',' + 
                       QuotedStr('dd/mm/yyyy') + ')'; 
     else 
       Parm := '??????'; 
     end; 
 
     RetVar := RetVar + ColNames[i] + '=' + Parm + ','; 
  end; 
 
  Delete(RetVar,length(RetVar),1); 
  RetVar := RetVar + CrLf + 'where ' + WhereClause; 
  if High(Values) &lt; High(ColNames) then 
     ShowMessage('SQL Update - Not enough values.'); 
  if High(Values) &gt; High(ColNames) then 
     ShowMessage('SQL Update - Too many values.'); 
 
  Result := RetVar; 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

