---
Title: Из Paradox в Access при помощи ADO
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Из Paradox в Access при помощи ADO
==================================

(Перевод одноимённой статьи с сайта delphi.about.com )

В данной статье мы обратим внимание на компонент TADOCommand и
использование языка SQL DDL (Data Definition Language), с целью помочь
Вам с проблемой переноса данных BDE/Paradox в ADO/Access.

**Язык определения данных (Data Definition Language)**

Не многие программисты создают базу данных программным путём,
большинство из нас для этого используют некую визуальную среду наподобие
MS Access для построения файла MDB. Но иногда нам всё таки приходится
создавать и удалять базу данных, а так же объекты базы данных
программным путём. Для этого используется наиболее распространённая на
сегодняшний день технология Structured Query Language Data Definition
Language (SQL DDL). Выраджения языка определения данных (DDL) - это SQL
выражения, которые поддерживают определения или объявления объектов базы
данных (например, CREATE TABLE, DROP TABLE, CREATE INDEX либо подобные
им).

В рамки данной статьи не входит детальное ознакомление с языком DDL.
Если Вы знакомы с языком SQL DML (Data Manipulation Language - это
выражения типа SELECT, UPDATE и DELETE), то DDL не будет для Вас
серьёзным барьером. Обратите внимание, что работа с DDL может быть
весьма ухищрённой, так как каждый производитель базы данных може
включать в неё собственные расширения для SQL.

Давайте взглянем на простейший пример выражения CREATE TABLE:

    CREATE TABLE PhoneBook(
      Name TEXT(50)
      Tel TEXT(50)
    ); 

Данное DDL выражение (для MS Access) в время выполнения создаст новую
таблицу с названием PhoneBook. Таблица PhoneBook будет иметь два поля:
Name и Tel. Оба поля имеют строковый тип (TEXT) и размер поля 50
символов.

**TFieldDef.DataType**

Очевидно, что в Access тип данных, представленный строкой это TEXT. В
Paradox это STRING. Чтобы передать таблицы Paradox в Access, нам
необходимо знать какие типы данных присутствуют и, соответственно их
имена. При работе в BDE с таблицами Paradox, TFieldDef.DataType
определяет тип физического поля в (dataset) таблице. Поэтому для
успешного перенесения данных из таблиц Paradox в Access Вам необходимо
создать функцию, которая бы преобразовывала соотвествующие типы полей
Paradox в типы Access.

Давайте посмотрим на пример функции, которая проверяет тип поля (fd) и
возвращает соответствующий тип Access, а заоодно и размер поля, который
необходим для выражения CREATE TABLE DDL.

    function AccessType(fd:TFieldDef):string;
    begin
     case fd.DataType of
      ftString: Result:='TEXT('+IntToStr(fd.Size)+')';
      ftSmallint: Result:='SMALLINT';
      ftInteger: Result:='INTEGER';
      ftWord: Result:='WORD';
      ftBoolean: Result:='YESNO';
      ftFloat : Result:='FLOAT';
      ...
     else
      Result:='TEXT(50)';
     end;
    end;

**ADOX**

ADOX - это расширения ADO для Data Definition Language а так же для
модели защиты (ADOX). ADOX предоставляет разработчикам богатый набор
инструментов для получения доступа к структуре, модели защиты, а так же
процедурам, хранимым в базе данных.

Для использования ADOX в Delphi, Вам необходимы установить библиотеку
типа ADOX.

1. Select Project \| Import Type Library
3. Выберите "Microsoft ADO Ext 2.x for DDL and Security (Version 2.x)"
4. Измените "TTable" на "TADOXTable"
5. Измените "TColumn" на "TADOXColumn"
6. Измените "TIndex" на "TADOXIndex"
7. Нажмите кнопку Install (перекомпиляция пакетов (packages))
8. Нажмите один раз OK и дважды Yes
9. File \| Close All \| Yes

На вершине объектной модели ADOX находится объект Catalog. Он
обеспечивает доступ к набору Таблиц (Tables), Видов (Views) и Процедур,
который используется для работы со структурой базы данных, а так же к
набору Пользователей (Users) и рупп (Groups), которые используются для
авторизации доступа. Каждый объект Catalog связан только с одним
подключением к источнику данных.

Давайте оставим ADOX (пока) и перейдём к ADOExpress.

**TADOCommand**

В ADOExpress компонент TADOCommand - это VCL представление объекта ADO
Command. Объект Command представляет команду (запрос или выражение),
которая может быть обработана источником данных. Команды могут быть
выполнены методом  Execute, используемым в ADOCommand. TADOCommand чаще
всего используется для исполнения команд языка определения данных (DDL)
SQL. Свойство CommandText содержит в себе саму команду. Свойство
CommandType используется для того, как интерпретировать свойство
CommandText. Тип cmdText используется для указания инструкции DDL.
Впринципе, использовать компонент ADOCommand для получения данных из
таблицы, запросов или хранимых процедур не имеет смысла, но никто не
запрещает Вам пользоваться данным компонентов и в таких целях.

Итак, самое время приступить к реальному программированию...

Приведённый ниже проект демонстрирует следующее:

Получение списка всех таблиц из BDE, использование TFieldDefs чтобы
получить определения (имя, тип данных, размер, и т.д.) полей в таблице,
создание инструкции CREATE TABLE и копирование данных из таблицы
BDE/Paradox в таблицу ADO/Access.

Давайте решим эту задачу по шагам:

**GUI**

Запускаем Delphi - получаем новый проект с пустой формой. Добавляем две
кнопки, один ComboBox и один компонент Memo. Далее добавляем компоненты
TTable, TADOTable, TADOConnection и TADOCommand. Чтобы установить
следующие свойства, используем Object Inspector (оставьте все другие
свойства как есть - например, Memo будет иметь имя по умолчанию: Memo1):

Для получения списка таблиц, связанных с данной базо данных (DBDEMOS) мы
воспользуемся следующим кодом (OnCreate для формы):

    procedure TForm1.FormCreate(Sender: TObject);
    begin
     Session.GetTableNames('DBDEMOS',
                           '*.db',False, False,
                           cboBDETblNames.Items);
    end;

В самом начале ComboBox содержит имена таблиц (Paradox) в базе данных
DBDEMOS. В нижеприведённом коде мы выберем таблицу Country.

Следующая наша задача - это создание инструкции CREATE TABLE DDL. Это
делается в процедуре OnClick кнопки \'Construct Create command\':

    procedure TForm1.Button1Click(Sender: TObject);
    //Кнопка 'Construct Create command'
    var i:integer;
        s:string;
    begin
     BDETable.TableName:=cboBDETblNames.Text;
     BDETable.FieldDefs.Update;
     
     s:='CREATE TABLE ' + BDETable.TableName + ' (';
     with BDETable.FieldDefs do begin
      for i:=0 to Count-1 do begin
       s:=s + ' ' + Items[i].Name;
       s:=s + ' ' + AccessType(Items[i]);
       s:=s + ',';
      end; //for
      s[Length(s)]:=')';
     end;//with
     
     Memo1.Clear;
     Memo1.lines.Add (s);
    end;

Вышеприведённый код просто анализирует определения полей для выбранной
таблицы (cboBDETblNames) и генерирует строку, которая будет
использоваться свойством CommandText компоненты TADOCommand.

Например, когда Вы выбираете таблицу Country, то Memo будет заполнен
следующей строкой:

    CREATE TABLE country (
      Name TEXT(24),
      Capital TEXT(24),
      Continent TEXT(24),
      Area FLOAT,
      Population FLOAT
    )

И в заключении, пример для кнопки \'Create Table and copy data\',
которая удаляет таблицу (DROP..EXECUTE), создаёт таблицу
(CREATE..EXECUTE), и затем копирует данные в новую таблицу
(INSERT...POST). Так же присутствует некоторая обработка ошибок, но код
будет выходить на ошибку, если, например, (новая) таблица ещё не
существует (в случае удаления).

    procedure TForm1.Button2Click(Sender: TObject);
    //Кнопка 'Create Table and copy data'
    var i:integer;
        tblName:string;
    begin
     tblName:=cboBDETblNames.Text;
     
    //обновляем
     Button1Click(Sender);
     
    //удаление & создание таблицы
     ADOCommand.CommandText:='DROP TABLE ' + tblName;
     ADOCommand.Execute;
     
     ADOCommand.CommandText:=Memo1.Text;
     ADOCommand.Execute;
     
     ADOTable.TableName:=tblName;
     
    //копируем данные
     BDETable.Open;
     ADOTable.Open;
     try
      while not BDETable.Eof do begin
       ADOTable.Insert;
       for i:=0 to BDETable.Fields.Count-1 do begin
        ADOTable.FieldByName
       (BDETable.FieldDefs[i].Name).Value :=
          BDETable.Fields[i].Value;
       end;//for
       ADOTable.Post;
       BDETable.Next
      end;//while
     finally
      BDETable.Close;
      ADOTable.Close;
     end;//try
    end;

Вот и всё. Теперь проверьте Вашу базу данных Access...вуаля :) теперь в
ней находится таблица Country со всеми данными из DBDEMOS.

Однако некоторые вопросы остались без ответа, например: как добавлять
индексы в таблицу (CREATE INDEX ON ...), или как создавать пустую базу
данных Access.

