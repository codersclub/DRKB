---
Title: Работа с клиентскими наборами данных (DBExpress)
Author: Mike Goblin
Date: 01.01.2007
Source: <https://www.delphimaster.ru/>
---


Работа с клиентскими наборами данных (DBExpress)
================================================

**Введение**

В данной части будет рассмотрено применение клиентских наборов данных в
dbExpress. Согласно иерархии классов в Kylix к клиентским наборам данных
относятся классы TSQLClientDataSet и TClientDataSet. Последний из них
является частью технологии MIDAS. Так как на сегодняшний день поддержка
данной технологии в Kylix до конца не реализована, то основное внимание
мы уделим рассмотрению TSQLClientDataSet.

Компоненты класса TSQLClientDataSet предназначены для создания
двухзвенных приложений клиент сервер. Так же как и однонаправленные
наборы данных, они используются для работы с сервером БД через
TSQLConnection. С другой стороны многие из методов и событий класса
TSQLClientDataSet характерны для клиентского датасета в технологии
MIDAS. На самом деле TSQLClientDataSet - это гибрид, содержащий в себе
объекты однонаправленного набора данных, клиентский набор данных и
объект провайдера для применения внесенных изменений на сервере БД.
"Запихивание под капот" этих объектов позволило существенно упростить
разработку двухзвенных приложений баз данных в dbExpress.

**Простейший проект**

Работа с TSQLClientDataSet будет проиллюстрирована на примере простой
базы данных служащих организации. В качестве сервера БД выбран Interbase
6, т.к он входит в поставку Kylix. Предварительно необходимо создать
базу данных с таблицей EMPLOYEERS, описанной следующим образом:

    /* Table: EMPLOYEERS, Owner: SYSDBA */
    CREATE TABLE "EMPLOYEERS" 
    (
      "ID"        INTEGER NOT NULL,
      "NAME"        VARCHAR(200) NOT NULL,
     PRIMARY KEY ("ID")
    );
    СREATE GENERATOR "EMP_GEN";
    SET TERM ^ ;
    /* Triggers only will work for SQL triggers */
    CREATE TRIGGER "EMPLOYEERS_BEFORE_INS" FOR "EMPLOYEERS" 
    ACTIVE BEFORE INSERT POSITION 0
    AS
            BEGIN
              NEW.ID = GEN_ID(EMP_GEN,1);
            END
     ^
    COMMIT WORK ^
    SET TERM ;^

Вставим несколько записей в созданную таблицу. Текст запроса на вставку
в таблицу выглядит так:

    Insert into Employeers (Name) values 'Петров';
    Insert into Employeers (Name) values 'Сидоров';

Далее запустим IDE Kylix и создадим новое приложение. На главной форме
приложения разместим следующие компоненты с закладки dbExpress и
установим для них нижеуказанные свойства:

`sc_conn:TDBConnection`
: настроить для соединения с созданной БД. (как
это сделать см. "Коннект - есть коннект"). Свойство Connected -
установить true.

`scd_emp:TSQLClientDataSet`
: DBConnection - sc_conn  
  CommandText - select ID,NAME from EMPLOYEES

Двойным кликом мыши вызовем редактор полей. В редакторе полей правой
кнопкой мыши вызовем всплывающее меню и в нем выберем пункт Add all
fields. При этом поля набора данных будут определены явным образом.
Выберем поле ID и установим его свойство Required в false, чтобы снять
необходимость ручного ввода значения ID при вставке пользователем новой
записи. После этого свойство Connected компонента sc\_conn установим в
false.

`ds_src:TDataSource`
: DataSet:scd_emp

`DBNavigator1:TDBNavigator`
: DataSource - ds_src  
  Align - alTop

`Panel1:TPanel`
: Align - alBottom  
  Caption - "" (пустая строка)

`DBGrid1:TDBGrid`
: DataSource - ds\_src
  Align - alTop

На Panel1 разместим 4(Button) кнопки c именами b\_connect,
b\_disconnect, b\_count, b\_fetch (заголовки - Caption - connect,
disconnect, get count, fetch all соответсвтенно )и одну надпись (Label).
На событие onClick кнопки b\_connect навесим обработчик со следующим
кодом:

    Sc_conn.Connected:=true;
    Scd_emp.Active :=true;

На событие onClick кнопки b\_disconnect навесим обработчик со следующим
кодом:

    Sc_conn.Connected:=false;
    Scd_emp.Active :=false;

Назначение размещенных компонентов следующее:

`Sc_conn` - соединение с базой данных;  
`Sc_emp` - набор данных для работы с таблицей БД employers;  
`Ds_src` - представление данных sc\_emp для компонентов пользовательского
интерфейса "чувствительных" к данным.

Запустим на выполнение наш проект, при этом предполагается, что сервер
interbase уже запущен. При нажатии кнопки b\_connect в сетке данных
(DBGrid) можно будет видеть записи таблицы employeers.

**Навигация по записям**

Методы навигации по записям аналогичны однонаправленным наборам данных.

**Добавление, удаление и редактирование записей**

Для добавления записей существуют четыре метода:

- Append - Добавление пустой записи в конец набора данных. Курсор
помещается на добавленную запись и набор данных переходит в режим
редактирования

- Insert - Добавление пустой записи в текущую позицию набора данных.
Курсор помещается на добавленную запись и набор данных переходит в режим
редактирования.

- AppendRecord(const Values: array of const)  - Добавление записи в конец
набора данных. Поля передаются через параметр Values

- InsertRecord(const Values: array of const) Добавление записи в текущую
позицию набора данных. Поля передаются через параметр Values

Примеры добавления записей:

    // Использование Append
    scd_emp.Append;
    scd_emp.FieldByName('ID').Value:=-1;
    scd_emp.FieldByName('Name').Value:='Петров';
    scd_emp.Post;

    // Использование AppendRecord
    scd_emp.AppendRecord([1,'Петров'];

Определены несколько событий, связанных с вставкой новой записи

- BeforeInsert - Событие, генерируемое перед вставкой новой записи в набор
данных.

- AfterInsert - Событие, генерируемое после вставкой новой записи в набор
данных

- OnNewRecord - Событие, генерируемое при вставке новой записи в набор
данных 

При необходимости отменить вставку записи, внутри обработчика события
можно вызвать метод Abort.

**Порядок вызова событий**

События `BeforeEdit` и `AfterEdit` возникают соответственно перед и после
редактирования записи.

Событие `OnNewRecord` возникает при вставке новой записи в набор данных.

Для удаления текущей записи предназначен метод `Delete`, события
`BeforeDelete` и `AfterDelete` генерируются до и после удаления записи
соответственно.

Пример:

    scd_emp.Delete;

Перевод набора данных в режим редактирования осуществляется вызовом
метода `Edit`. При этом проверить доступность редактирования можно,
проанализировав свойство `CanModify`.

Еще одним полезным методом является
метод `CheckBrowseMode`. Данный метод автоматически подтверждает или
отменяет сделанные изменения перед тем, как будет осуществлен переход на
следующую запись в наборе данных.

**Подтверждение и откат сделанных изменений**

Так как клиентский набор данных буферизирует сделанные изменения, то
применяется двухступенчатое подтверждение сделанных изменений. Первая
ступень - это запись сделанных изменений в буфер набора данных, вторая -
запись изменений из буфера в сервер БД.

Запись изменений в буфер осуществляется вызовом метода `Post`. События
`BeforePost` и `AfterPost` генерируются перед и после подтверждения
изменений. Многие из компонентов пользовательского интерфейса для работы
с данными вызывают метод Post автоматически при переходе на следующую
запись набора данных.

Отмена записи в буфер набора данных осуществляется вызовом метода
`Cancel`. События `BeforeCancel` и `AfterCancel` генерируются перед и после
подтверждения изменений.

Изменения, сделанные в буфере, SQLClientDataSet хранит в свойстве `Delta`.
Количество изменений хранится в свойстве `ChangeCount`. Запись сделанных
изменений из буфера в БД осуществляется вызовом `ApplyUpdates`. В качестве
параметра функции передается максимальное количество ошибок, допустимых
до завершения метода. Функция возвращает количество возникших ошибок.
Если в результате применения изменений количество ошибок не превысило
заданного, то успешно переданные записи удаляются из свойства `Delta` (т.е
считаются переданными на сервер БД), иначе все записи считаются не
переданными.

Пример:

    // Передача изменений из буфера в БД
    if scd_emp.ChargeCount > 0 then
      if scd_emp.ApplyUpdates(10) > 0 then
        Application.MessageBox('Обнаружены ошибки');

При вызове `ApplyUpdates` SQLClientDataSet генерирует набор SQL операторов
для передачи каждой вставленной, удаленной и измененной записи в БД.

При передаче изменений на сервер БД возникает задача определения
соответствия измененной записи из буфера набора данных и записи в БД
(т.е формирования части where SQL запроса). Свойство `UpdateMode`
определяет данный критерий. Возможные значения свойства приведены ниже:

- `upWhereAll` - для поиска применяется вся совокупность полей набора -
режим по умолчанию

- `upWhereChanged` - только поля, отмеченные как ключевые и поля содержащие
изменения применяются для поиска.

- `UpWhereKeyOnly` - только поля, отмеченные как ключевые, применяются для
поиска. Поля набора данных имеют свойство ProviderFlags, определяющее
поведение поля при формировании текста запроса. Могут быть установлены
следующие флаги:

- `pfInUpdate` - поле включается в SQL предложение UPDATE - т.е может быть
обновлено

- `pfInWhere` - поле включается в в SQL предложение Where в режиме
обновления upWhereAll или upWhereChanged

- `pfInKey` - поле включается в в SQL предложение Where в режиме обновления
`UpWhereKeyOnly`

- `pfHidden` - Поле включается в пакет данных для обеспечения уникальности
записи, оно не может использоваться набором данных.

Наличие события `OnUpdateData` позволяет установить параметры обновления
для каждой записи, передаваемой на сервер БД.

Откат всех сделанных изменений осуществляется с помощью метода
`CancelUpdates`. Данный метод очищает свойство `Delta`, таким образом, отменяя
все изменения в буфере набора данных.

Откат последней выполненной операции выполняется вызовом `UndoLastChange`.
Передача True в качестве параметра метода `UndoLastChange` заставляет
курсор перемещаться на откатываемую запись.

Но и это еще не все! Можно откатывать назад на произвольное количество
операций (здесь под операцией понимается вставка, редактирование,
удаление). Для этого существуют так называемые точки сохранения
(`SavePoint`).

Техника такая:

1. Сохраняем точку. `SP:=Client.SavePoint;` (здесь SP:integer)

2. Делаем все, что заблагорассудится - вставка, удаление, редактирование

3. Восстанавливаем `Client.SavePoint:=SP;` и как будто ничего не было :))

Если немного помозговать, то используя точки сохранения, можно
организовать не только Undo, но и Redo.

Осталось внести некоторые доработки в наш проект, чтобы сделанные
изменения были отправлены на сервер БД. Для этого выполним следующие
действия:

1. Объявим глобальную переменную id типа integer. Делается это в секции
var модуля главной формы, данная секция будет выглядеть так

        var
          Form1:Tform1;
        Id:integer; // Счетчик для поля id, объявленный нами

2. В обработчике события AfterPost scd\_emp инициализируем переменную id

        id:=-1;

3. В обработчике BeforePost scd\_emp используем id для заполнения поля
id фиктивным значением (реально значение присваивается на сервере).

        If scd_empID.IsNull then
          Begin
            Scd_empID.Value:=id;
            Dec(id);
          End;
     
4. В обработчике события BeforeRefresh scd_emp организуем отправку данных на сервер. 

        if scd_emp.ChangeCount > 0 then
          if scd_emp.ApplyUpdates(0) > 0 then
            Abort
          else
            id:=-1;

Запустим полученное приложение, попробуем вводить или изменять записи -
до нажатия кнопки обновления DBNavigator1 все наши изменения не будут
отражаться на сервере БД. Закрытие приложения с изменениями, не
отправленными на сервер, приводят к потере этих изменений.

**Обработка ошибок**

Обработка ошибок также делится на обработку ошибок работы с буфером и
обработку ошибок передачи данных на сервер БД. Для обработки ошибок
вставки, удаления и редактирования в компоненте TSQLDataSet существуют
несколько видов событий:

- OnDeleteError - Возникает при наличии ошибок удаления записи 
- OnEditError - Возникает при наличии ошибок редактирования или вставки записи 
- OnPostError - Возникает при наличии ошибок записи сделанных изменений в
  буфер клиентского набора данных 

Обработчики вышеперечисленных событий в качестве одного из параметров
получают параметр `Action` типа `TDataAction`. Изменяя значение этого
параметра в обработчике можно варьировать реакцию на произошедшую
ошибку. Возможные значения:

- daFail - прервать операцию и выдать сообщение об ошибке (поведение по
умолчанию)

- daAbort - прервать операцию без выдачи сообщения об ошибке

- daRetry - повторить попытку, предполагается, что обработчик события
предварительно пытается скорректировать запись, вызвавшую ошибку.

**Клонирование таблицы**

Описано далее в разделе "Работа с локальными базами данных в Kylix".

**Работа с локальными базами данных в Kylix**

Под локальными мы будем понимать базы данных, файлы которых расположены
в файлах на локальном диске компьютера или в локальной сети. Доступ к
этим файлам осуществляется приложением напрямую.

В Delphi 5, продолжателем которой является Kylix, для работы с
локальными базами данных использовалось несколько подходов.

Использование библиотек BDE, ADO, ODBC для доступа к локальным базам
формата DBase, Paradox.

Использование TСlientDataSet для работы с локальными базами данных
формата cds или xml. Форматы данных файлов являются изобретением
Borland.

В Kylix разработка компонентов для создания локальных баз данных первого
типа отдана на откуп разработчикам сторонних фирм. Связано это прежде
всего с тем, что данные форматы данных являются отмирающими, тем более
что конвертировние их в формат xml не вызывает больших затруднений.

Второй тип баз данных, получивший наименование MyBase, предоставляет
дополнительные возможности, такие как:

- Возможность сортировки данных по полям без создания дополнительных
файлов индексов.
- Возможность ведения списка изменений и отката сделанных изменений
- Возможность создания агрегатов на основе данных таблицы.
- Возможность совместного использования одних и тех же данных несколькими
датасетами.
- Совместимость с Delphi5 (не говоря уже о Delphi 6)

Для иллюстрации всего вышесказанного создадим приложение для просмотра и
редактирования заказов.

1. Создание заготовки приложения.

    Меню File/New Application создаст проект
с пустой формой. Добавим модуль данных - File/New. В открывшемся диалоге
выбрать пункт DataModule.

2. Создание файла базы данных.

    В модуль данных поместим компонент
ClientDataSet с закладки DataAccess. Свойство Name установим - Clients.
Данный датасет будет хранить информацию о заказчиках. Для создания файла
базы данных необходимо указать поля и их типы. Сделать это можно двумя
способами:

    - Определить FieldDefs
    - Создать объекты полей явным образом.

    Лично я предпочитаю определить FieldDefs, а затем на их основе создать
    объекты полей :))

3. Итак, двойной клик на свойстве FieldDefs компонента Clients откроет диалог
работы с определениями полей. Добавим следующие определения полей

        ID ftAutoInc 0
        Name ftString 50

4. Правой кнопкой мышки кликнем на Clients и выберем в выпадающем меню
пункт CreateDataSet, а затем Save To MyBase Xml UTF-8 table. В
появившемся диалоге укажем имя xml файла, который будет хранить данные о
клиентах - Clients.xml.

5. Было бы неплохо, чтобы при старте программы ClientDataSet читал данные
из созданного нами xml файла. Для этого свойство FileName должно быть равно
полному имени (с путем) xml файла. Для Clients это /путь к
файлу/Clients.xml.

6. Теперь определим поля явно на основе FieldDefs. Двойной клик на Clients,
в диалоге правой кнопкой мыши вызываем контекстное меню, выбираем пункт
Add all fields. Затем DataSource - ds\_Clients, разместим в модуле
данных и свяжем c Clients (свойство DataSet компонента ds\_Clients
установим равным Clients).

**Формат xml таблицы БД, откат изменений**

Посмотрим, как внутри устроен xml файл базы данных. После создания
датасета типичный файл БД выглядит так:

    <?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
    <DATAPACKET Version="2.0">
      <METADATA>
        <FIELDS>
          <FIELD attrname="ID" fieldtype="i4" readonly="true" SUBTYPE="Autoinc" />
          <FIELD attrname="Name" fieldtype="string" WIDTH="50" />
        </FIELDS>
        <PARAMS DEFAULT_ORDER="" AUTOINCVALUE="1" />
      </METADATA>
      <ROWDATA />
    </DATAPACKET>

Строка 1: `<?xml version="1.0" encoding="UTF-8" standalone="yes"?>`

В строке 1 расположен заголовочный тэг.

Строка 2: `<DATAPACKET Version="2.0">`

Корневой тэг документа, а вот дальше и начинаются теги, на которые стоит
обратить внимание, в частности на строки 3 и 10.

Строка 3: `<METADATA>`

Строка 10: `<ROWDATA />`

Так вот всю таблицу можно разделить на две части: данные о структуре
таблицы БД, хранимые в файле (метаданные) и собственно сами записи. Как
вы уже догадались, метаданные хранятся в теге METADATA, а записи в
ROWDATA, естественно что при создании новой таблицы БД тег ROWDATA будет
пустым.

Внутри тэга METADATA расположены описания полей таблицы (тег FIELDS и
вложенные в него теги) и другая служебная информация (порядок сортировки
по умолчанию, начальное значение автоинкрементального счетчика).

Теперь давайте запустим наше приложение, вставим в таблицу новую запись,
закроем приложение и посмотрим как изменился xml файл.

Изменился тег PARAMS, теперь он выглядит так:

    <PARAMS CHANGE_LOG="1 0 4" AUTOINCVALUE="2" DEFAULT_ORDER=""/>

и тег ROWDATA стал непустым:

    <ROWDATA>
      <ROW RowState="4" ID="1" Name="Иван" />
    </ROWDATA>

Внимательно посмотрев, на изменения мы увидим, что внутри таблицы
ведется журнал операций. Это дает возможность отката сделанных
изменений. Подробнее это описано выше для SQLClientDataSet. Добавим, что
вызов метода MergeChangeLog делает все изменения, сделанные до его
вызова недоступными для отката, т.е очищает журнал действий.

Если же Вам совсем не нужно, чтобы журнал велся, в runtime установите
свойство `LogChanges := false`.

Обработка ошибок, могущих возникать при описанных действиях аналогична
случаю описанному для SQLClientDataSet.

**Клонирование таблицы**

Поскольку TClientDataSet держит данные из таблицы в памяти, появилась
возможность совместного использования одних данных двумя датасетами.
Клонирование осуществляется вызовом метода CloneCursor

    Procedure CloneCursor(Source:TCustomClientDataSet;
                          Reset:Boolean;
                          KeepSettings:Boolean = false)

Параметр `Source` - источник клонированных данных.

Параметры `Reset` и `KeepSettings` определяют установку свойств фильтров,
индексы, Read Only, MasterSource, MasterFields.

Когда оба параметра `false`, то указанные свойства копируются из датасета-источника,
если `Reset:=true` - данные свойства сбрасываются,
если `KeepSettings:=true` - остаются без изменений,
при этом совместимость их с данными источника клонирования остается на
совести программиста.

**Установка отношений главный - подчиненный (master-detail)**

Первый из способов - это задание свойств MasterSource и MasterFields. Этот
способ традиционен еще в Delphi и мы рассматривать его тут не будем -
читайте книжки.

Новым способом организации отношения master-detail стало использование
вложенных датасетов. Вот об этом и пойдет речь. Допустим мы хотим иметь
информацию о покупках сделанных клиентом.

Сначала очистим датасет Clients - щелкнем правой кнопкой мыши и в
контекстном меню выберем - Clear Data.

Введем дополнительное FieldDefs Orders - типа ftDataSet. Данный тип поля
предназначен для хранения внутри себя датасетов. Набор полей вложенного
датасета определяется в свойсвте ChildDefs. Определим в ChildDefs
следующие поля Имя (Name) Тип(Type) Размер(Size)

    ID FtAutoInc 0
    OrderName ftString 20
    Price ftCurrency 0

ID - счетчик, OrderName - описание заказа, Price - цена заказа.

Осталось только создать на основе созданных определений создать датасет
(щелкнув правой кнопкой и выбрав Create DataSet), сохранить в файл (Save
to MyBase xml table) и на основе этих определений явно создать поля
(двойной клик на Clients, правая кнопка мыши - add all fields).
Открыв созданный xml файл мы увидим следующее:

    <?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
    <DATAPACKET Version="2.0">
      <METADATA>
        <FIELDS>
          <FIELD attrname="ID" fieldtype="i4" readonly="true" SUBTYPE="Autoinc" />
          <FIELD attrname="Name" fieldtype="string" WIDTH="50" />
          <FIELD attrname="Orders" fieldtype="nested">
            <FIELDS>
              <FIELD attrname="ID" fieldtype="i4" SUBTYPE="Autoinc" />
              <FIELD attrname="OrderName" fieldtype="string" WIDTH="20" />
              <FIELD attrname="Price" fieldtype="r8" SUBTYPE="Money" />
            </FIELDS>
            <PARAMS AUTOINCVALUE="1" />
          </FIELD>
        </FIELDS>
        <PARAMS DEFAULT_ORDER="" AUTOINCVALUE="1" />
      </METADATA>
      <ROWDATA />
    </DATAPACKET>

Нетрудно убедиться в том, что поле Orders содержит в себе описание
подчиненной таблицы. При этом в сетке данных DBGrid1, расположенной на
главной форме, появился новый столбец Orders. При запуске приложения и
попытке редактирования этого поля автоматически открывается форма для
редактирования вложенного набора данных.

Другим способом организации взаимодействия с вложенным датасетом
является размещение в модуле данных дополнительного ClientDataSet.
Поместим в модуль данных еще один компонент типа TClientDataSet,
установив его имя Orders. Свойству DataSetField компонента Orders из
выпадающего списка присвоим значение ClientsOrders. Все теперь пользуясь
компонентом Orders можно просматривать и редактировать вложенный
датасет.

Достоинства вышеописанного метода в том, что вся база будет храниться в
одном xml файле, недостаток же - нельзя разорвать связь
главный-подчиненный и как следствие одновременно просмотреть все записи
о заказах вне зависимости от выбранного клиента.

--  
Взято с сайта <https://www.delphimaster.ru/>
с разрешения автора.
