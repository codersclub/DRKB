<h1>Подключение через TMySQLClient &amp; TMySQLResult</h1>
<div class="date">01.01.2007</div>


<p>Решение нашел...</p>
<p>1. Без использования dbExpress, а с использованием специальных классов TMySQLClien &amp; TMySQLResult.</p>
<p>2. Все эти файлы ( файл приаттачит Secandr (90 кил)) надо положить либо в папку с проектом, либо в &lt;Delphi_dir&gt;/lib.</p>
<p>3. Код:</p>
<p>Сразу говорю, показал только основные моменты. Код, для определения ошибок и т.п. писать не стал.</p>
<pre>
uses
  .....
 uMysqlClient, uMysqlCT, uMysqlErrors, uMysqlHelpers, uMysqlNet, uMysqlNewPassword, uMysqlSSL, uMysqlVio;
 
type
 ...
   procedure QueryData( Query : string); // Результирующий запрос (заносим данные в таблицу)
   procedure QueryNoData( Query : string ); // insetrt, delete - нет полученны данных 
 ...
 
var
  ...
 SQLConnection     : TMysqlClient; // Объявляем переменную для соединения.
 Grid              : TStringGrid;
  ...
 
implementation
....
 
// Установка соединения
SQLConnection := TMysqlClient.Create;
 with SQLConnection do
  begin
   Host      := 'localhost';
   User      := 'root';
   Password  := '';
   Db        := 'mysql';
 
  try
   connect;
  Except On Exception Do
   begin
     Application.MessageBox( 'К сожалению, соединиться с MySQL-сервером не удалось. Проверьте правильность ввода всех параметров.' , 'Ошибка соединения' , 0 );
    exit;
   end;
  end;
 end;
 
// Выполнение запроса:
 
procedure TMainForm.QueryData( Query : string );
var
mysql_result : TMySQLResult;
i , j : integer;
OK : boolean;
begin
OK := true;
 
try
 mysql_result := SQLConnection.query( Query , true , OK );
Except On Exception Do
 begin
  Application.MessageBox( 'Запрос не выполнилс.' , 'Ошибка соединения' , 0 );
  exit;
 end;
end;
 
with Grid do 
 begin
  ColCount := mysql_result.FieldsCount;
  RowCount := mysql_result.RowsCount+1;
 
  if RowCount = 1 then
   FixedRows := 0
  else
   FixedRows := 1;
 
  for i := 0 to mysql_result.RowsCount - 1 do
    begin
      for j := 0 to mysql_result.FieldsCount do
        Cells[ j , i + 1 ] := mysql_result.FieldValue( j );
      mysql_result.Next;
    end;
 end;
 
mysql_result.free;
end;
 
procedure TMainForm.QueryNoData( Query : string );
begin
// Аналогично предыдущей процедуре, без внесения данных в таблицу. для запросов Insert, Update .....
end;
</pre>

<p class="author">Автор Mal Hack </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
