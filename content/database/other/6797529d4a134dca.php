<h1>Advantage Database Server</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Vyacheslav</div>

<p>1) Краткое описание - Advantage Database Server(ADS) - разработка фирмы Extended System, Inc (http://www.AdvantageDatabase.com). Развивается с начала 90-x годов. Первоначально была известен как Advantage X-Base Server и предназначался для работы в клиент-серверном режиме с таблицами формата dbf(Clipper, Foxpro) и базировался до 4 версии только на Novell платформе. К отличительной особенностью является использование ISAМ(indexed sequentil access method) - индексный последовательный метод доступа. С версии 5.0 появилась версия для NT и добавлен собственный форма таблиц, а с версии 5.5 поддерживается SQL. В настоящее время выпущена версия с номером 7.0</p>
<p>2) возможности -</p>
<p>Небольшое отступление: ADS с таблицами работает в двух режимах Free Tables и Database. Режим Free Tables предполагает работу с таблицами как с отдельными несвязанными с друг другом структурными единицами. При режиме Database группа таблиц рассматривается как единая база данных со всеми вытекающими последствиями. Открыть таблицу, входящую в Database как самостоятельную таблицу в режиме Free Tables невозможно.</p>
<p>- количество баз данных на сервере - Так как физически базы данных представляют набор файлов: таблицы, индексы, словари, то ограничения определяются только возможностями операционной системы и мощностью компьютера. Имеется оганичения на количество одновременно открытых таблиц на одно соединение(не путать с пользователем) - не более 250. Но пользователь может иметь неограниченное количество соединений.</p>
<p>- размер таблиц - Так как в ADS могут использоваться одновременно два типа таблиц, то дается характеристики отдельно на каждую</p>
<p>Формат DBF</p>
<p>Максимальный количество индексов в индексном файле 50</p>
<p>Максимальное число открытых индексных файлов на таблицу 15</p>
<p>Максимальный размер файла (таблица, индексный файл, memo файл) 4 Гб</p>
<p>Максимальное число записей 2 миллиарда</p>
<p>Максимальная длина записи 65530 bytes</p>
<p>Максимальная длина имени поля 10 characters</p>
<p>Максимальная длина имени итдекса 10 characters</p>
<p>Максимальный размер binary/image/BLOB поля 4 Гб</p>
<p>Максимальное число полей на таблицу 2035</p>
<p>Формат ADT</p>
<p>Максимальный количество индексов в индексном файле 50</p>
<p>Максимальное число открытых индексных файлов на таблицу 15</p>
<p>Максимальный размер таблицы</p>
<p>Windows 95/98/ME 4 gigabytes (4,294,967,296 bytes)</p>
<p>Windows NT/2000 with NTFS 16 exabytes (18,446,744,073,709,551,616 bytes)</p>
<p>Windows NT/2000 with FAT32 4 gigabytes (4,294,967,296 bytes)</p>
<p>NetWare 4 gigabytes (4,294,967,296 bytes)</p>
<p>Linux pre-2.1.2 - 11 glibc and pre-2.4 kernel 2 gigabytes (2,147,483,648 bytes)</p>
<p>Linux glibc 2.1.2 - 11+ with kernel 2.4+ 8 exabytes (9,223,372,036,854,775,807 bytes)</p>
<p>Максимальный размер индексного файлa</p>
<p>Windows 95/98/ME 4 gigabytes (4,294,967,296 bytes)</p>
<p>Windows NT/2000 with NTFS 4 gigabytes * (Index Page Size) : Max 35 terabytes</p>
<p>Windows NT/2000 with FAT32 4 gigabytes (4,294,967,296 bytes)</p>
<p>NetWare 4 gigabytes (4,294,967,296 bytes)</p>
<p>Linux pre-2.1.2 - 11 glibc and pre-2.4 kernel 2 gigabytes (2,147,483,648 bytes)</p>
<p>Linux glibc 2.1.2 - 11+ with kernel 2.4+ 4 gigabytes * (Index Page Size) : Max 35 terabytes</p>
<p>Максимальный размер memo файла</p>
<p>Windows 95/98/ME 4 gigabytes (4,294,967,296 bytes)</p>
<p>Windows NT/2000 with NTFS 4 gigabytes * (Memo Page Size) : Max 4 terabytes</p>
<p>Windows NT/2000 with FAT32 4 gigabytes (4,294,967,296 bytes)</p>
<p>NetWare 4 gigabytes (4,294,967,296 bytes)</p>
<p>Linux pre-2.1.2 - 11 glibc and pre-2.4 kernel 2 gigabytes (2,147,483,648 bytes)</p>
<p>Linux glibc 2.1.2 - 11+ with kernel 2.4+ 4 gigabytes * (Memo Page Size) : Max 4 terabytes</p>
<p>Максимальное число записей 2 миллиард .</p>
<p>Максимальная длина записи 65530 bytes</p>
<p>Максимальная длина имени поля 128 characters</p>
<p>Максимальная длина имени индекса 128 characters</p>
<p>Максимальный размер binary/image/BLOB поля 4 Гб</p>
<p>Максимальное число полей в таблице зависит от длинны имени полей , и может быть вычислено: 65135 / ( 10 + AverageFieldNameLength ).</p>
<p>Например, если средняя длина имен полей 10, то максимальное число полей - 3256</p>
<p>Для обоих форматов</p>
<p>Максимальное число транзакций ограничено размером памяти</p>
<p>Максимальное число соеединений ограничено размером памяти</p>
<p>Максимальное число одновременно открытых файлов ограничено размером памяти</p>
<p>Максимальное число блокировок ограничено размером памяти</p>
<p>- количество пользователей и количество одновременных подключений</p>
<p>количество одновременно подключенных пользователей ограничено лицензионными соглашениями, количество соединений на пользователя неограничено.</p>
<p>наличие View -возможность создания View предусмотрена в режиме работы Database. Хранится как объект справочника (dictionary). Могут быть созданы с помощью SQL-выражение CREATE VIEW или с помощью соотвествующего диалогового окна в архитекторе (ARC32)</p>
<p>наличие SP, языка программирования - собственного языка нет, роль SP играют Advantage Extended Procedure (AEP), которые представляют собой либо dll или COM-библиотеки (для Windows), или shared object (для Linux). Соответственно написать их можно практически на чем угодно : Delphi/C++Builder, VB, VC++ и т.д. Для обращения в таблицам используется либо API, либо компоненты (Delphi/C++Builder). Регистрация процедур производится посредством SQL-выражения CREATE PROCEDURE , либо с помощью соотвествующего диалогового окна в архитекторе (ARC32)</p>
<p>Пример AEP</p>
<p>////////////////////////////////////////////////////////////////////////////</p>
<p>// ## Назначение: Точка входа хранимой процедуры "Обновление справочника серий"</p>
<p>// ## Описание:</p>
<p>// ## Аргументы:&nbsp; Параметры&nbsp; хранимой процедуры:</p>
<p>// ##&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Входные: Нет</p>
<p>// ##&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Выходные: Таблица со списком новых серий</p>
<p>// ##&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ID integer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - идентификатор записи,</p>
<p>// ##&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Grup char(5)&nbsp;&nbsp;&nbsp; - группа,</p>
<p>// ##&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NNum char(13)&nbsp;&nbsp; - номенклатурный номер,</p>
<p>// ##&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name char(34)&nbsp;&nbsp; - наименование сертификата,</p>
<p>// ##&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Series char(25) - серия</p>
<p>// ## Возврат:&nbsp;&nbsp;&nbsp; Код ошибки</p>
<p>// ## Исключения: нет</p>
<p>extern "C" UNSIGNED32 __declspec(dllexport) WINAPI RefreshSeries</p>
<p>(</p>
<p> &nbsp; UNSIGNED32&nbsp;&nbsp; a_ConnectionID, // Идентификатор сессии</p>
<p> &nbsp; UNSIGNED8&nbsp;&nbsp; *a_UserName,&nbsp;&nbsp;&nbsp;&nbsp; // Имя пользователя (логин)</p>
<p> &nbsp; UNSIGNED8&nbsp;&nbsp; *a_Password,&nbsp;&nbsp;&nbsp;&nbsp; // Пароль пользователя</p>
<p> &nbsp; UNSIGNED8&nbsp;&nbsp; *a_ProcName,&nbsp;&nbsp;&nbsp;&nbsp; // Имя хранимой процедуры(не пользоваться:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // будет исключено в следующей версии</p>
<p> &nbsp; UNSIGNED32&nbsp;&nbsp; a_RecNum,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Аргумент зарезервирован для тригера</p>
<p> &nbsp; UNSIGNED8&nbsp;&nbsp; *a_InpName,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Имя таблицы входных аргументов хранимой процедуры</p>
<p> &nbsp; UNSIGNED8&nbsp;&nbsp; *a_OutName&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // Имя таблицы&nbsp; выходных аргументов хранимой процедуры</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // или возращаемого курсора данных</p>
<p>)</p>
<p>{</p>
<p> &nbsp; try</p>
<p> &nbsp; {</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TModuleAEP* ModuleAEP = (TModuleAEP*)gAEPSessionMgr-&gt;GetDM(a_ConnectionID);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ModuleAEP-&gt;ParamsReconnect((char*)a_InpName, (char*)a_OutName);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ModuleAEP-&gt;RefreshSeries();</p>
<p> &nbsp; }</p>
<p> &nbsp; catch( EADSDatabaseError *E )</p>
<p> &nbsp; {</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; return E-&gt;ACEErrorCode;</p>
<p> &nbsp; }</p>
<p> &nbsp; return AE_SUCCESS;</p>
<p>}</p>
<p>void __fastcall TCertModuleAEP::RefreshSeries(void)</p>
<p>{</p>
<p>try</p>
<p>{</p>
<p> &nbsp; FreeSeries_-&gt;Active = true;</p>
<p> &nbsp; Series_-&gt;Active = true;</p>
<p> &nbsp; NewSeries_-&gt;Active = true;</p>
<p> &nbsp; try</p>
<p> &nbsp; {</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Series_-&gt;Last();</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; int LastID = Series_ID-&gt;AsInteger;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NewSeries_-&gt;AdsCopyTableContents(Series_);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Series_-&gt;Filter = Format("ID &gt; %d",ARRAYOFCONST((LastID)));</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Series_-&gt;Filtered = true;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Series_-&gt;AdsCopyTableContents(FreeSeries_);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Series_-&gt;AdsCopyTableContents(Output_);</p>
<p> &nbsp; }</p>
<p> &nbsp; __finally</p>
<p> &nbsp; {</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Series_-&gt;Filtered = false;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Series_-&gt;Active = false;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FreeSeries_-&gt;Active = false;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; NewSeries_-&gt;Active = false;</p>
<p> &nbsp; }</p>
<p>}</p>
<p>catch(Exception&amp; Exc)</p>
<p>{</p>
<p> &nbsp; Output_-&gt;Append();</p>
<p> &nbsp; Output_-&gt;FieldByName("Name")-&gt;AsString = Exc.Message;</p>
<p> &nbsp; Output_-&gt;Post();</p>
<p>}</p>
<p>}</p>
<p>- наличие триггеров - имееются с в режиме Database, начиная с версии 7. Поддерживаются три вида триггеров BEFORE, AFTER и INSTEAD OF. Триггера могут быть написаны либо также как AEP, в виде dll, COM, либо они могут предствалять из себя SQL-выражение</p>
<p>CREATE TRIGGER mytrigger ON orders AFTER DELETE BEGIN INSERT INTO backup_orders SELECT * FROM __old; END</p>
<p>CREATE TRIGGER mytrigger ON orders INSTEAD OF UPDATE</p>
<p>FUNCTION MyFunction IN ASSEMBLY MyAssembly.MyClass PRIORITY 2</p>
<p>Пример кода тригера INSTEAD OF INSERT, который заполняет поле при вставке новой записи значением GUID</p>
<p>library AutoGUID;</p>
<p>{$INCLUDE versions.inc}</p>
<p>{$IFDEF ADSDELPHI7_OR_NEWER}</p>
<p>  {$WARN UNSAFE_TYPE OFF}</p>
<p>  {$WARN UNSAFE_CODE OFF}</p>
<p>  {$WARN UNSAFE_CAST OFF}</p>
<p>{$ENDIF}</p>
<p>uses</p>
<p> SysUtils,</p>
<p> Classes,</p>
<p> ace,</p>
<p> adscnnct,</p>
<p> adsset,</p>
<p> adsdata,</p>
<p> adstable,</p>
<p> COMobj;</p>
<p>// Utility Function Prototype</p>
<p>procedure SetError ( conn : TAdsConnection; code : UNSIGNED32; err&nbsp; : string ); forward;</p>
<p>// Sample Advantage Trigger function. If you change the name of this</p>
<p>// function, remember to also change the name in the exports list at the bottom</p>
<p>// of this file.</p>
<p>function InsertGUID</p>
<p>(</p>
<p> ulConnectionID : UNSIGNED32; // (I) Unique ID identifying the user causing this trig</p>
<p> hConnection&nbsp;&nbsp;&nbsp; : ADSHANDLE;&nbsp; // (I) Active ACE connection handle user can perform</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //&nbsp;&nbsp;&nbsp;&nbsp; operations on</p>
<p> pcTriggerName&nbsp; : PChar;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // (I) Name of the trigger object in the dictionary</p>
<p> pcTableName&nbsp;&nbsp;&nbsp; : PChar;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // (I) Name of the base table that caused the trigger</p>
<p> ulEventType&nbsp;&nbsp;&nbsp; : UNSIGNED32; // (I) Flag with event type (insert, update, etc.)</p>
<p> ulTriggerType&nbsp; : UNSIGNED32; // (I) Flag with trigger type (before, after, etc.)</p>
<p> ulRecNo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : UNSIGNED32&nbsp; // (I) Record number of the record being modified</p>
<p>) : UNSIGNED32;</p>
<p>{$IFDEF WIN32}stdcall;{$ENDIF}{$IFDEF LINUX}cdecl;{$ENDIF} // Do not change the prototype.</p>
<p>const</p>
<p> // In this case, the first field is the Primary Key field</p>
<p> //&nbsp;&nbsp; in the base table that needs the AutoGUID value.</p>
<p> // This constant definition is necessary because</p>
<p> //&nbsp;&nbsp; triggers don't take parameters.</p>
<p> iGUIDfieldNum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Integer = 0;</p>
<p>var</p>
<p> oConn&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : TAdsConnection;</p>
<p> oNewTable, oSourceTable : TAdsTable;</p>
<p> iFieldNum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Integer;</p>
<p>begin</p>
<p> // Result is currently reserved and not used. Always return zero.</p>
<p> Result := 0;</p>
<p> // Allocate a connection object using an active connection, no need to open it after this.</p>
<p> oConn := TAdsConnection.CreateWithHandle( nil, hConnection );</p>
<p> try</p>
<p> &nbsp; try</p>
<p> &nbsp;&nbsp;&nbsp; oConn.Name := 'conn';</p>
<p> &nbsp;&nbsp;&nbsp; oNewTable := TAdsTable.Create( nil );</p>
<p> &nbsp;&nbsp;&nbsp; oNewTable.DatabaseName := oConn.Name;</p>
<p> &nbsp;&nbsp;&nbsp; oNewTable.TableName := '__new';</p>
<p> &nbsp;&nbsp;&nbsp; oNewTable.Open;</p>
<p> &nbsp;&nbsp;&nbsp; oSourceTable := TAdsTable.Create( nil );</p>
<p> &nbsp;&nbsp;&nbsp; oSourceTable.DatabaseName := oConn.Name;</p>
<p> &nbsp;&nbsp;&nbsp; oSourceTable.TableName := pcTableName;</p>
<p> &nbsp;&nbsp;&nbsp; oSourceTable.Open;</p>
<p> &nbsp;&nbsp;&nbsp; oSourceTable.Insert;</p>
<p> &nbsp;&nbsp;&nbsp; //&nbsp; Copy all new field values over without posting.</p>
<p> &nbsp;&nbsp;&nbsp; for iFieldNum := 0 to Pred(oSourceTable.FieldCount) do</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; if not oNewTable.Fields[iFieldNum].IsNull then</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; oSourceTable.Fields[iFieldNum].Value :=</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; oNewTable.Fields[iFieldNum].Value</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; else</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; oSourceTable.Fields[iFieldNum].Clear;</p>
<p> &nbsp;&nbsp;&nbsp; //&nbsp; Now set the GUID field value to a GUID value.</p>
<p> &nbsp;&nbsp;&nbsp; oSourceTable.Fields[iGUIDfieldNum].AsString := CreateClassID;</p>
<p> &nbsp;&nbsp;&nbsp; oSourceTable.Post;</p>
<p> &nbsp; except</p>
<p> &nbsp;&nbsp;&nbsp; on E : EADSDatabaseError do</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SetError( oConn, E.ACEErrorCode, E.message );</p>
<p> &nbsp;&nbsp;&nbsp; on E : Exception do</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SetError( oConn, 0, E.message );</p>
<p> &nbsp; end;</p>
<p> finally</p>
<p> &nbsp; FreeAndNil(oSourceTable);</p>
<p> &nbsp; FreeAndNil(oNewTable);</p>
<p> &nbsp; FreeAndNil(oConn);</p>
<p> end;</p>
<p>end;</p>
<p>// Utility function to return an error from a trigger.</p>
<p>procedure SetError</p>
<p>(</p>
<p> conn : TAdsConnection;</p>
<p> code : UNSIGNED32;</p>
<p> err&nbsp; : string</p>
<p>);</p>
<p>begin</p>
<p> // Errors can be returned by placing a row into the __error table.</p>
<p> conn.Execute( 'INSERT INTO __error VALUES( ' + IntToStr( code ) +</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ', ' + QuotedStr( err ) + ' )' );</p>
<p>end;</p>
<p>exports</p>
<p> InsertGUID;</p>
<p>begin</p>
<p> // Because this DLL is used by a multi-threaded application (the Advantage</p>
<p> // server), we must set the Delphi IsMultiThread global variable to TRUE.</p>
<p> IsMultiThread := TRUE;</p>
<p>end.</p>
<p>- репликация и синхронизация, перенос данных, средства backup - встроенных механизмов в настоящее время нет, их появление запланировано в версии 8, но возможно использовании внешнего Advantage Replication, выполненного на основе сервера приложений этой же фирмы - OneBridge Mobile Groupware (ранее известного как XTNDConnect Server). Кстати этот репликатор может применяться как между серверам различных(других) фирм, так и для синхронизации баз данных между клиентом и сервером в режиме работы briefcase. Синхронизация может проходить по определенному алгоритму с заданием полей, приоритетов и правил разрешений конфликтов. Кроме того, по-скольку базы данных представляют собой набор файлов возможно использование стандартных файловых backup-систем.</p>
<p>- поддержка кластеров - в настоящее время,нет. Запланировано в версии 7.1</p>
<p>- возможность взаимодействия между серверами, включая сервера других типов. - Непосредствено в одном запросе обратиться к двум таблицам из разных баз данных, расположенных физически на разных серверах нельзя. Такую операцию можно сделать если</p>
<p>1). базы данных расположены на одном сервере</p>
<p>2). запрос направлен к локальному серверу и нужно к еще подключить таблицу(ы) от удаленного сервера.</p>
<p>В этом случае используется понятие Link, при создании которого указываеися алиас, путь к справочнику БД, имя пользователя и пароль, под которым происходит подключение. Если имя пользователя и пароль не задан, то подключение будет производится под тем же именем, под которым пользователь подключен к текущей</p>
<p>-- в примерах backup и Link1 - линки к другим базам данных</p>
<p>UPDATE Customers SET address = ( SELECT address FROM backup.Customers b WHERE b.cust_id = Customers.cust_id )</p>
<p>CREATE VIEW Link1_T1 AS SELECT cust_name FROM Link1.customers WHERE credit_limit &gt; 50000</p>
<p>Кроме того, так как хранимые процедуры - это dll, COM или shared object, то посредством них можно обеспечить доступ к любым СУБД, например: подключиться к MS SQL, получить данные, вставить эти данные в набор, заполнить поля дополнительными данными из таблицы ADS, и этот набор вернуть в качестве результата работы AEP.</p>
<p>Можно, например, организовать цепочку вызовов процедур на удаленных серверах, например :</p>
<p>Клиент - &gt; AEP(Server1)</p>
<p>AEP(Server1)-&gt;AEP(Server2) -&gt;AEP(Server4)-&gt;...</p>
<p>AEP(SErver1)-&gt;AEP(Server4)</p>
<p>и т.д</p>
<p>- поддерживаемые типы данных -</p>
<p>Формат DBF</p>
<p>Character -- фиксированая строка(</p>
<p>Numeric -- число с фиксированной запятой.</p>
<p>Data -- дата(CCYYMMDD).</p>
<p>Logical -- логическое значение ('0', '1', 'T', 't', 'Y', and 'y').</p>
<p>Memo -- мемо-поле</p>
<p>Формат ADT</p>
<p>Character -- фиксированная строка</p>
<p>Date -- Дата.</p>
<p>Logical -- логическое значение</p>
<p>Memo -- memo-поле для строковых данных</p>
<p>Double -- число с плавающей запятой</p>
<p>Integer -- целое</p>
<p>Image -- мемополе содержащее графические данные</p>
<p>Binary -- мемополе для бинарных</p>
<p>ShortInteger -- короткое целое (-32,767 to 32,766)</p>
<p>Time -- время.</p>
<p>TimeStamp -- Дата-время</p>
<p>AutoIncrement -- автоинкрементное поле (0 to 4,294,967,296)</p>
<p>Raw -- типонезависимое поле фиксированоой длины (1 to 65530)</p>
<p>CurDouble -- поле для денежных расчетов (хранится два знака после запятой)</p>
<p>Money -- храниться четыре знака после запятой</p>
<p>поддерживаемые конструкции SQL-</p>
<p>ALTER TABLE</p>
<p>BEGIN TRANSACTION</p>
<p>COMMIT WORK</p>
<p>CREATE DATABASE - создание базы данных</p>
<p>CREATE INDEX</p>
<p>CREATE PROCEDURE</p>
<p>CREATE TABLE</p>
<p>CREATE TRIGGER</p>
<p>CREATE VIEW</p>
<p>DELETE</p>
<p>DROP INDEX</p>
<p>DROP PROCEDURE</p>
<p>DROP TABLE</p>
<p>DROP TRIGGER</p>
<p>DROP VIEW</p>
<p>EXECUTE PROCEDURE</p>
<p>GRANT -- давать права пользователю(группе пользователей) на выполнение операции на таблице(столбце)</p>
<p>QUOTE  &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p> // разрешается sales_group просматривать поле accounts таблицы customers GRANT SELECT ON customers.accounts TO sales_group&nbsp; //разрешается user1 вставке записи вводить значение для поля accounts таблицы customers GRANT INSERT( accounts ) ON customers TO user1 //для managers разрешаются все действия над таблицей customers GRANT ALL ON customers TO managers  &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>GRANT быть применен к таблице(столбцу), view, процедуре линку со следующими ключами (в зависимости от типа объекта и типа операции)</p>
<p>SELECT, SELECT( columnname )</p>
<p>INSERT, INSERT( columnname )</p>
<p>UPDATE, UPDATE( columnname )</p>
<p>ACCESS</p>
<p>EXECUTE</p>
<p>INHERIT</p>
<p>ALL</p>
<p>INSERT</p>
<p>REVOKE -- запрещать пользователю(группе пользователей) выполнение операции (см GRANT)</p>
<p>ROLLBACK WORK</p>
<p>SELECT</p>
<p>SET TRANSACTION</p>
<p>UPDATE</p>
<p>Кроме того имеется возможность получить с помощью SQL - выражения всю информацию по метаданным используюя системные псевдо таблицы</p>
<p>Например, получение всех объектов из справочника БД</p>
<p>QUOTE  &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p> SELECT * FROM system.objects  &nbsp; &nbsp; &nbsp; &nbsp;</p>
<p>system.dictinary - информация об базе данных :версия (не путать с версией сервера, имеется в виду именно версия БД), путь, ключ шифрования(если применено и только если запршивает админ), разрешение работы через интернет, прав доступа и .тд.</p>
<p>system.objects - все объекты</p>
<p>system.tables - таблицы</p>
<p>system.columns - столбцы</p>
<p>system.users</p>
<p>system.usersgroup</p>
<p>system.usergroupmembers</p>
<p>system.indexfiles</p>
<p>system.indexes</p>
<p>system.permission</p>
<p>system.relation -</p>
<p>system.views</p>
<p>system.storedprocedures</p>
<p>system.links</p>
<p>system.triggers</p>
<p>- поддержка транзакций - есть</p>
<p>- системы репортинга, в том числе для Web - возможно использование других репортинговых систем: Crystal Report, Fast Report, Quick Report, Rave и д.р. Собственного репортинга ориентированного на Web нет.</p>
<p>- наличие собственного агента для выполнения заданий по расписанию - нет \</p>
<p>3) Защита данных, шифрование - Возможно как шифрование отдельно взятых таблиц, так и шифрование базы данных в целом(вместе с метаданными). Используется профессиональный 160-битный алгоритм шифрования.</p>
<p>4) простота использования - Сам сервер после установки в администрировании не нужается. Адинистрирование необходимо только для текущего ведения(создание, реорганизация, модификация) баз данных и таблиц</p>
<p>- наличие встроенных средств администрирования с GUI интерфейсом - Имеется менеджер ARC32, реализующего все функции для создания баз данных и манипуляции с ними.</p>
<p>- возможность удалённого и Web администрирования - так как сервер имеет встроенный инернет-сервис(до шестой версии это был отдельный продукт) , то имеется возможность подключиться к серверу через интернет(например с помпощь того же ARC32) и выполнить все операции по реорганизации БД удаленно</p>
<p>- сложность перевода проекта написанного под другую базу данных на рассматриваемую - В зависимости от первоначальной БЗ, стпень переноса может быть разной. Программы, написанные на Clipper могут быть перенесены достаточно легко. Для того, что бы Clipper приложение интегрировать с Advantage необходимо его перелинковать с новым RDD. Для линковки (сборки) нужны OBJ модули. Если потерян только код, а OBJ сохранились, то проблем нет. А вот если нет OBJ, то единственное, что можно сделать - попытаться программой типа DECLIP восстановить исходные коды или подменить драйвер. Эта утилита распространяется бесплатно, она есть на многих BBS и в интернете. Имеется и также возможность импортирования таблиц (встроена в ACR32) в следующих вариантах подключения</p>
<p>-- ADO Data Source</p>
<p>-- Paradox, dBase, Advantage Compatible</p>
<p>-- BDE</p>
<p>-- PervasiveSQL(Btrieve)</p>
<p>-- Text file</p>
<p>Имеется также методика конвертирования приложений, использующих TTablе:</p>
<p>Converting Delphi TTable Instances to Advantage TAdsTable Instances</p>
<p>- сложность в установке и настройке - установка автоматическая, проблем не возникает</p>
<p>- насколько сложно администрирование сервера - администрирование практически не требуется</p>
<p>- наличие утилит для автоматизации операций для работы в командной строке - имеется в менеджере ARC32</p>
<p>- наличие собственных утилит для отладки запросов (выполнение SQL, построение плана выполнения кверей, профайлер и т.п.), утилиты для слежения за производительностью сервера. - ARC32</p>
<p>5) платформы</p>
<p>- на которых может работать сервер - - Npvell, Windows 9X, WinNT/2000, Linux</p>
<p>- на которых может работать клиент - MS DOS, Windows 9X, WinNT/2000, Linux</p>
<p>6) версии продуктов, краткая характеристика отличий</p>
<p>Текущая весия 7.0, техническая поддержка оказывается для версий 6.xx</p>
<p>Версия 5.0 - поддержка сервера на платформы WinNT(ранее был только Novell)</p>
<p>Версия 5.5 - поддержка SQL</p>
<p>Версия 5.7 - поддержка сервера на плптформе Win9x, поддержка транзакций</p>
<p>Версия 6.0 - поддержка сервера и клиента на платформе Linux, работа в режиме Database, хранимые процедуры, поддерка ссылочной целостности.</p>
<p>Версия 7.0 - триггера</p>
<p>7) способы доступа</p>
<p>Advantage Client Engine API</p>
<p>Advantage .NET Data Provider</p>
<p>Advantage ODBC Driver (version 3)</p>
<p>Advantage JDBC Driver (Type 4)</p>
<p>Advantage OLE DB Provider</p>
<p>Advantage Perl DBI Driver</p>
<p>Advantage PHP Extension</p>
<p>Advantage CA-Clipper RDD</p>
<p>Advantage CA-Visual Objects RDDs</p>
<p>Набор компонентов Advantage TDataSet Descendant for Delphi/Kylix/C++Builder</p>
<p>- языки программирования - Clipper, Delphi/C++Builder/Kylix, Microsoft Visual Basic, Microsoft Visual C/C++, Java, Perl , Php, CA-Visual Objects</p>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
