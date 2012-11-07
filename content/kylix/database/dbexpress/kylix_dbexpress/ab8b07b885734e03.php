<h1>Kylix Tutorial. Часть 2. Работа с базами данных через dbExpress</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Mike Goblin</div>

<p>Фирма Borland в Kylix и Delphi 6 реализовала новый движок для работы с базой данных dbExpress. Данный движок предназначен для работы с серверными БД. На сегодняшний день поддерживаются MySQL, Oracle, Interbase, DB2. К сожалению, на момент выпуска Kylix он работал не со всеми версиями MySQL. В частности, он не заработал с MySQL 3.23.22-beta. За неимением Oracle и DB2 я пользовался Interbase 6, находившемся на втором диске дистрибутива.</p>

<p>Архитектура доступа к данным</p>
<p>  В самом виде приложение для работы с базами данных может быть представлено в следующем виде:</p>
<img src="/pic/clip0036.png" width="651" height="126" border="0" alt="clip0036"></p>

<p>Ничего принципиально нового здесь нет, по сравнению с Delphi. Но это только на первый взгляд. В dbExpress датасеты делятся на два вида:</p>
<p>    1. Клиентский датасет (client dataset)</p>
<p>    2. Однонаправленные датасеты (unidirectional dataset)</p>
<p>  Клиентский датасет хранит выбранные записи в памяти. Это позволяет осуществлять навигацию в любом направлении, фильтровать записи, кешировать изменения итд. Именно данный вид используется для отображения данных пользователю.</p>
<p>  Однонаправленные запросы не кешируют данные. Передвигаться по ним можно только в направлении указанном в конструкции ORDER BY SQL запроса, данные не могут быть изменены. Однако они предоставляют быстрый доступ к большим массивам записей.</p>

<p>Компоненты закладки dbExpress</p>
<p>  Посмотрим, что приготовила нам фирма Borland по части компонентов на закладке dbExpress</p>
<table border=1 cellspacing="0">
<tr><td align=center><B>Свойства</B></td><td align=center><B>Описание</B></td></tr>
<tr><td colspan=2 align=center bgcolor=#FFFFFF><B>SQLConnection</B></td></tr>
<tr><td colspan=2>Компонент для организации связи с сервером базы данных. Аналог Database в BDE. Позволяет управлять параметрами соединения с сервером БД, такие как путь к базе данных, имя и пароль пользователя итд.</td></tr>
<tr><td>Connected:boolean</td><td>Признак установления соединения с БД. True - соединение активно.</td></tr>
<tr><td>ConnectionName: string</td><td>Имя конфигурации, содержащей параметры соединения. Аналог AliasName в TDatabase для BDE</td></tr>
<tr><td>DriverName: string</td><td>Имя драйвера для соединения. (DB2, Interbase,Oracle, MySQL). Устанавливается автоматически при установке св-ва ConnectionName</td></tr>
<tr><td>KeepConnection: boolean</td><td>Поддерживать соединение с сервером БД, если в приложении нет активизированных датасетов.</td></tr>
<tr><td>LibraryName: string</td><td>Имя библиотеки, содержащей драйвер для связи с сервером БД</td></tr>
<tr><td>LoadParamsOnConnect: boolean</td><td>Загружать ли параметры соединения, ассоциированные с именем соединения, перед установкой соединения в run time. Полезно в случае когда параметры соединения могут быть изменены вне приложения или меняются в design time</td></tr>
<tr><td>LoginPrompt: Boolean</td><td>Запрашивать логин и пароль при соединении</td></tr>
<tr><td>Name: TComponentName</td><td>Имя компонента</td></tr>
<tr><td>Params: TStrings</td><td>Параметры соединения</td></tr>
<tr><td>TableScope: TTableScopes</td><td>Параметры видимости таблиц<BR>
TsSynonym - видеть синонимы<BR>
TsSysTable - видеть системные таблицы<BR>
TsTable - видеть таблицы<BR>
TsView - видеть просмотры</td></tr>
<tr><td>VendorLib: string</td><td>Имя библиотеки с клиентской частью БД</td></tr>
<tr><td colspan=2 align=center bgcolor=#FFFFFF><B>SQLDataSet</B></td></tr>
<tr><td colspan=2>Однонаправленный датасет общего назначения.</td></tr>
<tr><td>Active: boolean</td><td>Активность датасета</td></tr>
<tr><td>CommandText: string</td><td>Текст команды (запроса) на получение или манипуляции с данными</td></tr>
<tr><td>CommandType: TSQLCommandType</td><td>Тип датасета<BR>
CtQuery - SQL запрос<BR>
CtTable - таблица, автоматически генерируется запрос на выборку всех записей по всем полям<BR>
CtStoredProc - хранимая процедура</td></tr>
<tr><td>DataSource: TDataSource</td><td>Источник данных для мастер датасета</td></tr>
<tr><td>MaxBlobSize: integer</td><td>Максимальный размер BLOB полей</td></tr>
<tr><td>ObjectView: Boolean</td><td>Включить иерархическое представление для вложенных полей</td></tr>
<tr><td>ParamCheck:Boolean</td><td>Обновлять список параметров при изменении текста команды</td></tr>
<tr><td>Params:Tparams</td><td>Список параметров команды</td></tr>
<tr><td>SortFieldNames: string</td><td>Список полей для сортировки датасета, поля разделяются точкой с запятой. Действует для CommandType ctTable</td></tr>
<tr><td>SQLConnection: TSQLConnection</td><td>Имя компонента SQLConnection через который будет происходить работа с БД</td></tr>
<tr><td>Tag: integer</td><td>Тэг</td></tr>
<tr><td colspan=2 align=center bgcolor=#FFFFFF><B>SQLQuery</B></td></tr>
<tr><td colspan=2>Запрос к БД (однонаправленный)</td></tr>
<tr><td>Active: boolean</td><td>Активность запроса</td></tr>
<tr><td>DataSource: TDataSource</td><td>Источник данных для мастер датасета</td></tr>
<tr><td>MaxBlobSize: integer</td><td>Максимальный размер BLOB полей</td></tr>
<tr><td>ObjectView: Boolean</td><td>Включить иерархическое представление для вложенных полей</td></tr>
<tr><td>ParamCheck:Boolean</td><td>Обновлять список параметров при изменении текста запроса</td></tr>
<tr><td>Params:Tparams</td><td>Список параметров запроса</td></tr>
<tr><td>SQL:TStrings</td><td>Текст запроса</td></tr>
<tr><td>SQLConnection: TSQLConnection</td><td>Имя компонента SQLConnection через который будет происходить работа с БД</td></tr>
<tr><td>Tag: integer</td><td>Тэг</td></tr>
<tr><td colspan=2 align=center bgcolor=#FFFFFF><B>SQLStoredProc</B></td></tr>
<tr><td colspan=2>Хранимая процедура (в случае получения данных однонаправленная)</td></tr>
<tr><td>Active: boolean</td><td>Активность хранимой процедуры</td></tr>
<tr><td>MaxBlobSize: integer</td><td>Максимальный размер BLOB полей</td></tr>
<tr><td>ObjectView: Boolean</td><td>Включить иерархическое представление для вложенных полей</td></tr>
<tr><td>ParamCheck:Boolean</td><td>Обновлять список параметров при изменении процедуры</td></tr>
<tr><td>Params:Tparams</td><td>Список параметров процедуры</td></tr>
<tr><td>SQLConnection: TSQLConnection</td><td>Имя компонента SQLConnection через который будет происходить работа с БД</td></tr>
<tr><td>Tag: integer</td><td>Тэг</td></tr>
<tr><td colspan=2 align=center bgcolor=#FFFFFF><B>SQLTable</B></td></tr>
<tr><td colspan=2>Таблица базы данных (однонаправленный датасет)</td></tr>
<tr><td>Active: boolean</td><td>Активность таблицы</td></tr>
<tr><td>IndexFieldNames: string</td><td>Список полей сортировки (через точку с запятой)</td></tr>
<tr><td>IndexName: string</td><td>Имя индекса сортировки. Возможно использование либо IndexName или IndexFieldNames</td></tr>
<tr><td>MasterSource: TdataSource</td><td>Мастер источник данных для организации отношений главный-подчиненный (master-detail)</td></tr>
<tr><td>MasterFields:string</td><td>Поля связи главный-подчиненный</td></tr>
<tr><td>MaxBlobSize: integer</td><td>Максимальный размер BLOB полей</td></tr>
<tr><td>ObjectView: Boolean</td><td>Включить иерархическое представление для вложенных полей</td></tr>
<tr><td>SQLConnection: TSQLConnection</td><td>Имя компонента SQLConnection через который будет происходить работа с БД</td></tr>
<tr><td>TableName: string</td><td>Имя таблицы БД из которой будут выбраны данные</td></tr>
<tr><td>Tag: integer</td><td>Тэг</td></tr>
<tr><td colspan=2 align=center bgcolor=#FFFFFF><B>SQLMonitor</B></td></tr>
<tr><td colspan=2>Организация наблюдения за работой компонентов доступа к данным</td></tr>
<tr><td>Active: boolean</td><td>Активность монитора</td></tr>
<tr><td>AutoSave: Boolean</td><td>Автоматическое сохранения журнала событий в файл, указанный в FileName</td></tr>
<tr><td>FileName: string</td><td>Имя файла для хранения журнала событий</td></tr>
<tr><td>SQLConnection: TSQLConnection</td><td>Имя компонента SQLConnection через который будет происходить работа с БД</td></tr>
<tr><td>Tag: integer</td><td>Тэг</td></tr>
<tr><td>TraceList:Tstrings</td><td>Журнал событий</td></tr>
<tr><td colspan=2 align=center bgcolor=#FFFFFF><B>SQLClientDataSet</B></td></tr>
<tr><td colspan=2>Клиентский датасет общего назначения</td></tr>
<tr><td>Active: boolean</td><td>Активность датасета</td></tr>
<tr><td>Aggregates: Taggregates</td><td>Список доступных агрегатов</td></tr>
<tr><td>AggregatesActive: boolean</td><td>Вычисление агрегатов</td></tr>
<tr><td>AutoCalcFields: boolean</td><td>Генерировать событие OnCalcFields и обновлять Lookup поля True -<BR>
· при открытии датасета<BR>
· при переходе датасета в состояни dsEdit<BR>
· Передача фокуса ввода другому компоненту или другому столбцу (для сетки) при наличии изменений в текущей ячейке<BR>
False<BR>
· при открытии датасета<BR>
· при переходе датасета в состояни dsEdit<BR>
· Запись извлекается из БД</td></tr>
<tr><td>CommandText: string</td><td>Текст команды для выполнения (SQL запрос). При установке св-ва FileName данное св-во игнорируется При сбросе флага poAllowCommandText в св-ве Options также текст команды игнорируется</td></tr>
<tr><td>CommandType: TSQLCommandType</td><td>Тип датасета<BR>
CtQuery - SQL запрос<BR>
CtTable - таблица, автоматически генерируется запрос на выборку всех записей по всем полям<BR>
CtStoredProc - хранимая процедура</td></tr>
<tr><td>ConnectionName: string</td><td>Имя конфигурации, содержащей параметры соединения. Аналог AliasName в TDatabase для BDE</td></tr>
<tr><td>Constraints: TConstraints</td><td>Ограничения на значения на уровне одной записи</td></tr>
<tr><td>DBConnection: TSQLConnection</td><td>Имя компонента SQLConnection через который будет происходить работа с БД</td></tr>
<tr><td>DisableStringTrim: boolean</td><td>Удалять конечные пробелы в строковых полях при их вставке  БД</td></tr>
<tr><td>FetchOnDemand: boolean</td><td>Получать данные по мере необходимости</td></tr>
<tr><td>FieldDefs: TFieldDefs</td><td>Определения полей</td></tr>
<tr><td>FileName: string</td><td>Имя файла для сохранения кеша данных</td></tr>
<tr><td>Filter: string</td><td>Фильтр</td></tr>
<tr><td>Filtered: Boolean</td><td>Включение фильтрации</td></tr>
<tr><td>FilterOptions: TFilterOptions</td><td>Параметры фильтрации</td></tr>
<tr><td>IndexDefs: TindexDefs</td><td>Определения индексов</td></tr>
<tr><td>IndexFieldNames: string</td><td>Список полей сортировки (через точку с запятой)</td></tr>
<tr><td>IndexName: string</td><td>Имя индекса сортировки. Возможно использование либо IndexName либо IndexFieldNames</td></tr>
<tr><td>MasterSource: TdataSource</td><td>Мастер источник данных для организации отношений главный-подчиненный (master-detail)</td></tr>
<tr><td>MasterFields:string</td><td>Поля связи главный-подчиненный</td></tr>
<tr><td>ObjectView: Boolean</td><td>Включить иерархическое представление для вложенных полей</td></tr>
<tr><td>Options: TProviderOptions</td><td>Параметры работы с данными</td></tr>
<tr><td>PacketRecord: integer</td><td>Количество записей в одном пакете данных<BR>
-1 - все<BR>
>0 - количество<BR>
0 - включать в пакет только метаданные</td></tr>
<tr><td>Params: Tparams</td><td>Значение параметров для выборки данных</td></tr>
<tr><td>ReadOnly: Boolean</td><td>Доступ только для чтения</td></tr>
<tr><td>Tag: integer</td><td>Тэг</td></tr>
<tr><td>UpdateMode: TUpdateMode</td><td>Способ поиска записи при записи изменений<BR>
UpWhereAll - использовать все поля<BR>
UpWhereChanged - ключевые поля+старые значения измененных полей<BR>
UpWhereKeyOnly - только ключевые поля</td></tr>
</table>
<p>Попробуем написать простейшее приложение для просмотра данных из базы в /usr/ibdb (будем считать что папка уже создана). Для этого выполним следующие шаги:</p>

<p>1. Создадим базу данных в Interbase 6. У меня он проинсталировался в /opt/interbase .</p>
<p>1.1 Запустим сервер /opt/interbase/bin/ibguard &amp;</p>
<p>1.2 Войдем в оболочку isql - /opt/interbase/bin/isql</p>
<p>1.3 Введем SQL запросы на создание БД и таблицы users:</p>
<pre>create database '/usr/ibdb/test.gdb';
create table users( ID integer not null primary key, NAME varchar(20));
commit;
quit;
 
</pre>

<p>Если все выполнено правильно - то в папке /usr/ibdb появится файл test.gdb.</p>
<p>2. Создадим новое приложение. Меню File/NewApplication в IDE Kylix</p>
<p>3. На главной форме приложения разместим с закладки dbExpress компоненты: SQLConnection и SQLDataSet. SQLConnection - это "соедиение" с базой данных, т.е с его помощью можно управлять параметрами соединения, такими как тип драйвера, имя пользователя и пароль. Двойной щелчок левой кнопкой мыши на SQLConnection1 вызовет окно работы с соединениями.</p>
<p>Name - test_connect. После добавления установим следующие параметры:</p>
<p>  Database - /usr/ibdb/test.gdb</p>
<p>  ServerCharSet - win1251</p>
<p>  Кнопкой "ОК" закроем диалог. Свойство Connected установим в True. В диалоге запроса пароля введем пароль masterkey. Соединение установлено.</p>
<p>  Компонент SQLClientDataSet1 будет извлекать данные из таблицы users. Почему мы используем его а не SQLQuery? Ответ очень прост - SQLQuery - однонаправленный датасет. Поэтому он не может обеспечить навигации в обе стороны и редактирование данных.</p>
<p>  Свойство DBConnection компонента SQLClientDataSet1 установим равным SQLConnection1. Введем запрос на выборку данных из таблицы users - select * from users - в св-во CommandText, либо воспользуемся диалогом для данного св-ва. Активизируем запрос, установив св-во Active в True.</p>
<p>  Далее с закладки Data Access на форму положим компонент TDataSource. Данный компонент делает данные из датасетов доступными для отображения в пользовательских элементах управления (сетках итд). Его св-во DataSet установим в ClientDataSet1.</p>
<p>  Перейдем на закладку DataControls и с нее разместим на форме сетку данных DBGrid и DBNavigator. Для обоих компонентов св-во DataSource установим в DataSource1. При этом в DBGrid1 появится заголовок с наименованиями полей таблицы users.</p>

<p>Теперь можно запустить приложение на выполнение (F9 однака).</p>

<p>Взято с сайта <a href="https://www.delphimaster.ru/" target="_blank">https://www.delphimaster.ru/</a></p>

<p> с разрешения автора.</p>

