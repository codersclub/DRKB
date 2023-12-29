---
Title: Как открыть базу данных Microsoft Access .MDB в Delphi?
Date: 01.01.2007
---


Как открыть базу данных Microsoft Access .MDB в Delphi?
=======================================================

::: {.date}
01.01.2007
:::

ADO

Если у Вас Delphi 5 Enterprise или Delphi 5 Professional с ADO Express,
то Вы можете использовать компонент ADOTable и в его свойстве
ConnectionString настроить (build) подключение как базе данных MS
Access. Например:

    Provider=Microsoft.Jet.OLEDB.4.0;
    User ID=Admin;
    Password=Password;
    Data Source=D:\Path\dbname.mdb;
    Mode=ReadWrite;
    Extended Properties="";
    Persist Security Info=False;
    Jet OLEDB:System database="";
    Jet OLEDB:Registry Path="";
    Jet OLEDB:Database Password="";
    Jet OLEDB:Engine Type=5;
    Jet OLEDB:Database Locking Mode=1;
    Jet OLEDB:Global Partial Bulk Ops=2;
    Jet OLEDB:Global Bulk Transactions=1;
    Jet OLEDB:New Database Password="";
    Jet OLEDB:Create System Database=False;
    Jet OLEDB:Encrypt Database=False;
    Jet OLEDB:Don't Copy Locale on Compact=False;
    Jet OLEDB:Compact Without Replica Repair=True;
    Jet OLEDB:SFP=False

При этом будет открыта база данных D:\\Path\\dbname.mdb, будет
использован драйвер ADO для базы данных Access
(Microsoft.Jet.OLEDB.4.0). Имя пользователя будет Admin без пароля (эти
значения присваиваются поумолчанию при создании базы Access). Если Вы
всё-таки захотите использовать пароль, то его надо будет задать в
ствойстве Jet OLEDB:Database Password. Если у Вас установлен режим
безопасности, то необходимо указать файл .MDW или .MDA в свойстве Jet
OLEDB:System database.

BDE

Так же для открытия базы данных Access можно воспользоваться BDE которая
содержит родной драйвер (MSACCESS). В компоненте Database установите
следующие свойства:

DatabaseName = Any\_name (или Alias\_name)

DriverName   = MSACCESS

LoginPrompt  = False

Params       = PATH=d:\\path

              DATABASE NAME=d:\\path\\filename.mdb

              TRACE MODE=0

              LANGDRIVER=Access General

              USER NAME=Admin

              PASSWORD=your\_password

              Open/MODE=Read/Write

              SQLPASSTHRU MODE=Not SHARED

Значения свойства DatabaseName объекта Database, это то, которое Вы
будете использовать в свойстве DatabaseName компонентов Table и Query,
которые представляют таблицы и запросы для этой базы данных (тем самым
связывая их с объектом Database).

BDE+ODBC

В случае с базой данных Access, BDE предоставляет драйвер, однако
существует множество других баз, для которых в BDE драйвера нет, но для
которых есть драйвер ODBC. ODBC обычно используется для небольших баз
данных или в приложениях, в которых присутствуют только операции
импорта/экспорта...

Ниже приведён пример использования драйвера ODBC с BDE для открытия базы
данных Access:

Создайте DSN (Data Source Name) для Вашей базы данных (используя апплет
ODBC Data Sources в панели управления).

Кликните на закладку "System DSN" или "User DSN"

Кликните по кнопке "Add..."

Выберите "Microsoft Access Driver (*.mdb)" и нажмите ENTER. Появится
диалоговое окошко "ODBC Microsoft Access Setup".

Задайте имя в текстовом окошке Data Source Name (без пробелов и без
специальных символов).

Кликните по кнопке "Select..." чтобы выбрать нужный файл .MDB.

Если у Вас установлена схема безопасноти, то выберите радио кнопку
"Database" в "System Database", а затем кликните кнопку "System
database...", чтобы указать файл рабочей группы .MDW или .MDA.

Если Вы хотите указать имя пользователя и пароль, то нажмите кнопку
"Advanced...". Данный способ защиты является низкоуровневым, так как
любой, кто имеет доступ к Вашей машине может спокойно посмотреть
свойства DSN. Если Вам необходим более высокий уровень защиты, то
задавать имя пользователя и пароль необходимо на стадии открытия базы
данных (см. ниже).

В заключении нажмите "OK", после чего Ваш DSN будет сохранён.

В Delphi установите свойства компонента TDatabase:

В DatabaseName задайте имя, которое указали в DSN.

Если Вы хотите, чтобы пользователя спрашивали имя и пароль, то
установите LoginPrompt в True.

Если Вы не хотите использовать стандартный диалог имени и пароля (или
если имя и пароль будут задаваться программно), то установите
LoginPrompt в False и задайте свойство Params (или задайте эти свойства
по ходу выполнения программы):

USER NAME=your\_username

PASSWORD=your\_password

Свяжите компоненты TTable или TQuery с компонентом TDatabase, как
рассказывалось Выше, просто указав тоже имя (которое было задано в DSN)
в их соответствующих свойствах DatabaseName.

Взято из <https://forum.sources.ru>
