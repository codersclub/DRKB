---
Title: SQL-запросы в Delphi
Date: 01.01.2007
---


SQL-запросы в Delphi
====================

::: {.date}
01.01.2007
:::

Примечание

Данный документ представляет собой коллективный труд нескольких авторов,
которые индивидуально несут ответственность за качество предоставленной
здесь информации. Borland не предоставлял, и не может предоставить
никакой гарантии относительно содержимого данного документа.

1\. Введение

Компоненты Delphi для работы с базами данных были созданы в расчете на
работу с SQL и архитектурой клиент/сервер. При работе с ними вы можете
воспользоваться характеристиками расширенной поддержки удаленных
серверов. Delphi осуществляет эту поддержку двумя способами. Во-первых,
непосредственные команды из Delphi позволяют разработчику управлять
таблицами, устанавливать пределы, удалять, вставлять и редактировать
существующие записи. Второй способ заключается в использовании запросов
на языке SQL, где строка запроса передается на сервер для ее разбора,
оптимизации, выполнения и передачи обратно результатов.

Данный документ делает акцент на втором методе доступа к базам данных,
на основе запросов SQL (pass-through). Авторы не стремились создать
курсы по изучению синтаксиса языка SQL и его применения, они ставили
перед собой цель дать несколько примеров использования компонентов
TQuery и TStoredProc. Но чтобы сделать это, необходимо понимать
концепцию SQL и знать как работают selects, inserts, updates, views,
joins и хранимые процедуры (stored procedures). Документ также вскользь
касается вопросов управления транзакциями и соединения с базой данных,
но не акцентирует на этом внимание. Итак, приступая к теме, создайте
простой запрос типа SELECT и отобразите результаты.

2\. Компонент TQuery

Если в ваших приложениях вы собираетесь использовать SQL, то вам
непременно придется познакомиться с компонентом TQuery. Компоненты
TQuery и TTable наследуются от TDataset. TDataset обеспечивает
необходимую функциональность для получения доступа к базам данных. Как
таковые, компоненты TQuery и TTable имеют много общих признаков. Для
подготовки данных для показа в визуальных компонентах используется все
тот же TDatasource. Также, для определения к какому серверу и базе
данных необходимо получить доступ, необходимо задать имя псевдонима. Это
должно выполняться установкой свойства aliasName объекта TQuery.

Свойство SQL

Все же TQuery имеет некоторую уникальную функциональность. Например, у
TQuery имеется свойство с именем SQL. Свойство SQL используется для
хранения SQL-запроса. Ниже приведены основные шаги для составления
запроса, где все служащие имеют зарплату свыше \$50,000.

Создайте объект TQuery

Задайте псевдоним свойству DatabaseName. (Данный пример использует
псевдоним IBLOCAL, связанный с демонстрационной базой данных
employee.gdb).

Выберите свойство SQL и щелкните на кнопке с текстом - \'\...\' (три
точки, Инспектор Объектов - В.О.). Должен появиться диалог редактора
списка строк (String List Editor).

Введите:

    Select * from EMPLOYEE where SALARY>50000

. Нажмите OK.

Выберите в Инспекторе Объектов свойство Active и установите его в TRUE.

Разместите на форме объект TDatasource.

Установите свойство Dataset у TDatasource в Query1.

Разместите на форме TDBGrid.

Установите его свойство Datasource в Datasource1.

Свойство SQL имеет тип TStrings. Объект TStrings представляет собой
список строк, и чем-то похож на массив. Тип данных TStrings имеет в
своем арсенале команды добавления строк, их загрузки из текстового файла
и обмена данными с другим объектом TStrings. Другой компонент,
использующий TStrings - TMemo. В демонстрационном проекте ENTRSQL.DPR
(по идее, он должен находится на отдельной дискетте, но к \"Советам по
Delphi\" она не прилагается - В.О.), пользователь должен ввести
SQL-запрос и нажать кнопку \"Do It\" (\"сделать это\"). Результаты
запроса отображаются в табличной сетке. В Листинге 1 полностью приведен
код обработчика кнопки \"Do It\".

Листинг 1

    procedure TForm1.BitBtn1Click(Sender: TObject);
    begin
    Query1.close; {Деактивируем запрос в качестве одной из мер предосторожности }
    Query1.SQL.Clear; {Стираем любой предыдущий запрос}
    If Memo1.Lines[0] <> '' {Проверяем на предмет пустого ввода} then
      Query1.SQL.Add(Memo1.Text) {Назначаем свойству SQL текст Memo}
    else
    begin
    messageDlg('Не был введен SQL-запрос', mtError, [mbOK], 0);
    exit;
    end;
    try        {перехватчик ошибок}
    Query1.Open;     {Выполняем запрос и открываем набор данных}
    except     {секция обработки ошибок}
    On e : EDatabaseError do {e - новый дескриптор ошибки}
    messageDlg(e.message, mtError, [mbOK],0); {показываем свойство message объекта e}
    end;      {окончание обработки ошибки}
    end;

Свойство Params

Этого должно быть достаточно для пользователя, знающего SQL. Тем не
менее, большинство пользователей не знает этого языка. Итак, ваша работа
как разработчика заключается в предоставлении интерфейса и создании
SQL-запроса. В Delphi, для создания SQL-запроса на лету можно
использовать динамические запросы. Динамические запросы допускают
использование параметров. Для определения параметра в запросе
используется двоеточие (:), за которым следует имя параметра. Ниже
приведе пример SQL-запроса с использованием динамического параметра:

    select * from EMPLOYEE
    where DEPT_NO = :Dept_no

Если вам нужно протестировать, или установить для параметра значение по
умолчанию, выберите свойство Params объекта Query1. Щелкните на кнопке
\'\...\'. Должен появиться диалог настройки параметров. Выберите
параметр Dept\_no. Затем в выпадающем списке типов данных выберите
Integer. Для того, чтобы задать значение по умолчанию, введите нужное
значение в поле редактирования \"Value\".

Для изменения SQL-запроса во время выполнения приложения, параметры
необходимо связать (bind). Параметры могут изменяться, запрос
выполняться повторно, а данные обновляться. Для непосредственного
редактирования значения параметра используется свойство Params или метод
ParamByName. Свойство Params представляет из себя массив TParams.
Поэтому для получения доступа к параметру, необходимо указать его
индекс. Для примера,

Query1.params\[0\].asInteger := 900;

Свойство asInteger читает данные как тип Integer (название говорит само
за себя). Это не обязательно должно указывать но то, что поле имеет тип
Integer. Например, если тип поля VARCHAR(10), Delphi осуществит
преобразование данных. Так, приведенный выше пример мог бы быть записан
таким образом:

Query1.params\[0\].asString := \'900\';

или так:

Query1.params\[0\].asString := edit1.text;

Если вместо номера индекса вы хотели бы использовать имя параметра, то
воспользуйтесь методом ParamByName. Данный метод возвращает объект
TParam с заданным именем. Например:

Query1.ParamByName(\'DEPT\_NO\').asInteger := 900;

В листинге 2 приведен полный код примера.

Листинг 2

    procedure TForm1.BitBtn1Click(Sender: TObject);
    begin
    Query1.close;     {Деактивируем запрос в качестве одной из мер предосторожности }
    if not Query1.prepared then
      Query1.prepare; {Убедимся что запрос подготовлен}
      {Берем значение, введенное пользователем и заменяем
      им параметр.}
    if edit1.text <> '' then {Проверяем на предмет пустого ввода}
      Query1.ParamByName('DEPT_NO').AsString := edit1.text
    else
      Begin
        Query1.ParamByName('DEPT_NO').AsInteger := 0;
        edit1.text := '0';
      end;
    try        {перехватчик ошибок}
      Query1.Open;     {Выполняем запрос и открываем набор данных}
    except     {секция обработки ошибок}
      On e : EDatabaseError do {e - новый дескриптор ошибки} messageDlg(e.message,
         mtError,
         [mbOK],0); {показываем свойство message объекта e}
    end;     {окончание обработки ошибки}
    end;

Обратите внимание на процедуру, первым делом подготовливающую запрос.
При вызове метода prepare, Delphi посылает SQL запрос на удаленный
сервер. Сервер выполняет грамматический разбор и оптимизацию запроса.
Преимущество такой подготовки запроса состоит в его предварительном
разборе и оптимизации. Альтернативой здесь может служить подготовка
сервером запроса при каждом его выполнении. Как только запрос
подготовлен, подставляются необходимые новые параметры, и запрос
выполняется.

Источник данных

В предыдущем примере пользователь мог ввести номер отдела, и после
выполнения запроса отображался список сотрудников этого отдела. А как
насчет использования таблицы DEPARTMENT, позволяющей пользователю легко
перемещаться между пользователями и отделами?

Примечание: Следующий пример использует TTable с именем Table1. Для
Table1 имя базы данных IBLOCAL, имя таблицы - DEPARTMENT. DataSource2
TDatasource связан с Table1. Таблица также активна и отображает записи в
TDBGrid.

Способ подключения TQuery к TTable - через TDatasource. Есть два
основных способа сделать это. Во-первых, разместить код в обработчике
события TDatasource OnDataChange. Например, листинг 3 демонстрирует эту
технику.

Листинг 3 - Использования события OnDataChange для просмотра дочерних
записей

    procedure TForm1.DataSource2DataChange(Sender: TObject; Field: TField);
    begin
    Query1.Close;
    if not Query1.prepared
    then
    Query1.prepare;
    Query1.ParamByName('Dept_no').asInteger := Table1Dept_No.asInteger;
    try
     Query1.Open;
    except
    On e : EDatabaseError do
    messageDlg(e.message, mtError, [mbOK], 0);
    end;
    end;

Техника с использованием OnDataChange очень гибка, но есть еще легче
способ подключения Query к таблице. Компонент TQuery имеет свойство
Datasource. Определяя TDatasource для свойства Datasource, объект TQuery
сравнивает имена параметров в SQL-запросе с именами полей в TDatasource.
В случае общих имен, такие параметры заполняются автоматически. Это
позволяет разработчику избежать написание кода, приведенного в листинге
3 (\*\*\* приведен выше \*\*\*).

Фактически, техника использования Datasource не требует никакого
дополнительного кодирования. Для поключения запроса к таблице DEPT\_NO
выполните действия, приведенные в листинге 4.

Листинг 4 - Связывание TQuery c TTable через свойство Datasource

Выберите у Query1 свойство SQL и введите:

    select * from EMPLOYEE
    where DEPT_NO = :dept_no

Выберите свойство Datasource и назначьте источник данных, связанный с
Table1 (Datasource2 в нашем примере)

Выберите свойство Active и установите его в True

Это все, если вы хотите создать такой тип отношений. Тем не менее,
существуют некоторые ограничения на параметризованные запросы. Параметры
ограничены значениями. К примеру, вы не можете использовать параметр с
именем Column или Table. Для создания запроса, динамически изменяемого
имя таблицы, вы могли бы использовать технику конкатенации строки.
Другая техника заключается в использовании команды Format.

Команда Format

Команда Format заменяет параметры форматирования (%s, %d, %n и пр.)
передаваемыми значениями. Например,

Format(\'Select \* from %s\', \[\'EMPLOYEE\'\])

Результатом вышеприведенной команды будет \'Select \* from EMPLOYEE\'.
Функция буквально делает замену параметров форматирования значениями
массива. При использовании нескольких параметров форматирования, замена
происходит слева направо. Например,

    tblName := 'EMPLOYEE';
    fldName := 'EMP_ID';
    fldValue := 3;
    Format('Select * from %s where %s=%d', [tblName, fldName, fldValue])

Результатом команды форматирования будет \'Select \* from EMPLOYEE where
EMP\_ID=3\'. Такая функциональность обеспечивает чрезвычайную гибкость
при динамическом выполнении запроса. Пример, приведенный ниже в листинге
5, позволяет вывести в результатах поле salary. Для поля salary
пользователь может задавать критерии.

Листинг 5 - Использование команды Format для создания SQL-запроса

    procedure TForm1.BitBtn1Click(Sender: TObject);
    var
      sqlString: string; {здесь хранится SQL-запрос}
      fmtStr1,
        fmtStr2: string; {здесь хранится строка, передаваемая для форматирования}
     
    begin
    { Создание каркаса запроса }
      sqlString := 'Select EMP_NO %s from employee where SALARY %s';
     
      if showSalaryChkBox.checked {Если checkbox Salary отмечен} then
        fmtStr1 := ', SALARY'
      else
        fmtStr1 := '';
      if salaryEdit.text <> '' { Если поле редактирования Salary не пустое } then
        fmtStr2 := salaryEdit.text
      else
        fmtStr2 := '>0';
     
      Query1.Close; {Деактивируем запрос в качестве одной из мер предосторожности }
      Query1.SQL.Clear; {Стираем любой предыдущий запрос}
      Query1.SQL.Add(Format(sqlString, [fmtStr1, fmtStr2])); {Добавляем}
    {форматированную строку к свойству SQL}
     
      try {перехватчик ошибок}
        Query1.Open; {Выполняем запрос и открываем набор данных}
      except {секция обработки ошибок}
        on e: EDatabaseError do {e - новый дескриптор ошибки}
          messageDlg(e.message, mtError, [mbOK], 0);
    {показываем свойство message объекта e}
      end; {окончание обработки ошибки}
    end;

В этом примере мы используем методы Clear и Add свойства SQL. Поскольку
\"подготовленный\" запрос использует ресурсы сервера, и нет никакой
гарантии что новый запрос будет использовать те же таблицы и столбцы,
Delphi, при каждом изменении свойства SQL, осуществляет операцию,
обратную \"подготовке\" (unprepare). Если TQuery не был подготовлен
(т.е. свойство Prepared установлено в False), Delphi автоматически
подготавливает его при каждом выполнении. Поэтому в нашем случае, даже
если бы был вызван метод Prepare, приложению от этого не будет никакой
пользы.

Open против ExecSQL

В предыдущих примерах TQuerie выполняли Select-запросы. Delphi
рассматривает результаты Select-запроса как набор данных, типа таблицы.
Это просто один класс допустимых SQL-запросов. К примеру, команда Update
обновляет содержимое записи, но не возвращает записи или какого-либо
значения. Если вы хотите использовать запрос, не возвращающий набор
данных, используйте ExecSQL вместо Open. ExecSQL передает запрос для
выполнения на сервер. В общем случае, если вы ожидаете, что получите от
запроса данные, то используйте Open. В противном случае допускается
использование ExecSQL, хотя его использование с Select не будет
конструктивным. Листинг 6 содержит код, поясняющий сказанное на примере.

Листинг 6

    procedure TForm1.BitBtnClick(sender: TObject)
    begin
      Query1.Close;
      Query1.Clear;
      Query1.SQL.Add('Update SALARY from EMPLOYEE ' +
        'where SALARY<:salary values (SALARY*(1+:raise)');
      Query1.paramByName('salary').asString := edit1.text;
      Query1.paramByName('raise').asString := edit2.text;
      try
        Query1.ExecSQL;
      except
        on e: EDatabaseError do
          messageDlg(e.message, mtError, [mbOK], 0);
      end;
    end;

Все приведенные выше примеры предполагают использования в ваших
приложениях запросов. Они могут дать солидное основание для того, чтобы
начать использовать в ваших приложениях TQuery. Но все же нельзя
прогнозировать конец использования SQL в ваших приложених. Типичные
серверы могут предложить вам другие характеристики, типа хранимых
процедур и транзакций. В следующих двух секциях приведен краткий обзор
этих средств.

3\. Компонент TStoredProc

Хранимая процедура представляет собой список команд (SQL или
определенного сервера), хранимых и выполняемых на стороне сервера.
Хранимые процедуры не имеют концептуальных различий с другими типами
процедур. TStoredProc наследуется от TDataset, поэтому он имеет много
общих характеристик с TTable и TQuery. Особенно заметно сходство с
TQuery. Поскольку хранимые процедуры не требуют возврата значений, те же
правила действуют и для методов ExecProc и Open. Каждый сервер реализует
работу хранимых процедур с небольшими различиями. Например, если в
качестве сервера вы используете Interbase, хранимые процедуры
выполняются в виде Select-запросов. Например, чтобы посмотреть на
результаты хранимой процедуры, ORG\_CHART, в демонстрационной базе
данных EMPLOYEE, используйте следующих SQL-запрос:

     Select * from ORG_CHART

При работе с другими серверами, например, Sybase, вы можете использовать
компонент TStoredProc. Данный компонент имеет свойства для имен базы
данных и хранимой процедуры. Если процедура требует на входе каких-то
параметров, используйте для их ввода свойство Params.

4\. TDatabase

Компонент TDatabase обеспечивает функциональность, которой не хватает
TQuery и TStoredProc. В частности, TDatabase позволяет создавать
локальные псевдонимы BDE, так что приложению не потребуются псевдонимы,
содержащиеся в конфигурационном файле BDE. Этим локальным псевдонимом в
приложении могут воспользоваться все имеющиеся TTable, TQuery и
TStoredProc. TDatabase также позволяет разработчику настраивать процесс
подключения, подавляя диалог ввода имени и пароля пользователя, или
заполняя необходимые параметры. И, наконец, самое главное, TDatabase
может обеспечивать единственную связь с базой данных, суммируя все
операции с базой данных через один компонент. Это позволяет элементам
управления для работы с БД иметь возможность управления транзакциями.

Транзакцией можно считать передачу пакета информации. Классическим
примером транзакции является передача денег на счет банка. Транзакция
должна состоять из операции внесения суммы на новый счет и удаления той
же суммы с текущего счета. Если один из этих шагов по какой-то причине
был невыполнен, транзакция также считается невыполненной. В случае такой
ошибки, SQL сервер позволяет выполнить команду отката (rollback), без
внесения изменений в базу данных. Управление транзакциями зависит от
компонента TDatabase. Поскольку транзакция обычно состоит из нескольких
запросов, вы должны отметить начало транзакции и ее конец. Для выделения
начала транзакции используйте TDatabase.BeginTransaction. Как только
транзакция начнет выполняться, все выполняемые команды до вызова
TDatabase.Commit или TDatabase.Rollback переводятся во временный режим.
При вызове Commit все измененные данные передаются на сервер. При вызове
Rollback все изменения теряют силу. Ниже в листинге 7 приведен пример,
где используется таблица с именем ACCOUNTS. Показанная процедура
пытается передать сумму с одного счета на другой.

Листинг 7

    procedure TForm1.BitBtn1Click(Sender: TObject);
    { ПРИМЕЧАНИЕ: Поле BALANCE у ACCOUNTS имеет триггер, проверяющий
    ситуацию, когда вычитаемая сумма превышает BALANCE. Если так, UPDATE
    будет отменен}
    begin
      try
        database1.StartTransaction;
        query1.SQL.Clear;
    { Вычитаем сумму из выбранного счета }
        query1.SQL.Add(Format('update ACCOUNTS ' +
          'set BALANCE = BALANCE - %s ) ' +
          'where ACCT_NUM = %s ',
          [edit1.text,
          Table1Acct_Num.asString]));
        query1.ExecSQL;
        query1.SQL.Clear;
    { Добавляем сумму к выбранному счету }
        query1.SQL.Add(Format('update ACCOUNTS ' +
          'set BALANCE = BALANCE + %s ' +
          'where ACCT_NUM = %s ',
          [edit1.text,
          Table2Acct_Num.asString]));
        query1.ExecSQL;
        database1.Commit; {В этом месте делаем все изменения}
        table1.Refresh;
        table2.Refresh;
      except
    {При возникновении в приведенном коде любых ошибок,
    откатываем транзакцию назад}
        One: EDatabaseError do
        begin
          messageDlg(e.message, mtError, [mbOK], 0);
          database1.rollback;
          exit;
        end;
        One: Exception do
        begin
          messageDlg(e.message, mtError, [mbOK], 0);
          database1.rollback;
          exit;
        end;
      end;
    end;

И последнее, что нужно учесть при соединении с базой данных. В
приведенном выше примере, TDatabase использовался в качестве
единственного канала для связи с базой данных, поэтому было возможным
выполнение только одной транзакции. Чтобы выполнить это, было определено
имя псевдонима (Aliasname). Псевдоним хранит в себе информацию,
касающуюся соединения, такую, как Driver Type (тип драйвера), Server
Name (имя сервера), User Name (имя пользователя) и другую. Данная
информация используется для создания строки соединения (connect string).
Для создания псевдонима вы можете использовать утилиту конфигурирования
BDE, или, как показано в примере ниже, заполнять параметры во время
выполнения приложения.

TDatabase имеет свойство Params, в котором хранится информация
соединения. Каждая строка Params является отдельным параметром. В
приведенном ниже примере пользователь устанавливает параметр User Name в
поле редактирования Edit1, а параметр Password в поле Edit2. В коде
листинга 8 показан процесс подключения к базе данных:

Листинг 8

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      try
        with database1 do
          begin
            Close;
            DriverName := 'INTRBASE';
            KeepConnection := TRUE;
            LoginPrompt := FALSE;
            with database1.Params do
              begin
                Clear;
                Add('SERVER NAME=C:\IBLOCAL\EXAMPLES\EMPLOYEE.GDB');
                Add('SCHEMA CACHE=8');
                Add('OPEN MODE=READ/WRITE');
                Add('SQLPASSTHRU MODE=SHARED NOAUTOCOMMIT');
                Add('USER NAME=' + edit1.text);
                Add('PASSWORD=' + edit2.text);
              end;
            Open;
          end;
        session.getTableNames(database1.databasename, '*',
          TRUE,
          TRUE,
          ComboBox1.items);
      except
        One: EDatabaseError do
        begin
          messageDlg(e.message, mtError, [mbOK], 0);
        end;
      end;
    end;

Этот пример показывает как можно осуществить подключение к серверу без
создания псевдонима. Ключевыми моментами здесь являются определение
DriverName и заполнение Params информацией, необходимой для подключения.
Вам не нужно определять все параметры, вам необходимо задать только те,
которые не устанавливаются в конфигурации BDE определенным вами
драйвером базы данных. Введенные в свойстве Params данные перекрывают
все установки конфигурации BDE. Записывая параметры, Delphi заполняет
оставшиеся параметры значениями из BDE Config для данного драйвера.
Приведенный выше пример также вводит такие понятия, как сессия и метод
GetTableNames. Это выходит за рамки обсуждаемой темы, достаточно
упомянуть лишь тот факт, что переменная session является дескриптором
database engine. В примере она добавлена только для \"показухи\".

Другой темой является использование SQLPASSTHRU MODE. Этот параметр базы
данных отвечает за то, как натив-команды базы данных, такие, как
TTable.Append или TTable.Insert будут взаимодействовать с TQuery,
подключенной к той же базе данных. Существуют три возможных значения:
NOT SHARED, SHARED NOAUTOCOMMIT и SHARED AUTOCOMMIT. NOT SHARED
означает, что натив-команды используют одно соединение с сервером, тогда
как запросы - другое. Со стороны сервера это видится как работа двух
разных пользователей. В любой момент времени, пока транзакция активна,
натив-команды не будут исполняться (committed) до тех пор, пока
транзакция не будет завершена. Если был выполнен TQuery, то любые
изменения, переданные в базу данных, проходят отдельно от транзакции.

Два других режима, SHARED NOAUTOCOMMIT и SHARED AUTOCOMMIT, делают для
натив-команд и запросов общим одно соединение с сервером. Различие между
двумя режимами заключаются в передаче выполненной натив-команды на
сервер. При выбранном режиме SHARED AUTOCOMMIT бессмысленно создавать
транзакцию, использующую натив-команды для удаления записи и последующей
попыткой осуществить откат (Rollback). Запись должна быть удалена, а
изменения должны быть сделаны (committed) до вызова команды Rollback.
Если вам нужно передать натив-команды в пределах транзакции, или
включить эти команды в саму транзакцию, убедитесь в том, что SQLPASSTHRU
MODE установлен в SHARED NOAUTOCOMMIT или в NOT SHARED.

5\. Выводы

Delphi поддерживает множество характеристик при использовании языка SQL
с вашими серверами баз данных. На этой ноте разрешите попращаться и
пожелать почаще использовать SQL в ваших приложениях.

Взято с <https://delphiworld.narod.ru>