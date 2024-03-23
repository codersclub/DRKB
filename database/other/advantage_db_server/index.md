---
Title: Advantage Database Server
Author: Vyacheslav
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Advantage Database Server
=========================

## Краткое описание

Advantage Database Server (ADS) - разработка фирмы
Extended System, Inc (http://www.AdvantageDatabase.com). Развивается с
начала 90-x годов. Первоначально была известен как Advantage X-Base
Server и предназначался для работы в клиент-серверном режиме с таблицами
формата dbf(Clipper, Foxpro) и базировался до 4 версии только на Novell
платформе. К отличительной особенностью является использование
ISAМ(indexed sequentil access method) - индексный последовательный метод
доступа. С версии 5.0 появилась версия для NT и добавлен собственный
форма таблиц, а с версии 5.5 поддерживается SQL. В настоящее время
выпущена версия с номером 7.0

## Возможности

Небольшое отступление: ADS с таблицами работает в двух режимах Free
Tables и Database. Режим Free Tables предполагает работу с таблицами как
с отдельными несвязанными с друг другом структурными единицами. При
режиме Database группа таблиц рассматривается как единая база данных со
всеми вытекающими последствиями. Открыть таблицу, входящую в Database
как самостоятельную таблицу в режиме Free Tables невозможно.

- количество баз данных на сервере - Так как физически базы данных
представляют набор файлов: таблицы, индексы, словари, то ограничения
определяются только возможностями операционной системы и мощностью
компьютера. Имеется оганичения на количество одновременно открытых
таблиц на одно соединение(не путать с пользователем) - не более 250. Но
пользователь может иметь неограниченное количество соединений.

- размер таблиц - Так как в ADS могут использоваться одновременно два
типа таблиц, то дается характеристики отдельно на каждую

### Формат DBF

- Максимальный количество индексов в индексном файле 50
- Максимальное число открытых индексных файлов на таблицу 15
- Максимальный размер файла (таблица, индексный файл, memo файл) 4 Гб
- Максимальное число записей 2 миллиарда
- Максимальная длина записи 65530 bytes
- Максимальная длина имени поля 10 characters
- Максимальная длина имени итдекса 10 characters
- Максимальный размер binary/image/BLOB поля 4 Гб
- Максимальное число полей на таблицу 2035

### Формат ADT

- Максимальный количество индексов в индексном файле 50
- Максимальное число открытых индексных файлов на таблицу 15
- Максимальный размер таблицы
    - Windows 95/98/ME 4 gigabytes (4,294,967,296 bytes)
    - Windows NT/2000 with NTFS 16 exabytes (18,446,744,073,709,551,616 bytes)
    - Windows NT/2000 with FAT32 4 gigabytes (4,294,967,296 bytes)
    - NetWare 4 gigabytes (4,294,967,296 bytes)
    - Linux pre-2.1.2 - 11 glibc and pre-2.4 kernel 2 gigabytes (2,147,483,648 bytes)
    - Linux glibc 2.1.2 - 11+ with kernel 2.4+ 8 exabytes (9,223,372,036,854,775,807 bytes)
- Максимальный размер индексного файлa
    - Windows 95/98/ME 4 gigabytes (4,294,967,296 bytes)
    - Windows NT/2000 with NTFS 4 gigabytes * (Index Page Size) : Max 35 terabytes
    - Windows NT/2000 with FAT32 4 gigabytes (4,294,967,296 bytes)
    - NetWare 4 gigabytes (4,294,967,296 bytes)
    - Linux pre-2.1.2 - 11 glibc and pre-2.4 kernel 2 gigabytes (2,147,483,648 bytes)
    - Linux glibc 2.1.2 - 11+ with kernel 2.4+ 4 gigabytes * (Index Page Size) : Max 35 terabytes
- Максимальный размер memo файла
    - Windows 95/98/ME 4 gigabytes (4,294,967,296 bytes)
    - Windows NT/2000 with NTFS 4 gigabytes * (Memo Page Size) : Max 4 terabytes
    - Windows NT/2000 with FAT32 4 gigabytes (4,294,967,296 bytes)
    - NetWare 4 gigabytes (4,294,967,296 bytes)
    - Linux pre-2.1.2 - 11 glibc and pre-2.4 kernel 2 gigabytes (2,147,483,648 bytes)
    - Linux glibc 2.1.2 - 11+ with kernel 2.4+ 4 gigabytes * (Memo Page Size): Max 4 terabytes
- Максимальное число записей 2 миллиарда.
- Максимальная длина записи 65530 bytes
- Максимальная длина имени поля 128 characters
- Максимальная длина имени индекса 128 characters
- Максимальный размер binary/image/BLOB поля 4 Гб
- Максимальное число полей в таблице зависит от длинны имени полей,
и может быть вычислено: 65135 / ( 10 + AverageFieldNameLength ).  
Например, если средняя длина имен полей 10, то максимальное число полей - 3256

### Для обоих форматов

- Максимальное число транзакций ограничено размером памяти
- Максимальное число соеединений ограничено размером памяти
- Максимальное число одновременно открытых файлов ограничено размером памяти
- Максимальное число блокировок ограничено размером памяти
- количество пользователей и количество одновременных подключений
- количество одновременно подключенных пользователей ограничено
лицензионными соглашениями, количество соединений на пользователя
неограничено.
- наличие View - возможность создания View предусмотрена в режиме работы
Database. Хранится как объект справочника (dictionary). Могут быть
созданы с помощью SQL-выражение CREATE VIEW или с помощью
соотвествующего диалогового окна в архитекторе (ARC32)
- наличие SP, языка программирования - собственного языка нет, роль SP
играют Advantage Extended Procedure (AEP), которые представляют собой
либо dll или COM-библиотеки (для Windows), или shared object (для
Linux). Соответственно написать их можно практически на чем угодно :
Delphi/C++Builder, VB, VC++ и т.д. Для обращения в таблицам используется
либо API, либо компоненты (Delphi/C++Builder). Регистрация процедур
производится посредством SQL-выражения CREATE PROCEDURE, либо с помощью
соотвествующего диалогового окна в архитекторе (ARC32).

### Пример AEP

```
////////////////////////////////////////////////////////////////////////////
// ## Назначение: Точка входа хранимой процедуры "Обновление справочника серий"
// ## Описание:
// ## Аргументы:  Параметры  хранимой процедуры:
// ##             Входные: Нет
// ##             Выходные: Таблица со списком новых серий
// ##             ID integer      - идентификатор записи,
// ##             Grup char(5)    - группа,
// ##             NNum char(13)   - номенклатурный номер,
// ##             Name char(34)   - наименование сертификата,
// ##             Series char(25) - серия
// ## Возврат:    Код ошибки
// ## Исключения: нет
extern "C" UNSIGNED32 __declspec(dllexport) WINAPI RefreshSeries
(
  UNSIGNED32   a_ConnectionID, // Идентификатор сессии
  UNSIGNED8   *a_UserName,     // Имя пользователя (логин)
  UNSIGNED8   *a_Password,     // Пароль пользователя
  UNSIGNED8   *a_ProcName,     // Имя хранимой процедуры(не пользоваться:
                               // будет исключено в следующей версии
  UNSIGNED32   a_RecNum,       // Аргумент зарезервирован для тригера
  UNSIGNED8   *a_InpName,      // Имя таблицы входных аргументов хранимой процедуры
  UNSIGNED8   *a_OutName       // Имя таблицы  выходных аргументов хранимой процедуры
                               // или возращаемого курсора данных
)
{
  try
  {
      TModuleAEP* ModuleAEP = (TModuleAEP*)gAEPSessionMgr->GetDM(a_ConnectionID);
      ModuleAEP->ParamsReconnect((char*)a_InpName, (char*)a_OutName);
      ModuleAEP->RefreshSeries();
  }
  catch( EADSDatabaseError *E )
  {
      return E->ACEErrorCode;
  }
  return AE_SUCCESS;
}

void __fastcall TCertModuleAEP::RefreshSeries(void)
{
  try
  {
    FreeSeries_->Active = true;
    Series_->Active = true;
    NewSeries_->Active = true;
    try
    {
        Series_->Last();
        int LastID = Series_ID->AsInteger;
        NewSeries_->AdsCopyTableContents(Series_);
        Series_->Filter = Format("ID > %d",ARRAYOFCONST((LastID)));
        Series_->Filtered = true;
        Series_->AdsCopyTableContents(FreeSeries_);
        Series_->AdsCopyTableContents(Output_);
    }
    __finally
    {
        Series_->Filtered = false;
        Series_->Active = false;
        FreeSeries_->Active = false;
        NewSeries_->Active = false;
    }
  }
  catch(Exception& Exc)
  {
    Output_->Append();
    Output_->FieldByName("Name")->AsString = Exc.Message;
    Output_->Post();
  }
}
```

### Наличие триггеров

Триггеры имеются с в режиме Database, начиная с версии 7.

Поддерживаются три вида триггеров: BEFORE, AFTER и INSTEAD OF.

Триггера могут быть написаны либо также как AEP, в виде dll, COM, либо они могут
предствалять из себя SQL-выражение.

```sql
CREATE TRIGGER mytrigger ON orders AFTER DELETE
BEGIN
 INSERT INTO backup_orders SELECT * FROM __old;
END

CREATE TRIGGER mytrigger ON orders INSTEAD OF UPDATE
FUNCTION MyFunction IN ASSEMBLY MyAssembly.MyClass PRIORITY 2
```

Пример кода тригера INSTEAD OF INSERT, который заполняет поле при
вставке новой записи значением GUID

```delphi
library AutoGUID;
{$INCLUDE versions.inc}
{$IFDEF ADSDELPHI7_OR_NEWER}
{$WARN UNSAFE_TYPE OFF}
{$WARN UNSAFE_CODE OFF}
{$WARN UNSAFE_CAST OFF}
{$ENDIF}
uses
  SysUtils,
  Classes,
  ace,
  adscnnct,
  adsset,
  adsdata,
  adstable,
  COMobj;
// Utility Function Prototype
procedure SetError ( conn : TAdsConnection; code : UNSIGNED32; err : string ); forward;
// Sample Advantage Trigger function. If you change the name of this
// function, remember to also change the name in the exports list at the bottom
// of this file.
function InsertGUID
(
  ulConnectionID : UNSIGNED32; // (I) Unique ID identifying the user causing this trig
  hConnection    : ADSHANDLE;  // (I) Active ACE connection handle user can perform
                               //     operations on
  pcTriggerName  : PChar;      // (I) Name of the trigger object in the dictionary
  pcTableName    : PChar;      // (I) Name of the base table that caused the trigger
  ulEventType    : UNSIGNED32; // (I) Flag with event type (insert, update, etc.)
  ulTriggerType  : UNSIGNED32; // (I) Flag with trigger type (before, after, etc.)
  ulRecNo        : UNSIGNED32  // (I) Record number of the record being modified
) : UNSIGNED32;
{$IFDEF WIN32}stdcall;{$ENDIF}{$IFDEF LINUX}cdecl;{$ENDIF} // Do not change the prototype.
const
// In this case, the first field is the Primary Key field
//   in the base table that needs the AutoGUID value.
// This constant definition is necessary because
//   triggers don't take parameters.
  iGUIDfieldNum           : Integer = 0;
var
  oConn                   : TAdsConnection;
  oNewTable, oSourceTable : TAdsTable;
  iFieldNum               : Integer;
begin
  // Result is currently reserved and not used. Always return zero.
  Result := 0;
  // Allocate a connection object using an active connection, no need to open it after this.
  oConn := TAdsConnection.CreateWithHandle( nil, hConnection );
  try
    try
      oConn.Name := 'conn';
      oNewTable := TAdsTable.Create( nil );
      oNewTable.DatabaseName := oConn.Name;
      oNewTable.TableName := '__new';
      oNewTable.Open;
      oSourceTable := TAdsTable.Create( nil );
      oSourceTable.DatabaseName := oConn.Name;
      oSourceTable.TableName := pcTableName;
      oSourceTable.Open;
      oSourceTable.Insert;
      //  Copy all new field values over without posting.
      for iFieldNum := 0 to Pred(oSourceTable.FieldCount) do
        if not oNewTable.Fields[iFieldNum].IsNull then
            oSourceTable.Fields[iFieldNum].Value :=
            oNewTable.Fields[iFieldNum].Value
           else
            oSourceTable.Fields[iFieldNum].Clear;
      //  Now set the GUID field value to a GUID value.
      oSourceTable.Fields[iGUIDfieldNum].AsString := CreateClassID;
      oSourceTable.Post;
    except
      on E : EADSDatabaseError do
        SetError( oConn, E.ACEErrorCode, E.message );
      on E : Exception do
        SetError( oConn, 0, E.message );
    end;
  finally
    FreeAndNil(oSourceTable);
    FreeAndNil(oNewTable);
    FreeAndNil(oConn);
  end;
end;

// Utility function to return an error from a trigger.
procedure SetError
(
  conn : TAdsConnection;
  code : UNSIGNED32;
  err  : string
);
begin
  // Errors can be returned by placing a row into the __error table.
  conn.Execute( 'INSERT INTO __error VALUES( ' +
                 IntToStr( code ) +  ', ' + QuotedStr( err ) + ' )' );
end;
exports
InsertGUID;
begin
  // Because this DLL is used by a multi-threaded application (the Advantage
  // server), we must set the Delphi IsMultiThread global variable to TRUE.
  IsMultiThread := TRUE;
end.
```

### Репликация и синхронизация, перенос данных, средства backup.

Встроенных механизмов в настоящее время нет, их появление запланировано
в версии 8, но возможно использовании внешнего Advantage Replication,
выполненного на основе сервера приложений этой же фирмы - OneBridge
Mobile Groupware (ранее известного как XTNDConnect Server). Кстати этот
репликатор может применяться как между серверам различных(других) фирм,
так и для синхронизации баз данных между клиентом и сервером в режиме
работы briefcase. Синхронизация может проходить по определенному
алгоритму с заданием полей, приоритетов и правил разрешений конфликтов.
Кроме того, по-скольку базы данных представляют собой набор файлов
возможно использование стандартных файловых backup-систем.

### Поддержка кластеров

В настоящее время поддержки кластеров нет. Запланировано в версии 7.1

### Взаимодействие между серверами, включая сервера других типов.

Непосредствено в одном запросе обратиться к двум таблицам из
разных баз данных, расположенных физически на разных серверах нельзя.

Такую операцию можно сделать если

1. базы данных расположены на одном сервере
2. запрос направлен к локальному серверу и нужно к еще подключить
таблицу(ы) от удаленного сервера.

В этом случае используется понятие Link, при создании которого
указываеися алиас, путь к справочнику БД, имя пользователя и пароль, под
которым происходит подключение. Если имя пользователя и пароль не задан,
то подключение будет производится под тем же именем, под которым
пользователь подключен к текущей.

В примерах backup и Link1 - линки к другим базам данных.

```sql
UPDATE Customers SET address = (
  SELECT address FROM backup.Customers b
  WHERE b.cust_id = Customers.cust_id
)

CREATE VIEW Link1_T1 AS
  SELECT cust_name FROM Link1.customers
  WHERE credit_limit > 50000
```

Кроме того, так как хранимые процедуры - это dll, COM или shared object,
то посредством них можно обеспечить доступ к любым СУБД, например:
подключиться к MS SQL, получить данные, вставить эти данные в набор,
заполнить поля дополнительными данными из таблицы ADS, и этот набор
вернуть в качестве результата работы AEP.

Можно, например, организовать цепочку вызовов процедур на удаленных
серверах, например :

- Клиент -\> AEP(Server1)
- AEP(Server1) -\> AEP(Server2) -\> AEP(Server4) -\>...
- AEP(SErver1) -\> AEP(Server4)

и т.д

### Поддерживаемые типы данных

#### Формат DBF

- Character - фиксированая строка
- Numeric - число с фиксированной запятой.
- Data - дата(CCYYMMDD).
- Logical - логическое значение ('0', '1', 'T', 't', 'Y', and 'y').
- Memo - мемо-поле

#### Формат ADT

- Character - фиксированная строка
- Date - Дата.
- Logical - логическое значение
- Memo - memo-поле для строковых данных
- Double - число с плавающей запятой
- Integer - целое
- Image - мемополе содержащее графические данные
- Binary - мемополе для бинарных
- ShortInteger - короткое целое (-32,767 to 32,766)
- Time - время
- TimeStamp - Дата-время
- AutoIncrement - автоинкрементное поле (0 to 4,294,967,296)
- Raw - типонезависимое поле фиксированоой длины (1 to 65530)
- CurDouble - поле для денежных расчетов (хранится два знака после запятой)
- Money - хранится четыре знака после запятой

### Поддерживаемые конструкции SQL

- ALTER TABLE
- BEGIN TRANSACTION
- COMMIT WORK
- CREATE DATABASE - создание базы данных
- CREATE INDEX
- CREATE PROCEDURE
- CREATE TABLE
- CREATE TRIGGER
- CREATE VIEW
- DELETE
- DROP INDEX
- DROP PROCEDURE
- DROP TABLE
- DROP TRIGGER
- DROP VIEW
- EXECUTE PROCEDURE
- GRANT - давать права пользователю (группе пользователей) на выполнение
операции на таблице (столбце).  

    разрешается sales\_group просматривать поле accounts таблицы customers:

        GRANT SELECT ON customers.accounts TO sales_group

    разрешается user1 при вставке записи вводить значение для поля accounts таблицы customers

        GRANT INSERT( accounts ) ON customers TO user1

    для managers разрешаются все действия над таблицей customers

        GRANT ALL ON customers TO managers

    GRANT может быть применен к таблице (столбцу), view, процедуре, линку со
    следующими ключами (в зависимости от типа объекта и типа операции)

- SELECT, SELECT( columnname )
- INSERT, INSERT( columnname )
- UPDATE, UPDATE( columnname )
- ACCESS
- EXECUTE
- INHERIT
- ALL
- INSERT
- REVOKE - запрещать пользователю(группе пользователей) выполнение операции (см GRANT)
- ROLLBACK WORK
- SELECT
- SET TRANSACTION
- UPDATE

Кроме того имеется возможность получить с помощью SQL-выражения всю
информацию по метаданным, используя системные псевдо таблицы.

Например, получение всех объектов из справочника БД:

    SELECT * FROM system.objects

Справочник БД:

- system.dictinary - информация об базе данных :версия (не путать с
версией сервера, имеется в виду именно версия БД), путь, ключ
шифрования (если применено и только если запршивает админ), разрешение
работы через интернет, прав доступа и .тд.
- system.objects - все объекты
- system.tables - таблицы
- system.columns - столбцы
- system.users - пользователи
- system.usersgroup - группы пользователей
- system.usergroupmembers - состав групп пользователей
- system.indexfiles - индексные файлы
- system.indexes - индексы
- system.permission - права
- system.relation - связи
- system.views - представления
- system.storedprocedures - хранимые процедуры
- system.links - линки
- system.triggers - триггера


### Поддержка транзакций

Есть.

### Системы репортинга, в том числе для Web

Возможно использование других репортинговых систем:
Crystal Report, Fast Report, Quick Report, Rave и д.р.
Собственного репортинга, ориентированного на Web, нет.

### Наличие собственного агента для выполнения заданий по расписанию

Нет.

### Защита данных, шифрование

Возможно шифрование как отдельно взятых таблиц,
так и шифрование базы данных в целом (вместе с метаданными).

Используется профессиональный 160-битный алгоритм шифрования.

### Простота использования

Сам сервер после установки в администрировании не нужается.
Адинистрирование необходимо только для текущего ведения
(создание, реорганизация, модификация) баз данных и таблиц

- наличие встроенных средств администрирования с GUI интерфейсом -
Имеется менеджер ARC32, реализующего все функции для создания баз данных
и манипуляции с ними.

- возможность удалённого и Web администрирования - так как сервер имеет
встроенный инернет-сервис(до шестой версии это был отдельный продукт),
то имеется возможность подключиться к серверу через интернет(например с
помпощь того же ARC32) и выполнить все операции по реорганизации БД
удаленно

- сложность перевода проекта написанного под другую базу данных на
рассматриваемую - В зависимости от первоначальной БЗ, степень переноса
может быть разной. Программы, написанные на Clipper могут быть
перенесены достаточно легко. Для того, что бы Clipper приложение
интегрировать с Advantage необходимо его перелинковать с новым RDD. Для
линковки (сборки) нужны OBJ модули. Если потерян только код, а OBJ
сохранились, то проблем нет. А вот если нет OBJ, то единственное, что
можно сделать - попытаться программой типа DECLIP восстановить исходные
коды или подменить драйвер. Эта утилита распространяется бесплатно, она
есть на многих BBS и в интернете. Имеется и также возможность
импортирования таблиц (встроена в ACR32) в следующих вариантах
подключения:

    - ADO Data Source
    - Paradox, dBase, Advantage Compatible
    - BDE
    - PervasiveSQL(Btrieve)
    - Text file

    Имеется также методика конвертирования приложений, использующих TTablе:
    **Converting Delphi TTable Instances to Advantage TAdsTable Instances**

- сложность в установке и настройке - установка автоматическая, проблем не возникает
- насколько сложно администрирование сервера - администрирование практически не требуется
- наличие утилит для автоматизации операций для работы в командной строке - имеется в менеджере ARC32
- наличие собственных утилит для отладки запросов (выполнение SQL,
построение плана выполнения кверей, профайлер и т.п.), утилиты для
слежения за производительностью сервера - ARC32.

## Платформы

- на которых может работать сервер - Novell, Windows 9X, WinNT/2000, Linux
- на которых может работать клиент - MS DOS, Windows 9X, WinNT/2000, Linux

## Версии продуктов, краткая характеристика отличий

- Текущая весия 7.0, техническая поддержка оказывается для версий 6.xx
- Версия 5.0 - поддержка сервера на платформы WinNT(ранее был только Novell)
- Версия 5.5 - поддержка SQL
- Версия 5.7 - поддержка сервера на плптформе Win9x, поддержка транзакций
- Версия 6.0 - поддержка сервера и клиента на платформе Linux, работа в режиме Database, хранимые процедуры, поддерка ссылочной целостности.
- Версия 7.0 - триггера

## Способы доступа

- Advantage Client Engine API
- Advantage .NET Data Provider
- Advantage ODBC Driver (version 3)
- Advantage JDBC Driver (Type 4)
- Advantage OLE DB Provider
- Advantage Perl DBI Driver
- Advantage PHP Extension
- Advantage CA-Clipper RDD
- Advantage CA-Visual Objects RDDs
- Набор компонентов Advantage TDataSet Descendant for Delphi/Kylix/C++Builder
- языки программирования - Clipper, Delphi, C++Builder, Kylix, Microsoft
Visual Basic, Microsoft Visual C/C++, Java, Perl, Php, CA-Visual Objects

