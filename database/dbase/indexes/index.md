---
Title: DBASE - Индексы выражений (Expression Indexes)
author: Валентин Озеров (webmaster@webinspector.com)
Date: 01.01.2001
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)
---


DBASE - Индексы выражений (Expression Indexes)
==========================

**Введение**

Индексы для таблиц dBASE могут базироваться на значениях из отдельной
области, нередактируемых данных, или на основе выражений. Индексы
выражений, уникальные для индексов dBASE, могут формироваться на основе
нескольких полей, измененных значений полей или их комбинаций. Выражение
для dBASE-индекса создаются с использованием dBASE-функций и синтаксиса
для конкатенации нескольких полей или изменения значений поля для полей,
включенных в выражения индекса.

В конце данного совета включены два небольших раздела, описывающих
механику создания индексов выражений dBASE, один относится к утилите
Database Desktop, другой - к приложениям Delphi.

**Индексные выражения на основе множества полей**

Функции dBASE доступны для применения в Delphi или Database Desktop для
ускоренного использования в выражениях индекса, и затем только в связи с
индексами dBASE. То есть, вы не сможете использовать функции dBASE или
синтаксис для создания выражения индекса для таблицы Paradox или Local
InterBase Server (LIBS). Функции dBASE не могут использоваться при
программировании в Delphi. Они доступны только для выражений индесов
dBASE. Синтаксис и функции dBASE, которые могут быть использованы для
выражений индексов, "расположены" в библиотечном файле Borland
Database Engine (BDE) IDDBAS01.DLL.

При создании индекса dBASE, который должен базироваться на двух или
более полях таблицы, для которой он создается, два или более поля
конкатенируются (связываются вместе) в величине, которая в некоторой
степени похожа на Delphi тип String, с использованием синтакса Delphi:
оператор "+". Например, выражению необходимо создать индекс, который
должен базироваться в первую очередь на основе поля LastName, а затем на
основе поля FirstName:

    LastName + FirstName

В отличие от самого dBASE, такие индексы, основанные на нескольких
полях, ограничены использованием таких же полей в таблице. dBASE
допускает создание индексов, основанных на нескольких полях,
содержищихся в другой таблице. Это позволяет во время создания индекса
иметь открытую только "другую" таблицу или использовать таблицу,
содержащую индекс.

У индексов с несколькими полями для других типов таблиц (например,
Paradox и InterBase), используемые поля должны быть разделены точкой с
запятой (;), как показано ниже:

    LastName;FirstName

В выражениях индекса dBASE, в которых конкатенируются несколько полей,
фактическое выражение должно выглядеть следующим образом:

    LastName + FirstName

При создании индексных выражений, которые конкатенируют два и более
поля, все включенные поля должны иметь одинаковый тип. К тому же, если
они должны конкатенироваться, вместо складывания, то все поля должны
иметь тип String. Например, для двух целочисленных полей, Value1 и
Value2, выражение индекса...

    Value1 + Value2

...не вызовет ошибку. Но в этом случае произойдет конкатенация двух
значений полей и они суммируются. Таким образом, если Value1 для данной
записи содержало 4, а Value2 - 5, результирующий индексный узел будет
целой величиной 9, а не строковой конкантенацией "45".

Если поля, включенные в выражение индекса, имеют не строковый тип, они
должны быть преобразованы. Вот некоторые функции dBASE,
преобразовывающие различные типы данных к строковому типу для
использования в выражениях индекса:

    STR(<Numeric> [, <length expN> [, <decimals expN> [, <expC>]]])

Преобразовывает dBASE-тип Float или Numeric в Character (String)

    DTOS(<date_expression>)

Преобразовывает значение Date к Character, формат YYYYMMDD

    MLINE(<memo field> [, <line number expN > [, <line length expN>]])

Извлекает отдельную строку из Memo-поля как значение Character

Другое ограничение при создании индексов путем конкантенации нескольких
полей - максимально допустимая длина индексной величины. Величина,
возвращаемая индексным значением, не может превышать 100 символов. Это
предел длины значения, возвращаемого выражением, не длина самого
выражения. Например, вы не можете создать индекс путем конкантенации
двух полей, если они оба имееют длину 255 символов.

**Индексные выражения на основе модификации значений полей**

Дополнительно к созданию индексов, основанных на конкатенации значений
двух и более полей, также возможно создать индекс, основанный на
модификации значений полей. Примером этого может служить создание
индекса на основе первых трех символов поля типа String, года и месяца
поля с типом Date, индекс с использованием конкантенации полей с типами
String и Date, где значение поля типа String отсортировано по
возрастающей, а поле, имеющим тип Date - по убывающей, и даже создание
индекса на основе поля с логическим типом.

Создание индексов на основе модификации значений полей требует, по
крайней мере, практическое знание функций dBASE и синтаксиса, поскольку
данная технология использует dBASE, а не функции и синтаксис Delphi.
Функция dBASE SUBSTR() извлекает подстроку из поля типа String.
Delphi-эквивалент данной dBASE-функции - Copy. Но только dBASE функция
SUBSTR() может применяться при создании индексного выражения dBASE.

Использование фунций dBASE в индексных выражениях dBASE заключается в
простом включении в индексное выражение функции, использование в
функциях dBASE-синтаксиса и имени (имен) поля (полей), использующихся в
функциях. Например, индексное выражение на основе трех последних
символов значения поля типа String с именем Code, имеющим длину 20
символов выглядит так:

    RIGHT(Code, 3)

Важно соблюдение следующего правила: конструкции индексных выражений
dBASE, модифицирующих значения полей, должны возвращать величину с
"последовательной длиной" для каждой записи таблицы, т.е. результат не
должен содержать граничных пробелов. Например, функция dBASE TRIM()
удаляет граничные пробелы (ASCII код 32) из значения поля типа String.
Если это было использовано вместе с конкантенацией двух полей, имеющих
тип String, где поле не имеет постоянной длины для разных записей, длина
результирующего значения будет различная для всех записей. В свете этого
рассмотрим следующий пример: построим индексное выражение на основе
конкантенации полей LastName и FirstName field, где функция TRIM()
применена к полю LastName:

    TRIM(LastName) + FirstName

Данное выражение не возратит значения "последовательной длины" для
всех записей. Если поля LastName и FirstName содержали значения...

| LastName | FirstName |
| -------- | --------- |
| Smith    |  Jonas |
| Wesson   |  Nancy |

...то результат использования индексного выражения может быть таким:

    SmithJonas
    WessonNancy

Как вы можете наблюдать, длина значения первого поля равна 10 символов,
тогда как второго - 11 символов. Узлы индекса для данного индексного
выражения должны базироваться на значении поля первой ненумерованной
записи. Следовательно, результат выражения индекса для каждого узла
должен быть равен 10 символов. В нашем примере результат вычисления для
второй записи округляется до "WessonNanc". Все это приводит к тому,
что поиск, основанный на поиске полных значений в полях, окончится
неудачей.

Решение это дилеммы кроется в не использовании функции TRIM(), а в
использовании полной длины значений поля LastName, включая граничные
пробелы. В индексах, которые используют функции IIF() для установления
порядка одного поля или другого, основанных на сравнении логических
выражений в IIF(), если два поля имеют различную длину, более короткое
поле должно быть заполнено пробелами до длины большей области. Для
примера, создавая индекс с использованием функции IIF(), и индексируя
поля Company или Name, базирующийся на поле Category, и где поле Company
длиной 40 символов, а поле Name длиной 25 симловов, поле Name необходимо
дополнять 15-ю пробелами; например, с помощью dBASE-функции SPACE().
Выражение индекса в этом случае будет таким:

    IIF(Category = "B", Company, Name + SPACE(15))

**Поиск и выражения индексов dBASE**

Выражения индексов dBASE являются исключениями из правил в том, как они
обрабатываются Delphi и BDE, по сравнению с обработкой индексов таблиц
другого типа, также основанных на множестве полей.

Это вынуждает вынести dBASE-индексы в отдельный класс. Обработка таких
индексов в Delphi и BDE отличается от обработки индексов для других
типов таблиц. Одно из самых существенных различий заключается в том, что
не все поисковые инструменты, основанные на индексах и использующие
синтаксис Delphi, могут использовать выражения индексов dBASE. FindKey,
FindNearest и GotoKey методы компонента TTable не годятся для работы с
выражениями индексов. При попытке использования FindKey вы получите
сообщение об ошибке: "Field index out of range." (Индекс поля за
границами диапазона). При попытке использования метода GotoKey может
произойти та же ошибка, или табличный курсор может остаться на месте
(визуально искомая величина не найдена). С выражениями индексов может
использоваться только метод GotoNearest. Но даже GotoNearest может не
работать с некоторыми индексными выражениями. Только с помощью
эксперимента можно установить - работает ли метод GotoNearest с данным
индексным выражением.

**Фильтрация индексных выражений dBASE**

Как и основанный на индексах поиск, индексные выражения dBASE при
использовании фильтров Delphi также имеют некоторые исключения.

С активным индексным выражением метод SetRange компонента TTable
приводит к следующей ошибке: "Field index out of range." (Индекс поля
за границами диапазона). Тем не менее, с тем же активным индексным
выражением методы SetRangeStart и SetRangeEnd успешно фильтруют набор
данных.

Например, выражение индекса с конкантенацией поля LastName и активного
FirstName, в приведенном ниже коде, использующем метод FindKey
(предполагающий фильтрацию тех записей, где первый символ поля LastName
содержит "S"), "вылетит" с ошибкой:

    begin
      Table1.SetRange(['S'], ['Szzz'])
    end;

Код, приведенный ниже, использует то же активное выражение индекса, но
используемый фильтр поля LastName правильно отфильтрует данные, и не
вызовет ошибки:

    begin
      with Table1 do
      begin
        SetRangeStart;
        FieldByName('LastName').AsString := 'S';
        SetRangeEnd;
        FieldByName('LastName').AsString := 'Szzz';
        ApplyRange;
      end;
    end;

И, так же, как и в случае основанного на индексах поиска, успех
применения фильтра целиком и полностью зависит от самого индексного
выражения. Использование методов SetRangeStart и SetRangeEnd в
приведенном примере работало бы с индексом, построенным на основе
простой конкантенации двух полей, имеющих тип String. Но если вместо
этого выражение было основано на одном или нескольких полях с
использованием функции IIF(), тот же самый процесс фильтрации потерпел
бы неудачу (хотя и без ошибки).

**Несколько полезных советов при создании индексных выражений dBASE**

Вот некоторые "удобные" индексные выражения dBASE. Некоторые
интуитивно-понятные в достижении своей цели, другие немного "заумные".

Сортировка поля типа Character символов по-возрастающей, поля Date -
по-убывающей

С полем типа Character и именем Name, и полем типа Date и именем
OrdDate:

    Name + STR(OrdDate - {12/31/3099}, 10, 0)

Сортировка поля типа Character по-возрастающей и поля типа Numeric (или
Float) по-убывающей

C полем типа Character и именем Company, и полем типа Numeric и именем
Amount (поле Amount имеет длину 9 цифр с двумя цифрами после десятичной
запятой):

    Company + STR(Amount - 999999.99, 9, 2)

**Сортировка логического поля**

Для того, чтобы записи со значением True располагались впереди записей
со значением False в логическом поле с именем Paid, выполните следующее:

    IIF(Paid, "A", "Z")

Два поля с типом Numeric (или Float)

Предположим, у нас имеется два поля типа Numeric с пятью и двумя
десятичными разрядами, первое поле с именем Price, второе - Quantity:

    STR(Price, 5, 2) + STR(Quantity, 5, 2)

Сортировка одного из двух полей в зависимости от выполнения логического
условия

Сортировка имен месяцев в поле, имеющим тип Character

Предположим, поле содержит имена месяцев на английском языке ("Jan,"
"Feb" и т.д.), и его необходимо расположить в соответствующем порядке
(имя поля M):

      IIF(M="Jan", 1,
       IIF(M="Feb", 2,
        IIF(M="Mar", 3,
         IIF(M="Apr", 4,
          IIF(M="May", 5,
           IIF(M="Jun", 6,
            IIF(M="Jul", 7,
             IIF(M="Aug", 8,
              IIF(M="Sep", 9,
               IIF(M="Oct", 10,
                IIF(M="Nov", 11, 12)))))))))))

(Вышеприведенный код - единственная строка кода, разбирая на несколько
из-за ограничений ширины страницы.)

**Сортировка по первой строке Memo-поля**

Для Memo-поля с именем Notes:

    MLINE(Notes, 1)

**Сортировка по средним трем символам в девятисимвольном поле типа long**

Для девятисимвольного поля типа long с именем StockNo:

    SUBSTR(StockNo, 4, 3)

**Создание индексных выражений dBASE в Database Desktop**

В утилите Database Desktop, индексы могут создаваться как для новой
таблицы (во время ее создания), так и для существующей, путем ее
реструктуризации. В обоих случаях используется диалог "Define Index",
использующийся для создания одного или более индексов таблицы.

Для вывода диалога создания индекса ("Create Index") во время создания
новой таблицы, в диалоге создания dBASE таблицы ("Create dBASE Table")
(показ структуры), выберите в списке "Table Properties" (свойства
таблицы) пункт "Indexes" (индексы) и нажмите на кнопку "Define".

Чтобы вывести диалог создания индекса ("Create Index") при создании
индекса для существующей таблицы, выберите Utilities\|Restructure,
выберите файл с таблицей в диалоге выбора файла ("Select File"), и в
диалоге реструктуризации таблицы dBASE ("Restructure dBASE Table")
(показ структуры таблицы) выберите в списке "Table Properties"
(свойства таблицы) пункт "Indexes" (индексы) и нажмите на кнопку
"Define".

Только в диалоге создания индекса ("Create Index"), выражения индекса
могут создаваться щелчком на кнопке "Expression Index" (индеск
выражения) и вводом выражения в поле редактирования "Expression
Index". Для ассистирования данного процесса, вы можете дважды щелкнуть
на имени поля с списке полей, после чего имя поля будет помещено в
область редактирования "Index Expression" в текущей точке ввода
(позиция курсора).

Как только нужное выражение составлено, нажмите кнопку OK. Введите имя
нового индексного тэга в поле редактирования "Index Tag Name" (имя
индексного тэга") в диалоге "Save Index As" (сохранить индекс
как...) и нажмите "OK". (Помните, имена тэгов индексов dBASE не могут
превышать десяти символов и должны соблюдать соглашения об именах
dBASE.)

**Создание индексных выражений dBASE в приложениях Delphi**

dBASE-индексы могут создаваться программным путем в Delphi-приложениях
как для новой таблицы (метод CreateTable компонента TTable), так и для
существующей.

Для создания индекса как части новой таблицы, необходимо вызваться метод
Add свойства IndexDefs компонента TTable. В нашем случае необходимо
включить в набор флажков индекса флажок ixExpression. Данный флажок
уникален для индексов таблиц dBASE, и может использоваться только с
индексными выражениями dBASE. Для примера:

    with Table1 do
    begin
      Active := False;
      DatabaseName := 'Delphi_Demos';
      TableName := 'CustInfo';
      TableType := ttdBASE;
      with FieldDefs do
      begin
        Clear;
        Add('LastName', ftString, 30, False);
        Add('FirstName', ftString, 20, False);
      end;
      with IndexDefs do
      begin
        Clear;
        Add('FullName', 'LastName + FirstName', [ixExpression]);
      end;
      CreateTable;
    end;

Добавление индекса к существующей таблицы осуществляется вызовом метода
AddIndex компонента TTable. Кроме того, флажки индекса должны включать в
себя значение TIndexOptions ixExpression.

    Table1.AddIndex('FullName', 'LastName + FirstName', [ixExpression]);

**Изучение функций и синтаксиса dBASE**

Для создания индексных выражений dBASE могут использоваться только
функции и синтакс, относящиеся к обработке данных. Тем не менее, полный
список и описание данных функций выходит за рамки данного совета. Для
получения дополнительной информации о dBASE-функциях обработки данных,
обратитесь к руководству "dBASE Language Reference" или книгам и
справочникам по dBASE третьих фирм.

Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
