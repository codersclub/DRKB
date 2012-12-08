---
Title: Естественные ключи против искуственных ключей
Author: Анатолий Тенцер, статья 6-20 июля 1999 года, версия 1.1.
Date: 01.01.2007
---


Естественные ключи против искуственных ключей
=============================================

::: {.date}
01.01.2007
:::

Естественные ключи против искуственных ключей

Автор: Анатолий Тенцер, статья 6-20 июля 1999 года, версия 1.1.

Данная статья излагает взгляд автора на проблему, регулярно
обсуждающуюся в группах новостей, посвящённых разработке приложений с
использованием РСУБД.

О сущности проблемы

Каждая запись в таблице, входящей в РСУБД, должна иметь первичный ключ
(ПК) - набор атрибутов, уникально идентифицирующий её в таблице. Случай,
когда таблица не имеет первичного ключа, имеет право на существование,
однако в данной статье не рассматривается.

В качестве первичного ключа может использоваться -

Естественный Ключ (ЕК) - набор атрибутов описываемой записью сущности,
уникально её идентифицирующий (например, номер паспорта для человека);

или

Суррогатный Ключ (СК) - автоматически сгенерированное поле, никак не
связанное с информационным содержанием записи. Обычно в роли СК
выступает автоинкрементное поле типа INTEGER.

Есть два мнения:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- ---------------------------------------------------------------------------------------------------------------------------------------------------
  •   СК должны использоваться, только если ЕК не существует. Если же ЕК существует, то идентификация записи внутри БД осуществляется по имеющемуся ЕК;
  --- ---------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  •   СК должны добавляться в любую таблицу, на которую существуют ссылки (REFERENCES) из других таблиц, и связи между ними должны организовываться только при помощи СК. Разумеется, поиск записи и представление её пользователю по прежнему производятся на основании ЕК.
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

Естественно, можно представить себе и некое промежуточное мнение, но
сейчас дискуссия ведётся в рамках двух вышеизложенных.

Когда появляются СК

Для понимания места и значения СК рассмотрим этап проектирования, на
котором они вводятся в структуру БД, и методику их введения.

Для ясности рассмотрим БД из 2-х отношений - Города (City) и Люди
(People) Предполагаем, что город характеризуется Hазванием (Name), все
города имеют разные названия, человек характеризуется Фамилией (Family),
номером паспорта (Passport) и городом проживания (City). Также полагаем,
что каждый человек имеет уникальный номер паспорта. Hа этапе составления
инфологической модели БД её структура одинакова и для ЕК и для СК.

    CREATE TABLE City(
     Name VARCHAR(30) NOT NULL PRIMARY KEY
    );
    CREATE TABLE People(
     Passport CHAR(9) NOT NULL PRIMARY KEY,
     Family VARCHAR(20) NOT NULL,
     City VARCHAR(30) NOT NULL REFERENCES City(Name)
    );

Для ЕК все готово. Для СК делаем еще один этап и преобразуем таблицы
следующим образом:

CREATE TABLE City(

    /*
    В разных диалектах языка SQL автоинкрементное поле будет выражено по-разному - например, через IDENTITY, SEQUENCE или GENERATOR. Здесь мы используем условное обозначение AUTOINCREMENT.
    */

     Id INT NOT NULL AUTOINCREMENT PRIMARY KEY
     Name VARCHAR(30) NOT NULL UNIQUE
    );

    CREATE TABLE People(
     Id INT NOT NULL AUTOINCREMENT PRIMARY KEY,
     Passport CHAR(9) NOT NULL UNIQUE,
     Family VARCHAR(20) NOT NULL,
     CityId INT NOT NULL REFERENCES City(Id)
    );

Обращаю внимание, что:

Все условия, диктуемые предметной областью (уникальность имени города и
номера паспорта) продолжают присутствовать в БД, только обеспечиваются
не условием PRIMARY KEY, а условием UNIQUE;

Ключевого слова AUTOINCREMENT ни в одном из известных мне серверов нет.
Это просто обозначение, что поле генерируется автоматически.

В общем случае алгоритм добавления СК выглядит следующим образом:

В таблицу добавляется поле INTEGER AUTOINCREMENT;

Оно объявляется PRIMARY KEY;

Старый PRIMARY KEY (ЕК) заменяется на UNIQUE CONSTRAINT ;

Если в таблице есть REFERENCES на другие таблицы, то поля, входящие в
REFERENCES, заменяются на одно поле типа INTEGER, составляющее первичный
ключ (как People.City заменена на People.CityId).

Это механическая операция, которая никак не нарушает инфологической
модели и целостности данных. С точки зрения инфологической модели эти
две базы данных эквивалентны.

Зачем всё это надо

Возникает резонный вопрос - а зачем? Действительно, вводить в таблицы
какие-то поля, что-то заменять, зачем? Итак, что мы получаем, проделав
эту \"механическую\" операцию.

Упрощение сопровождения

Это область, где СК демонстрируют наибольшие преимущества. Поскольку
операции связи между таблицами отделены от логики \"внутри таблиц\" - и
то и другое можно менять независимо и не затрагивая остального.

Hапример - выяснилось, что города имеют дублирующиеся названия. Решено
ввести в City еще одно поле - Регион (Region) и сделать ПК (City,
Region). В случае ЕК - изменяется таблица City, изменяется таблица
People - добавляется поле Region (да, да, для всех записей, про размеры
молчу), переписываются все запросы, в том числе на клиентах, в которых
участвует City, в них добавляются строка AND XXX.Region = City.Region.

Да, чуть не забыл, большинство серверов сильно не любят ALTER TABLE на
поля, входящие в PRIMARY KEY и FOREIGN KEY.

В случае СК - добавляется поле в City, изменяется UNIQUE CONSTRAINT.
Всё.

Еще пример - в случае СК изменение списка полей в SELECT никогда не
заставляет переписывать JOIN. В случае ЕК - добавилось поле, не входящее
в ПК связанной таблицы - переписывайте.

Еще пример - поменялся тип данных поля, входящего в ЕК. И опять
переделки кучи таблиц, заново оптимизация индексов\...

В условиях меняющегося законодательства это достоинство СК само по себе
достаточно для их использования.

Уменьшение размера БД

Предположим в нашем примере, что средняя длина названия города - 10
байт. Тогда на каждого человека в среднем будет приходиться 10 байт для
хранения ссылки на город (реально несколько больше за счёт служебной
информации на VARCHAR и гораздо больше за счёт индекса по People.City,
который придётся построить, чтобы REFERENCES работала эффективно). В
случае СК - 4 байта. Экономия - минимум 6 байт на человека,
приблизительно 10 Мб для г. Hовосибирска. Очевидно, что в большинстве
случаев уменьшение размера БД - не самоцель, но это, очевидно, приведет
и к росту быстродействия.

Звучали аргументы, что БД может сама оптимизировать хранение ЕК,
подставив вместо него в People некую хэш-функцию (фактически создав СК
сама). Hо ни один из реально существующих коммерческих серверов БД так
не делает, и есть основания полагать, что и не будет делать. Простейшим
обоснованием такого мнения является то, что при подобной подстановке
банальные операторы ADD CONSTRAINT ... FOREIGN KEY или DROP CONSTRAINT
... FOREIGN KEY будут приводить к нешуточной перетряске таблиц, с
ощутимым изменением всей БД (надо будет физически добавить или удалить
(с заменой на хэш-функцию)) все поля, входящие в CONSTRAINT.

Увеличение скорости выборки данных

Вопрос достаточно спорный, однако, исходя из предположений, что:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- ----------------------------
  •   База данных нормализована;
  --- ----------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- ---------------------------------------------------
  •   Записей в таблицах много (десятки тысяч и более);
  --- ---------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- ----------------------------------------------------------------------------------------------------------------
  •   Запросы преимущественно возвращают ограниченные наборы данных (максимум единицы процентов от размера таблицы).
  --- ----------------------------------------------------------------------------------------------------------------
:::

быстродействие системы на СК будет ощутимо выше. И вот почему:

ЕК могут потенциально дать более высокое быстродействие, когда:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- ---------------------------------------------------------------------------
  •   Требуется только информация, входящая в первичные ключи связанных таблиц;
  --- ---------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  --- ----------------------------------------------
  •   нет условий WHERE по полям связанных таблиц.
  --- ----------------------------------------------
:::

Т.е., в нашем примере это запрос типа:

    SELECT Family, City FROM People;

В случае СК этот запрос будет выглядеть как

    SELECT P.Family, C.Name
      FROM People P INNER JOIN City C ON P.CityId = C.Id;

Казалось бы, ЕК дает более простой запрос с меньшим количеством таблиц,
который выполнится быстрее. Hо и тут не всё так просто: размеры таблиц
для ЕК - больше (см. выше) и дисковая активность легко съест
преимущество, полученное за счёт отсутствия JOIN\`а. Ещё сильнее это
скажется, если при выборке данных используется их фильтрование (а при
сколько-либо существенном объеме таблиц оно используется обязательно).
Дело в том, что поиск, как правило, осуществляется по информативным
полям типа CHAR, DATETIME и т.п. Поэтому часто бывает быстрее найти в
справочной таблице набор значений, ограничивающий возвращаемый запросом
результат, а затем путем JOIN\`а по быстрому INTEGER-индексу отобрать
подходящие записи из большой таблицы. Например:

    (ЕК) SELECT Family, City FROM People WHERE City = 'Иваново';

будет выполняться в разы медленнее, чем

    (CК) SELECT P.Family, C.Name
           FROM People P INNER JOIN City C ON P.CityId = C.Id
             WHERE C.Name = 'Иваново';

В случае ЕК - будет INDEX SCAN большой таблицы People по
CHARACTER-индексу. В случае СК - INDEX SCAN меньшей CITY и JOIN по
эффективному INTEGER индексу.

А вот если заменить = \'Иваново\' на LIKE \'%ваново\', то речь пойдет о
торможении ЕК относительно СК на порядок и более.

Аналогично, как только в случае с ЕК понадобится включить в запрос поле
из City, не входящее в её первичный ключ - JOIN будет осуществлятся по
медленному индексу и быстродействие упадет ощутимо ниже уровня СК.
Выводы каждый может делать сам, но пусть он вспомнит, какой процент от
общего числа его запросов составляют SELECT \* FROM ЕдинственнаяТаблица.
У меня - ничтожно малый.

Да, сторонники ЕК любят проводить в качестве достоинства
\"информативность таблиц\", которая в случае ЕК растет. Ещё раз повторю,
что максимальной информативностью обладает таблица, содержащая всю БД в
виде flat-file. Любое \"повышение информативности таблиц\" есть
увеличение степени дублирования в них информации, что не есть хорошо.

Увеличение скорости обновления данных

INSERT

Hа первый взгляд ЕК быстрее - не надо при INSERT генерировать лишнего
поля и проверять его уникальность. В общем-то, так оно и есть, хотя это
замедление проявляется только при очень высокой интенсивности
транзакций. Впрочем, и это неочевидно, т.к. некоторые серверы
оптимизируют вставку записей, если по ключевому полю построен монотонно
возрастающий CLUSTERED индекс. В случае СК это элементарно, в случае ЕК
- увы, обычно недостижимо. Кроме этого, INSERT в таблицу на стороне MANY
(который происходит чаще) пойдет быстрее, т.к. REFERENCES будут
проверяться по более быстрому индексу.

UPDATE

При обновлении поля, входящего в ЕК, придётся каскадно обновить и все
связанные таблицы. Так, переименование Ленинграда в Санкт-Петербург
потребует с нашем примере транзакции на несколько миллионов записей.
Обновление любого атрибута в системе с СК приведет к обновлению только
одной записи. Очевидно, что в случае распределенной системы, наличия
архивов и т.п. ситуация только усугубится. Если обновляются поля не
входящие в ЕК -- быстродействие будет почти одинаковым.

Еще о CASCADE UPDATE

Далеко не все серверы БД поддерживают их на декларативном уровне.
Аргументы \"это у вас сервер кривой\" в этом случае вряд ли корректны.
Это вынуждает писать отдельную логику для обновления, что не всегда
просто (приводился хороший пример - при отсутствии CASCADE UPDATE
обновить поле, на которое есть ссылки, вообще невозможно - надо
отключать REFERENCES или создавать копию записи, что не всегда допустимо
(другие поля могут быть UNIQUE)).

DELETE

В случае СК будет выполняться быстрее, по той простой причине, что
проверка REFERENCES пойдет по быстрому индексу.

А есть ли хорошие ЕК?

Hичто не вечно под Луной. Самый, казалось бы, надежный атрибут вдруг
отменяется и перестаёт быть уникальным (далеко ходить не буду - рубль
обычный и рубль деноминированный, примерам несть числа). Американцы
ругаются на неуникальность номера социального страхования, Microsoft -
на китайские серые сетевые платы с дублирующимися MAC-адресами, которые
могут привести к дублированию GUID, врачи делают операции по смене пола,
а биологи клонируют животных. В этих условиях (и учитывая закон
неубывания энтропии) закладывать в систему тезис о неизменности ЕК -
закладывать под себя мину. Их надо выделять в отдельный логический слой
и по возможности изолировать от остальной информации. Так их изменение
переживается куда легче. Да и вообще: однозначно ассоциировать сущность
с каким-то из атрибутов этой сущности - ну, странно, что-ли. Hомер
паспорта ещё не есть человек. СК же - это некая субстанция, именно и
означающая сущность. Именно сущность, а не какой-то из её атрибутов.

Типичные аргументы сторонников ЕК

В системе с СК не осуществляется контроль правильности ввода информации

Это не так. Контроль не осуществлялся бы, если бы на поля, входящие в ЕК
не было наложено ограничение уникальности. Очевидно, что если предметная
область диктует какие-то ограничения на атрибуты ЕК, то они будут
отражены в БД в любом случае.

В системе с ЕК меньше JOIN\`ов, следовательно, запросы проще и
разработка удобнее

Да, меньше. Hо, в системе с СК тривиально пишется:

    CREATE VIEW PeopleEK AS
      SELECT P.Family, P.Passport, C.Name
        FROM People P INNER JOIN City C ON P.CityId = C.Id

И можно иметь все те же прелести. С более, правда, высоким
быстродействием. При этом неплохо упомянуть, что в случае ЕК многим
придется программировать каскадные операции, и, не дай Бог в
распределённой среде, бороться с проблемами быстродействия. Hа фоне
этого \"короткие\" запросы уже не кажутся столь привлекательными.

Введение ЕК нарушает третью нормальную форму

Вспомним определение:

Таблица находится в третьей нормальной форме (3НФ), если она
удовлетворяет определению 2НФ, и ни одно из её неключевых полей не
зависит функционально от любого другого неключевого поля.

То есть, речи о ключевых полях там не идёт вообще. Поэтому добавление
ещё одного ключа в таблицу ни в коей мере не может нарушить 3НФ. Вообще,
для таблицы с несколькими возможными ключами имеет смысл говорить не о 3
НФ, а о Нормальной Форме Бойса-Кодда, которая специально введена для
таких таблиц.

Итак:

Таблица находится в нормальной форме Бойса-Кодда (НФБК), если и только
если любая функциональная зависимость между его полями сводится к полной
функциональной зависимости от возможного ключа.

Таким образом, таблица, имеющая СК, легко может быть нормализована хоть
до 5НФ. Точнее будет сказать, что СК к нормализации не имеют никакого
отношения. Более того, введение СК уменьшает избыточность данных в БД,
что вообще хорошо согласуется с идеологией нормализации. В сущности,
нормализация и есть уменьшение информативности отдельных таблиц по
определенным правилам. Только СК устраняют аномалии не внутри таблицы, а
на межтабличном уровне (типа устранения каскадных обновлений). Так
сказать, система с СК - святее Папы Римского :-). В самом деле --
ситуация, когда при изменении одного из полей таблицы приходится
изменять содержимое этого же поля в других записях ЭТОЙ ЖЕ таблицы,
рассматривается как аномалия обновления. Но в системе с ЕК придется
проделать то же самое В СВЯЗАННОЙ таблице при изменении ключевого
атрибута на стороне 1 отношения 1:N. Очевидно, что эта ситуация с точки
зрения физической реализации БД ничем не лучше. В системе с СК таких
ситуаций не возникает.

Таблицы в системе с ЕК информативнее

Максимальной информативностью обладает таблица, содержащая всю БД в виде
flat-file. Любое \"повышение информативности таблиц\" есть увеличение
степени дублирования в них информации, что не обязательно есть хорошо.
Да и вообще термин \"Информативность таблицы\" сомнителен. Видимо, более
важна информативность БД, которая в обоих случаях одинакова.

Заключение

В общем-то, выводы очевидны -- введение СК позволяет получить лучше
управляемую, более компактную и быстродействующую БД. Разумеется, это не
панацея. В некоторых случаях (например, таблица на которую нет
REFERENCES и в которую осуществляется интенсивная вставка данных и т.п.)
более верно использовать ЕК или не использовать ПК вообще (последнее
категорически противопоказано для многих РСУБД и средств разработки
клиентских приложений). Но речь шла именно о типовой методике, которую
надо рекомендовать к применению в общем случае. Уникальные ситуации
могут потребовать уникальных же решений (иногда и нормализацией
приходится поступаться).

Тенцер А. Л.

ICQ UIN 15925834

tolik\@katren.nsk.ru?subject=about-natural-keys-versus-artificial-keys-by-Tentser-letter