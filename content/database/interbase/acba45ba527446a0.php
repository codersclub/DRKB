<h1>Генераторы и их использование</h1>
<div class="date">01.01.2007</div>


<p>Генераторы и их использование </p>
<p class="author">Автор: <a href="mailto:delphi@demo.ru" target="_blank">Дмитрий Кузьменко</a> (<a href="https://www.ibase.ru" target="_blank">https://www.ibase.ru</a>)</p>
<p>&nbsp;</p>
<p>Источники: печатная документация и справочная информация по Borland InterBase, переписка листсервера esunix1. </p>
<p>последние изменения: 2 июля 1999. </p>
<p>Большинство SQL-серверов имеет специальные механизмы для создания уникальных идентификаторов. В Borland Interbase для этого существует механизм генераторов. </p>
<p>В данной статье будут рассмотрены следующие темы: </p>
<p>Создание генераторов </p>
<p>Использование генераторов в триггерах и хранимых процедурах </p>
<p>Изменение значения генератора </p>
<p>Получение текущего значения генератора </p>
<p>Удаление генераторов </p>
<p>Нестандартное применение генераторов </p>
<p>Создание генераторов </p>
<p>Генератор - это специальный объект базы данных, который генерирует уникальные последовательные числа. Эти числа могут быть использованы в качестве идентификаторов (например код клиента, номер счета и т.п.). Для создания генератора необходимо использовать оператор DDL </p>
<pre>CREATE GENERATOR generatorname; 
</pre>

<p>При выполнении такой команды происходит 2 действия: </p>
<p>1. На специальной странице БД отводится 4 байта для хранения значени генератора </p>
<p>2. В системной таблице RDB$GENERATORS заводится запись, куда помещаетс имя генератора иего номер (фактически смещение на странице генераторов). </p>
<p>После создания генератора его значения можно получать при помощи функции </p>
<p>GEN_ID(generatorname, inc_value) </p>
<p>где inc_value - число, на которое необходимо прирастить значение генератора. </p>
<p>Генераторы возвращают значения (и сохраняют свои значения на диске) вне контекста транзакции пользователя. Это означает, что если генератора было увеличено с 10 до 11 (инкремент 1), то даже при откате транзакции (ROLLBACK) значение генератора не вернется к предыдущему. Вместе с этим гарантируется что каждому пользователю будет возвращено уникальное значение генератора. </p>
<p>При выборке значения генератора запросом вида select gen_id(genname, x) from ... следует учитывать буферизацию выборки на клиенте. Т.е. в многопользовательской среде при выполнении двух таких запросов значения генератора будут увеличиваться "пачками", а не на величину x для каждой выбираемой записи. </p>
<p>Использование генераторов в триггерах и хранимых процедурах </p>
<p>Пример триггера, автоматически присваивающего уникальное значение ключевому полю таблицы: </p>
<p>создадим генератор для уникальной идентификации клиентов: </p>
<pre>CREATE GENERATOR NEWCLIENT; 
</pre>

<p>создадим триггер для таблицы CLIENTS : </p>
<pre>CREATE TRIGGER TBI_CLIENTS FOR CLIENTS 
ACTIVE BEFORE INSERT POSITION 0 
AS 
BEGIN 
  NEW.CLIENT_ID = GEN_ID(NEWCLIENT, 1); 
END
</pre>

<p>В результате при создании новой записи полю CLIENT_ID будет автоматически присваиваться новое значение. </p>
<p>Однако при использовании генератора в триггере возникает проблема на клиентской стороне (например в BDE, используемом в Delphi, C++Builder ...), когда клиентское приложение пытается перечитать только-что вставленную запись. Поскольку триггер меняет значение первичного ключа вставляемой записи, BDE "теряет" такую запись и чаще всего выдает сообщение "Record/Key deleted". Поскольку SQL-сервер не может сообщить клиентскому приложению о новом значении ключевого поля, необходимо сначала запросить уникальное значение с сервера, и только затем использовать его во вставляемой записи. Сделать это можно при помощи хранимой процедуры </p>
<pre>CREATE PROCEDURE GETNEWCLIENT 
RETURNS (NID INTEGER) 
AS 
BEGIN 
  NID = GEN_ID(NEWCLIENT, 1); 
END
</pre>

<p>В Delphi, вы можете поместить компонент TStoredProc на форму, подсоединить его к данной процедуре, и например в методе таблицы BeforePost написать следующее </p>
<pre>
begin 
  if DataSource.State = dsInsert then 
    begin 
      StoredProc1.ExecProc; 
      ClientTable.FieldByName('CLIENT_ID').asInteger:= 
         StoredProc1.Params[0].asInteger; 
    end; 
end;
</pre>

<p>После этого вышеприведенный триггер TBI_CLIENTS можно либо удалить, либо переписать так, чтобы генератор использовался только когда поле первичного ключа случайно приобрело значение NULL (например когда к таблице CLIENTS доступ осуществляется не через ваше приложение): </p>
<pre>ALTER TRIGGER TBI_CLIENTS 
AS 
BEGIN 
  IF (NEW.CLIENT_ID IS NULL) THEN 
    NEW.CLIENT_ID = GEN_ID(NEWCLIENT, 1); 
END 
</pre>

<p>Однако использование хранимой процедуры не всегда удобно - BDE может решить, что процедура вероятно изменяет какие-то данные на сервере, и в режиме autocommit завершит текущую транзакцию, что вызовет перечитывание данных TTable и TQuery. Более простым способом является получение значения генератора при помощи запроса: </p>
<p>SELECT GEN_ID(NEWCLIENT, 1) FROM RDB$DATABASE </p>
<p>При этом, если запрос помещен например в Query2, текст в BeforePost будет следующим: </p>
<pre>begin 
  if DataSource.State = dsInsert then 
    begin 
      Query2.Open; 
      ClientTable.FieldByName('CLIENT_ID').asInteger:= 
         Query2.Fields[0].asInteger; 
      Query2.Close; 
    end; 
end; 
</pre>
<p>  </p>
<p>Такой способ более предпочтителен, чем использование хранимой процедуры для получения значения генератора, особенно при большом количестве генераторов. </p>
<p>Изменение значения генератора </p>
<p>Значение генератора можно переустановить при помощи оператора DDL </p>
<pre>SET GENERATOR generatorname TO value; 
</pre>

<p>Однако вы не сможете использовать такое выражение в теле триггера или хранимой процедуры, т.к. там можно использовать только операторы DML (а не DDL). </p>
<p>Если вы хотите обнулить генератор, или присвоить ему определенное значение в теле хранимой процедуры, то вы можете это сделать используя функцию GEN_ID: </p>
<p>(В данном примере генератор NEWCLIENT увеличивается на свое-же значение с отрицательным знаком.) </p>
<p>... </p>
<p>TEMPVAR = GEN_ID(NEWCLIENT, -GEN_ID(NEWCLIENT, 0); </p>
<p>... </p>
<p>Будьте внимательны при выполнении таких операций в многопользовательских средах. Приложения, процедуры и триггеры, которые в данный момент используют этот генератор, могут предполагать что он не будет "обнулен". Обязательно проверяйте "обнуление" генератора на возникновение конфликтных ситуаций при работе 2-х и более пользователей. </p>
<p>Получение текущего значения генераторов </p>
<p>Текущее значение генератора можно получить, вызвав функцию GEN_ID с нулевым увеличением значения генератора. Это можно сделать не только в триггере или хранимой процедуре, но и оператором SELECT </p>
<pre>SELECT GEN_ID(NEWCLIENT, 0) FROM RDB$DATABASE 
</pre>

<p>Результатом выполнения запроса будет одна запись с одним полем, содержащим текущее значение генератора. Таблица RDB$DATABASES выбрана как содержаща в большинстве случаев одну запись, хотя использовать можно и любую другую таблицу. </p>
<p>При работе в многопользовательских средах будьте внимательны - в то время как вы получили "текущее" значение генератора, другое приложение может его изменить, и таким образом "текущее" значение окажется устаревшим. Тем более не рекомендуется использовать "текущее" значение генератора для его последующего изменения. </p>
<p>Удаление генераторов </p>
<p>В языке DDL Borland Interbase нет оператора для удаления генератора. Неизвестно, чем это вызвано, но серьезной проблемы не представляет. В самом начале статьи было упомянуто, что запись о генераторе создается в таблице RDB$GENERATORS. Эту запись, безусловно, можно удалить. Однако место, распределенное на странице генераторов, освобождено не будет. Оно будет освобождено только после того, как вы сделаете вашей БД BACKUP/RESTORE. </p>
<p>Нестандартное применение генераторов </p>
<p>Вы уже видели, что функцию GEN_ID можно использовать в операторе SELECT. </p>
<p>Вот как можно получить количество записей, выбранных запросом: </p>
<pre>SET GENERATOR MYGEN TO 0; 
SELECT GEN_ID(MYGEN, 1), FIELD1, FIELD2, FIELD3, ... FROM MYTABLE. 
</pre>

<p>Такой запрос вернет в качестве первого поля порядковый номер записи, и после выполнения запроса генератор MYGEN будет содержать количество возвращенных записей. Кроме этого, во время выполнения этого запроса любой другой пользователь этой-же БД может получить текущее значение генератора MYGEN и узнать сколько записей уже выбрано запросом на текущий момент (нечто вроде ProgressBar, однако число записей все-равно неизвестно до окончания выполнения запроса). </p>
<p>Функцию GEN_ID можно также использовать и как "выключатель" длительных запросов. Пример приведен для БД EMPLOYEE.GDB. </p>
<pre>SET GENERATOR EMP_NO_GEN TO 0; 
SELECT * FROM EMPLOYEE, EMPLOYEE, EMPLOYEE 
WHERE GEN_ID(EMP_NO_GEN, 0) = 0; 
</pre>

<p>Фактически такой запрос означает - "выбирать записи пока значение генератора = 0". Как только другой пользователь или ваше приложение в другом коннекте выполнит операцию </p>
<pre>SET GENERATOR EMP_NO_GEN TO 1; 
</pre>

<p>запрос прекратится, т.к. условие WHERE станет равным FALSE. </p>
<p>(то-же самое, и даже в более сложных вариантах, можно делать при помощи UDF в Borland InterBase 4.2. см "Особенности версии 4.2") </p>
<p class="note">Примечание</p>
<p>Обязательно учтитывайте буферизацию записей клиентской частью (gds32.dll) или сервером при выполнении подобных запросов. Например, приведенный выше запрос с проверкой генератора в where "выключится" не сразу, а через некоторое время. </p>
<p>Безусловно, в многопользовательской среде невозможно использовать в таких целях один и тот-же генератор. Для решения этой проблемы можно завести глобальный генератор, который будет выдавать уникальные идентификаторы пользователям при коннекте, а клиентское приложение будет запоминать его номер и хранить на локальном компьютере для последующего использования. Логика работы может быть следующая: </p>
<p>&#8226;  Клиентское приложение при запуске определяет, есть-ли для него (например в Registry или INI-файле) "именной" генератор. </p>
<p>&#8226;  Если нет, то оно операцией SELECT GEN_ID(GlobalGen, 1) FROM RDB$DATABASE получает идентификатор (например 150), создает на сервере собственный генератор операцией CREATE GENERATOR USER_N; (например USER150). После чего сохраняет имя этого генератора на локальном диске. </p>
<p>&#8226;  Если да, то приложение обнуляет "именной" генератор операцией SET GENERATOR ... TO 0; (в нашем примере SET GENERATOR USER150 TO 0;), и выдает запросы с использованием данного генератора. </p>
<p>  </p>
<p>  </p>
<p>При помощи генераторов можно также решить проблему с отсутствием временных таблиц в Borland Interbase. Вы создаете таблицу, например TEMP_TBL, и в качестве первого поля, входящего в первичный ключ, указываете поле типа INTEGER. Пользователь при соединении с сервером получает собственный идентификатор у некоторого общего генератора, и затем использует его при помещении записей в такую "временную" таблицу. В результате, даже если несколько пользователей будут работать с такой таблицей, они никогда не "пересекутся" по значению первого поля первичного ключа "временной" таблицы.. </p>
<p>Если вам недостаточно одного генератора в первичном ключе, и первичный ключ должен состоять из двух и более полей, значения которых устанавливаются генераторами, то решить такую задачу только при помощи генераторов невозможно. Для этого необходимо скомбинировать генераторы, триггеры и UDF</p>
<p>пояснения: </p>
<p>&#8226;  DDL - Data Definition Language, язык определения данных </p>
<p>&#8226;  DML - Data Manipulation Language, язык обработки данных </p>
<p>Copyright © 1996 Epsylon Technologies</p>
<p>Взято из FAQ Epsylon Technologies (095)-913-5608; (095)-913-2934; (095)-535-5349</p>
