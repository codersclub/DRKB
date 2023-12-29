---
Title: О системных таблицах InterBase
Date: 01.01.2007
---


О системных таблицах InterBase
==============================

::: {.date}
01.01.2007
:::

О системных таблицах InterBase

Смирнов Александр
www.idbsoft.nnov.ru

idbsoft\@online.ru

 

Введение

Данная небольшая статья является небольшим расширением или дополнением к
приведенным ранее заметкам о системных таблицах InterBase
(www.idbsoft.nnov.ru/down/ib\_systables.pdf). В ней я постарался
привести все запросы в более общем виде.

Различные базы данных, базирующиеся на сервере InterBase, могут
содержать различное количество таблиц, представлений, процедур,
триггеров и других объектов. Но их описание, определение их
взаимодействия и ограничений, наложенных на объекты, описаны в конечном
наборе служебных таблиц базы данных.

Служебные таблицы создаются сервером InterBase при создании базы данных
и поддерживаются им в процессе всей жизни базы. От версии к версии их
количество увеличивается, предоставляя нам возможность простыми
способами узнавать информацию об объектах базы и ее текущем состоянии.

Сервер InterBase сам управляет содержимым этих таблиц и использует его
для управления пользовательскими объектами базы данных. Поэтому я не
рекомендовал бы вносить изменения в их содержание, наоборот, нужно
принять все меры для ограничения доступа к ним.

Однако, при необходимости, можно извлечь из служебных таблиц достаточно
много полезной информации, имея права на чтение из них.

Псевдонимы типов (Домены)

В псевдониме типа сосредоточено много информации о том поле таблицы,
которое базируется на нем. Часть из них определяет поля служебных
таблиц, остальные описывают поля пользовательских таблиц. Домены могут
быть созданы пользователями и, в дальнейшем, использоваться для описания
полей, создаваемых таблиц. Если при создании таблиц не используются
пользовательские домены, то сервер сам автоматически создаст домены для
каждого поля таблицы. Имена таких доменов, а также доменов для служебных
таблиц, начинаются с RDB$. Не стоим указывать такой префикс при
создании пользовательских доменов.

Практически вся информация о доменах хранится в таблице RDB$FIELDS.
Попробуем получить максимум информации из этой таблицы. Приведенный ниже
запрос возвращает данные обо всех доменах базы данных.

    SELECT RDB$FIELDS.RDB$FIELD_NAME, RDB$FIELDS.RDB$QUERY_NAME,
           RDB$FIELDS.RDB$VALIDATION_BLR, 
     RDB$FIELDS.RDB$VALIDATION_SOURCE,
           RDB$FIELDS.RDB$COMPUTED_BLR, RDB$FIELDS.RDB$COMPUTED_SOURCE,
           RDB$FIELDS.RDB$DEFAULT_VALUE, RDB$FIELDS.RDB$DEFAULT_SOURCE,
           RDB$FIELDS.RDB$FIELD_LENGTH, RDB$FIELDS.RDB$FIELD_SCALE,
           RDB$FIELDS.RDB$FIELD_TYPE, RDB$FIELDS.RDB$FIELD_SUB_TYPE,
           RDB$FIELDS.RDB$MISSING_VALUE, RDB$FIELDS.RDB$MISSING_SOURCE,
           RDB$FIELDS.RDB$DESCRIPTION, RDB$FIELDS.RDB$SYSTEM_FLAG,
           RDB$FIELDS.RDB$QUERY_HEADER, RDB$FIELDS.RDB$SEGMENT_LENGTH,
           RDB$FIELDS.RDB$EDIT_STRING, RDB$FIELDS.RDB$EXTERNAL_LENGTH,
           RDB$FIELDS.RDB$EXTERNAL_SCALE, RDB$FIELDS.RDB$EXTERNAL_TYPE,
           RDB$FIELDS.RDB$DIMENSIONS, RDB$FIELDS.RDB$NULL_FLAG,
           RDB$FIELDS.RDB$CHARACTER_LENGTH, RDB$FIELDS.RDB$COLLATION_ID,
           RDB$FIELDS.RDB$CHARACTER_SET_ID, RDB$FIELDS.RDB$FIELD_PRECISION
    FROM RDB$FIELDS;

Наиболее интересными полями в этом запросе являются: RDB$FIELD\_NAME -
наименование домена; RDB$VALIDATION\_SOURCE - текст проверок вводимых
данных; RDB$COMPUTED\_SOURCE - текст формулы для вычислимых полей;
RDB$DEFAULT\_SOURCE - значение по умолчанию; RDB$FIELD\_LENGTH,
RDB$FIELD\_SCALE, RDB$FIELD\_TYPE - величина и тип домена;
RDB$SYSTEM\_FLAG - признак того, что домен пользовательский (0) или
созданный сервером (1); RDB$NULL\_FLAG - возможно или нет (1) наличие
значения NULL.

Предыдущий запрос выдавал информацию обо всех доменах базы данных. Чаще
всего бывает интересно проанализировать пользовательские домены.
Следующий пример запроса выдает наиболее интересную информацию только о
доменах, созданных пользователем.

    SELECT RDB$FIELDS.RDB$FIELD_NAME, RDB$FIELDS.RDB$COMPUTED_SOURCE,
           RDB$FIELDS.RDB$DEFAULT_SOURCE, RDB$FIELDS.RDB$FIELD_LENGTH,
           RDB$FIELDS.RDB$FIELD_SCALE, RDB$FIELDS.RDB$FIELD_TYPE,
           RDB$FIELDS.RDB$FIELD_SUB_TYPE, RDB$FIELDS.RDB$DESCRIPTION,
           RDB$FIELDS.RDB$SYSTEM_FLAG, RDB$FIELDS.RDB$DIMENSIONS,
           RDB$FIELDS.RDB$NULL_FLAG, RDB$FIELDS.RDB$CHARACTER_LENGTH,
           RDB$FIELDS.RDB$COLLATION_ID, RDB$FIELDS.RDB$CHARACTER_SET_ID,
           RDB$FIELDS.RDB$FIELD_PRECISION
    FROM RDB$FIELDS
    WHERE (RDB$FIELDS.RDB$SYSTEM_FLAG = 0);

Некоторые параметры (на пример тип) представлены в виде кодов. У этих
кодов есть расшифровка, которая содержится в таблице RDB$TYPES. Вот
пример, который позволяет посмотреть текстовое описание типа домена.

    SELECT RDB$FIELDS.RDB$FIELD_NAME, RDB$FIELDS.RDB$COMPUTED_SOURCE,
           RDB$FIELDS.RDB$DEFAULT_SOURCE, RDB$FIELDS.RDB$FIELD_LENGTH,
           RDB$FIELDS.RDB$FIELD_SCALE, RDB$FIELDS.RDB$FIELD_TYPE,
           RDB$TYPES.RDB$TYPE_NAME, RDB$FIELDS.RDB$FIELD_SUB_TYPE,
           RDB$FIELDS.RDB$DESCRIPTION, RDB$FIELDS.RDB$SYSTEM_FLAG,
           RDB$FIELDS.RDB$DIMENSIONS, RDB$FIELDS.RDB$NULL_FLAG,
           RDB$FIELDS.RDB$CHARACTER_LENGTH, RDB$FIELDS.RDB$COLLATION_ID,
           RDB$FIELDS.RDB$CHARACTER_SET_ID, RDB$FIELDS.RDB$FIELD_PRECISION
    FROM RDB$FIELDS
       LEFT OUTER JOIN RDB$TYPES ON
        (RDB$FIELDS.RDB$FIELD_TYPE = RDB$TYPES.RDB$TYPE)
    WHERE 
       ((RDB$FIELDS.RDB$SYSTEM_FLAG = 0)
       and 
        (RDB$TYPES.RDB$FIELD_NAME = 'RDB$FIELD_TYPE'));

В полях базы данных InterBase могут храниться массивы, соответственно
можно определить домен, который будет содержать информацию о массиве.
Следующий запрос выбирает именно такие домены и выдает информацию о
размерности и границах массива. Информация о размерности массива
содержится в таблице RDB$FIELD\_DIMENSIONS.

    SELECT RDB$FIELDS.RDB$FIELD_NAME, RDB$FIELDS.RDB$COMPUTED_SOURCE,
           RDB$FIELDS.RDB$DEFAULT_SOURCE, RDB$FIELDS.RDB$FIELD_LENGTH,
           RDB$FIELDS.RDB$FIELD_SCALE, RDB$FIELDS.RDB$FIELD_TYPE,
           RDB$TYPES.RDB$TYPE_NAME, RDB$FIELDS.RDB$FIELD_SUB_TYPE,
           RDB$FIELDS.RDB$DESCRIPTION, RDB$FIELDS.RDB$DIMENSIONS,
           RDB$FIELD_DIMENSIONS.RDB$DIMENSION,
           RDB$FIELD_DIMENSIONS.RDB$LOWER_BOUND,
           RDB$FIELD_DIMENSIONS.RDB$UPPER_BOUND
    FROM RDB$FIELDS
       INNER JOIN RDB$FIELD_DIMENSIONS ON 
         (RDB$FIELDS.RDB$FIELD_NAME = RDB$FIELD_DIMENSIONS.RDB$FIELD_NAME)
       LEFT OUTER JOIN RDB$TYPES ON 
         (RDB$FIELDS.RDB$FIELD_TYPE = RDB$TYPES.RDB$TYPE)
    WHERE 
       ((RDB$FIELDS.RDB$SYSTEM_FLAG = 0) and 
        (RDB$TYPES.RDB$FIELD_NAME = 'RDB$FIELD_TYPE'));

При создании текстовых полей можно указать кодировку, в которой будет
храниться текст. Соответственно, можно и посмотреть, какая кодовая
страница задана для конкретного поля. Информация о кодовых страницах
хранится в таблице RDB$CHARACTER\_SETS.

    SELECT RDB$FIELDS.RDB$FIELD_NAME, RDB$FIELDS.RDB$COMPUTED_SOURCE,
           RDB$FIELDS.RDB$DEFAULT_SOURCE, RDB$FIELDS.RDB$FIELD_LENGTH,
           RDB$FIELDS.RDB$FIELD_SCALE, RDB$FIELDS.RDB$FIELD_TYPE,
           RDB$TYPES.RDB$TYPE_NAME, RDB$FIELDS.RDB$FIELD_SUB_TYPE,
           RDB$FIELDS.RDB$DESCRIPTION, RDB$FIELDS.RDB$DIMENSIONS,
           RDB$FIELDS.RDB$CHARACTER_SET_ID,
           RDB$CHARACTER_SETS.RDB$CHARACTER_SET_NAME
    FROM RDB$FIELDS
       LEFT OUTER JOIN RDB$TYPES ON 
         (RDB$FIELDS.RDB$FIELD_TYPE = RDB$TYPES.RDB$TYPE)
       LEFT OUTER JOIN RDB$CHARACTER_SETS ON
         (RDB$FIELDS.RDB$CHARACTER_SET_ID = RDB$CHARACTER_SETS.RDB$CHARACTER_SET_ID)
    WHERE 
       ((RDB$FIELDS.RDB$SYSTEM_FLAG = 0)
       and 
        (RDB$TYPES.RDB$FIELD_NAME = 'RDB$FIELD_TYPE'));

Таблицы

Таблицы и представления близки между собой по \"внешнему виду\", не
смотря на то, что по сути своей это разные объекты. Но мы часто
обращаемся к ним в базе данных, используя аналогичные конструкции языка,
и не задумываемся об их внутренней организации. Видимо это
обстоятельство и послужило основой тому, что информация о них хранится в
служебных таблицах вместе.

Приведенный запрос позволяет получить перечень таблиц и представлений,
исходный код представлений, их описание, данное пользователем, имя,
количество полей и хозяина таблицы или представления.

    SELECT RDB$RELATIONS.RDB$VIEW_SOURCE, RDB$RELATIONS.RDB$DESCRIPTION,
           RDB$RELATIONS.RDB$RELATION_NAME, RDB$RELATIONS.RDB$FIELD_ID,
           RDB$RELATIONS.RDB$OWNER_NAME
    FROM RDB$RELATIONS
    WHERE 
       (
          (RDB$RELATIONS.RDB$SYSTEM_FLAG = 0)
       )
    ORDER BY RDB$RELATIONS.RDB$RELATION_NAME;

Выражение RDB$RELATIONS.RDB$SYSTEM\_FLAG = 0 позволят отобрать только
объекты, созданные пользователем.

Наложив на запрос еще одно условие (RDB$RELATIONS.RDB$VIEW\_SOURCE IS
NULL), можно получить перечень только таблиц.

    SELECT RDB$RELATIONS.RDB$DESCRIPTION, RDB$RELATIONS.RDB$RELATION_NAME,
           RDB$RELATIONS.RDB$FIELD_ID, RDB$RELATIONS.RDB$OWNER_NAME
    FROM RDB$RELATIONS
    WHERE 
       ((RDB$RELATIONS.RDB$SYSTEM_FLAG = 0)
       and 
        (RDB$RELATIONS.RDB$VIEW_SOURCE IS NULL ))
    ORDER BY RDB$RELATIONS.RDB$RELATION_NAME;

Замена описанного выше условия на обратное
(RDB$RELATIONS.RDB$VIEW\_SOURCE IS NOT NULL) позволит получить только
перечень представлений.

    SELECT RDB$RELATIONS.RDB$DESCRIPTION, RDB$RELATIONS.RDB$VIEW_SOURCE,
           RDB$RELATIONS.RDB$RELATION_NAME, RDB$RELATIONS.RDB$FIELD_ID,
           RDB$RELATIONS.RDB$OWNER_NAME
    FROM RDB$RELATIONS
    WHERE 
       ((RDB$RELATIONS.RDB$SYSTEM_FLAG = 0)
       and 
        (RDB$RELATIONS.RDB$VIEW_SOURCE IS NOT NULL ))
    ORDER BY RDB$RELATIONS.RDB$RELATION_NAME;

Каждое изменение методанных таблицы фиксируется сервером в таблице
RDB$FORMATS и таких изменений может быть только 256. По достижении
данной границы необходимо выполнить backup/restore для сброса этих
счетчиков.

Приведенный ниже запрос позволяет нам узнать, сколько уже было сделано
изменений для каждой таблицы.

    SELECT RDB$RELATIONS.RDB$RELATION_NAME,
           MAX( RDB$FORMATS.RDB$FORMAT ) MAX_OF_RDB$FORMAT
    FROM RDB$RELATIONS
       INNER JOIN RDB$FORMATS ON 
         (RDB$RELATIONS.RDB$RELATION_ID = RDB$FORMATS.RDB$RELATION_ID)
    WHERE 
       ((RDB$RELATIONS.RDB$SYSTEM_FLAG = 0)
       and 
        (RDB$RELATIONS.RDB$VIEW_SOURCE IS NULL))
    GROUP BY RDB$RELATIONS.RDB$RELATION_NAME
    ORDER BY RDB$RELATIONS.RDB$RELATION_NAME;

Все таблицы состоят из полей. Посмотрим, из каких полей состоит та или
иная таблица. Информация о полях таблиц содержится в служебной таблице
RDB$RELATION\_FIELDS. Приведенный ниже запрос выдаст имя таблицы, имя
поля, порядковый номер поля в таблице, имя домена (RDB$FIELD\_SOURCE),
на котором данное поле базируется, возможность ввести NULL
(RDB$NULL\_FLAG \<\> 1) и значение по умолчанию.

    SELECT RDB$RELATIONS.RDB$RELATION_NAME, RDB$RELATION_FIELDS.RDB$FIELD_NAME,
           RDB$RELATION_FIELDS.RDB$FIELD_POSITION,
           RDB$RELATION_FIELDS.RDB$FIELD_SOURCE, RDB$RELATION_FIELDS.RDB$NULL_FLAG,
           RDB$RELATION_FIELDS.RDB$DEFAULT_SOURCE
    FROM RDB$RELATION_FIELDS
       INNER JOIN RDB$RELATIONS ON
        (RDB$RELATION_FIELDS.RDB$RELATION_NAME = RDB$RELATIONS.RDB$RELATION_NAME)
    WHERE 
       ((RDB$RELATIONS.RDB$SYSTEM_FLAG = 0)
       and 
        (RDB$RELATIONS.RDB$VIEW_SOURCE IS NULL))
    ORDER BY RDB$RELATIONS.RDB$RELATION_NAME,
             RDB$RELATION_FIELDS.RDB$FIELD_POSITION; 

Если включить в запрос информацию из таблицы RDB$FIELDS (описание
доменов), то можно получить дополнительную информацию о каждом поле.
Такой информацией может быть выражение для вычислимых полей и тип поля
базы данных.

    SELECT RDB$RELATIONS.RDB$RELATION_NAME,
           RDB$RELATION_FIELDS.RDB$FIELD_NAME,
           RDB$RELATION_FIELDS.RDB$FIELD_POSITION,
           RDB$RELATION_FIELDS.RDB$FIELD_SOURCE,
           RDB$RELATION_FIELDS.RDB$NULL_FLAG,
           RDB$RELATION_FIELDS.RDB$DEFAULT_SOURCE,
           RDB$FIELDS.RDB$COMPUTED_SOURCE, RDB$FIELDS.RDB$DEFAULT_SOURCE,
           RDB$FIELDS.RDB$FIELD_TYPE, RDB$FIELDS.RDB$NULL_FLAG
    FROM RDB$RELATIONS
    INNER JOIN RDB$RELATION_FIELDS ON
          (RDB$RELATIONS.RDB$RELATION_NAME = RDB$RELATION_FIELDS.RDB$RELATION_NAME)
    INNER JOIN RDB$FIELDS ON
          (RDB$RELATION_FIELDS.RDB$FIELD_SOURCE = RDB$FIELDS.RDB$FIELD_NAME)
    WHERE
    ((RDB$RELATIONS.RDB$SYSTEM_FLAG = 0)
    and
    (RDB$RELATIONS.RDB$VIEW_SOURCE IS NULL))
    ORDER BY RDB$RELATIONS.RDB$RELATION_NAME, RDB$RELATION_FIELDS.RDB$FIELD_POSITION;

Приведенный ниже запрос написан с включением в него таблицы RDB$TYPES,
из которой можно получить текстовое описание типа поля.

    SELECT RDB$RELATIONS.RDB$RELATION_NAME,
           RDB$RELATION_FIELDS.RDB$FIELD_NAME,
           RDB$RELATION_FIELDS.RDB$FIELD_POSITION,
           RDB$RELATION_FIELDS.RDB$FIELD_SOURCE,
           RDB$RELATION_FIELDS.RDB$NULL_FLAG,
           RDB$RELATION_FIELDS.RDB$DEFAULT_SOURCE,
           RDB$FIELDS.RDB$COMPUTED_SOURCE,
           RDB$FIELDS.RDB$DEFAULT_SOURCE, RDB$FIELDS.RDB$NULL_FLAG,
           RDB$FIELDS.RDB$FIELD_TYPE, RDB$TYPES.RDB$TYPE_NAME,
           RDB$FIELDS.RDB$FIELD_SUB_TYPE, RDB$FIELDS.RDB$FIELD_LENGTH,
           RDB$FIELDS.RDB$FIELD_SCALE
    FROM RDB$RELATIONS
       INNER JOIN RDB$RELATION_FIELDS ON
             (RDB$RELATIONS.RDB$RELATION_NAME = RDB$RELATION_FIELDS.RDB$RELATION_NAME)
       INNER JOIN RDB$FIELDS ON
             (RDB$RELATION_FIELDS.RDB$FIELD_SOURCE = RDB$FIELDS.RDB$FIELD_NAME)
       INNER JOIN RDB$TYPES ON
             (RDB$FIELDS.RDB$FIELD_TYPE = RDB$TYPES.RDB$TYPE)
    WHERE 
       ((RDB$RELATIONS.RDB$SYSTEM_FLAG = 0)
       and 
        (RDB$RELATIONS.RDB$VIEW_SOURCE IS NULL )
       and 
        (RDB$TYPES.RDB$FIELD_NAME = 'RDB$FIELD_TYPE'))
    ORDER BY RDB$RELATIONS.RDB$RELATION_NAME, RDB$RELATION_FIELDS.RDB$FIELD_POSITION;

Следующий простой запрос покажет количество полей в таблицах.

    SELECT RDB$RELATIONS.RDB$RELATION_NAME,
           count(RDB$RELATION_FIELDS.rdb$field_name) KOL
    FROM RDB$RELATIONS
       INNER JOIN RDB$RELATION_FIELDS ON
             (RDB$RELATIONS.RDB$RELATION_NAME = RDB$RELATION_FIELDS.RDB$RELATION_NAME)
    WHERE 
       ((RDB$RELATIONS.RDB$SYSTEM_FLAG = 0)
       and 
        (RDB$RELATIONS.RDB$VIEW_SOURCE IS NULL))
    GROUP BY RDB$RELATIONS.RDB$RELATION_NAME
    ORDER BY RDB$RELATIONS.RDB$RELATION_NAME;

А этот запрос, аналогичный предыдущему, выдает количество полей, на
которых построены запросы.

    SELECT RDB$RELATIONS.RDB$RELATION_NAME,
           count(RDB$RELATION_FIELDS.rdb$field_name) KOL
    FROM RDB$RELATIONS
       INNER JOIN RDB$RELATION_FIELDS ON
        (RDB$RELATIONS.RDB$RELATION_NAME = RDB$RELATION_FIELDS.RDB$RELATION_NAME)
    WHERE 
       ((RDB$RELATIONS.RDB$SYSTEM_FLAG = 0)
       and 
        (RDB$RELATIONS.RDB$VIEW_SOURCE IS NOT NULL))
    GROUP BY RDB$RELATIONS.RDB$RELATION_NAME
    ORDER BY RDB$RELATIONS.RDB$RELATION_NAME;

Приведу пример запроса для просмотра прав, выданных в базе данных,
пользователям на таблицы. Для этого воспользуемся информацией из таблицы
RDB$USER\_PRIVILEGES.

Вот краткое пояснение к получившемуся результату:
RDB$USER\_PRIVILEGES.RDB$USER - кому выдана привилегия,
RDB$USER\_PRIVILEGES.RDB$GRANTOR - тот, кто выдал привилегию,
RDB$USER\_PRIVILEGES.RDB$PRIVILEGE - какая привилегия была выдана и
было ли выражение WITH GRANT OPTION
(RDB$USER\_PRIVILEGES.RDB$GRANT\_OPTION = 1).

    SELECT RDB$RELATIONS.RDB$RELATION_NAME, RDB$USER_PRIVILEGES.RDB$USER,
           RDB$USER_PRIVILEGES.RDB$GRANTOR,
           RDB$USER_PRIVILEGES.RDB$PRIVILEGE,
           RDB$USER_PRIVILEGES.RDB$GRANT_OPTION
    FROM RDB$RELATIONS
       INNER JOIN RDB$USER_PRIVILEGES ON
        (RDB$RELATIONS.RDB$RELATION_NAME = RDB$USER_PRIVILEGES.RDB$RELATION_NAME)
    WHERE 
       ((RDB$RELATIONS.RDB$SYSTEM_FLAG = 0)
       and
        (RDB$RELATIONS.RDB$VIEW_SOURCE IS NULL))
    ORDER BY RDB$RELATIONS.RDB$RELATION_NAME,
             RDB$USER_PRIVILEGES.RDB$PRIVILEGE;

При RDB$RELATIONS.RDB$VIEW\_SOURCE IS NOT NULL можно узнать привилегии
для представлений.

Ограничения

При создании базы данных на таблицы могут быть наложены различные
ограничения, это и ограничения ссылочной целостности и всевозможные
проверки вводимых значений и, к примеру, ограничения NOT NULL.

Перечень ограничений можно получить из таблицы
RDB$RELATION\_CONSTRAINTS. Приведенный пример запроса возвращает
наименование ограничения, его тип, наименование таблицы, на которую
данное ограничение распространяется и индекс, если ограничение
базируется на индексе.

    SELECT RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME,
           RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE,
           RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME,
           RDB$RELATION_CONSTRAINTS.RDB$INDEX_NAME
    FROM RDB$RELATION_CONSTRAINTS
    ORDER BY RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME;

Следующий запрос возвращает CHECK ограничения.

    SELECT RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME,
           RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE,
           RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME
    FROM RDB$RELATION_CONSTRAINTS
    WHERE 
       ((RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE = 'CHECK'));

Ограничения, типа CHECK, построены на основе триггеров. Следующий запрос
позволяет получить наименования данных триггеров. Имя триггера находится
в поле RDB$CHECK\_CONSTRAINTS.RDB$TRIGGER\_NAME.

    SELECT RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME,
           RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE,
           RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME,
           RDB$CHECK_CONSTRAINTS.RDB$TRIGGER_NAME
    FROM RDB$RELATION_CONSTRAINTS
       INNER JOIN RDB$CHECK_CONSTRAINTS ON
                  (RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME =
                   RDB$CHECK_CONSTRAINTS.RDB$CONSTRAINT_NAME)
    WHERE 
       ((RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE = 'CHECK'));

Запрос, аналогичный предыдущему, позволяет выбрать NOT NULL ограничения,
а также имена полей таблиц (RDB$CHECK\_CONSTRAINTS.RDB$TRIGGER\_NAME),
на которые они распространены.

    SELECT RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME,
           RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE,
           RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME,
           RDB$CHECK_CONSTRAINTS.RDB$TRIGGER_NAME
    FROM RDB$RELATION_CONSTRAINTS
       INNER JOIN RDB$CHECK_CONSTRAINTS ON
         (RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME =
          RDB$CHECK_CONSTRAINTS.RDB$CONSTRAINT_NAME)
    WHERE 
       ((RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE = 'NOT NULL'))
    ORDER BY RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME;

Ограничения, типа PRIMARY KEY, FOREIGN KEY и UNIQUE, базируются на
индексах. Следующий пример запроса позволяет выбрать такие ограничения
вместе с наименованиями индексов, на которых они базируются.

    SELECT RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME,
           RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE,
           RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME,
           RDB$RELATION_CONSTRAINTS.RDB$INDEX_NAME
    FROM RDB$RELATION_CONSTRAINTS
    WHERE (RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE = 'PRIMARY KEY')
          or (RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE = 'FOREIGN KEY')
          or (RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE = 'UNIQUE')
    ORDER BY RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME;

Таблица RDB$INDICES содержит связи между индексами PRIMARY KEY и
FOREIGN KEY. Используя, эту информацию можно написать запрос, который
покажет связи между таблицами, а также индексы, участвующие в
формировании этих связей.

    SELECT RDB$INDICES.RDB$RELATION_NAME,
           RDB$INDICES.RDB$INDEX_NAME,
           RDB$INDICES1.RDB$RELATION_NAME,
           RDB$INDICES1.RDB$INDEX_NAME
    FROM RDB$INDICES
       INNER JOIN RDB$INDICES RDB$INDICES1
           ON (RDB$INDICES.RDB$FOREIGN_KEY = RDB$INDICES1.RDB$INDEX_NAME)
    ORDER BY RDB$INDICES.RDB$RELATION_NAME;

Изменив предыдущий запрос, а именно добавив в него таблицу
RDB$RELATION\_CONSTRAINTS, можно получить пары master-detail с
информацией об индексах, участвующих в организации связи, и
наименованиях ограничений.

    SELECT RDB$INDICES.RDB$RELATION_NAME,
           RDB$INDICES.RDB$INDEX_NAME,
           RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME,
           RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE,
           RDB$INDICES1.RDB$RELATION_NAME,
           RDB$INDICES1.RDB$INDEX_NAME,
           RDB$RELATION_CONSTRAINTS1.RDB$CONSTRAINT_NAME,
           RDB$RELATION_CONSTRAINTS1.RDB$CONSTRAINT_TYPE
    FROM RDB$INDICES
       INNER JOIN RDB$INDICES RDB$INDICES1 ON
             (RDB$INDICES.RDB$FOREIGN_KEY = RDB$INDICES1.RDB$INDEX_NAME)
       INNER JOIN RDB$RELATION_CONSTRAINTS RDB$RELATION_CONSTRAINTS1 ON
             (RDB$INDICES1.RDB$INDEX_NAME = RDB$RELATION_CONSTRAINTS1.RDB$INDEX_NAME)
       INNER JOIN RDB$RELATION_CONSTRAINTS ON
             (RDB$INDICES.RDB$INDEX_NAME = RDB$RELATION_CONSTRAINTS.RDB$INDEX_NAME)
    ORDER BY RDB$INDICES.RDB$RELATION_NAME;

Таблица RDB$REF\_CONSTRAINTS содержит список всех вторичных ключей с
поставленными в соответствие первичными ключами. Использую этот факт
можно написать еще один вариант запроса, который выдаст пары
master-detail.

    SELECT RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME,
           RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE,
           RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME,
           RDB$RELATION_CONSTRAINTS1.RDB$CONSTRAINT_NAME,
           RDB$RELATION_CONSTRAINTS1.RDB$CONSTRAINT_TYPE,
           RDB$RELATION_CONSTRAINTS1.RDB$RELATION_NAME
    FROM RDB$REF_CONSTRAINTS
       INNER JOIN RDB$RELATION_CONSTRAINTS ON
             (RDB$REF_CONSTRAINTS.RDB$CONSTRAINT_NAME =
              RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME)
       INNER JOIN RDB$RELATION_CONSTRAINTS RDB$RELATION_CONSTRAINTS1 ON
             (RDB$REF_CONSTRAINTS.RDB$CONST_NAME_UQ =
              RDB$RELATION_CONSTRAINTS1.RDB$CONSTRAINT_NAME)
    ORDER BY RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME;

А вот так можно получить пары master-detail с указанием правил поведения
при обновлении и удалении в master таблице.

    SELECT RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME,
           RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_TYPE,
           RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME,
           RDB$RELATION_CONSTRAINTS1.RDB$CONSTRAINT_NAME,
           RDB$RELATION_CONSTRAINTS1.RDB$CONSTRAINT_TYPE,
           RDB$RELATION_CONSTRAINTS1.RDB$RELATION_NAME,
           RDB$REF_CONSTRAINTS.RDB$UPDATE_RULE,
           RDB$REF_CONSTRAINTS.RDB$DELETE_RULE
    FROM RDB$REF_CONSTRAINTS
       INNER JOIN RDB$RELATION_CONSTRAINTS ON
             (RDB$REF_CONSTRAINTS.RDB$CONSTRAINT_NAME =
              RDB$RELATION_CONSTRAINTS.RDB$CONSTRAINT_NAME)
       INNER JOIN RDB$RELATION_CONSTRAINTS RDB$RELATION_CONSTRAINTS1 ON
             (RDB$REF_CONSTRAINTS.RDB$CONST_NAME_UQ =
              RDB$RELATION_CONSTRAINTS1.RDB$CONSTRAINT_NAME)
    ORDER BY RDB$RELATION_CONSTRAINTS.RDB$RELATION_NAME;

Индексы

Индексы являются важными объектами базы данных. Кроме того, что они
обеспечивают некоторые виды ограничений, они позволяют ускорять доступ к
данным и упорядочивать их.

Следующий запрос выбирает из системной таблицы RDB$INDICES индексы,
созданные пользователями, с указанием таблиц, для которых они были
определены.

    SELECT RDB$INDICES.RDB$INDEX_NAME, RDB$INDICES.RDB$RELATION_NAME
    FROM RDB$INDICES
    WHERE 
       (NOT (RDB$INDICES.RDB$INDEX_NAME STARTING WITH 'RDB$'))
    ORDER BY RDB$INDICES.RDB$RELATION_NAME;

Ниже приведен запрос, который выдает основную, наиболее интересную
информацию об индексах. Для уменьшения объема выдаваемой информации
запрос сделан для таблицы SALES.

    SELECT RDB$INDICES.RDB$INDEX_NAME, RDB$INDICES.RDB$RELATION_NAME,
           RDB$INDICES.RDB$UNIQUE_FLAG, RDB$INDICES.RDB$DESCRIPTION,
           RDB$INDICES.RDB$SEGMENT_COUNT, RDB$INDICES.RDB$INDEX_INACTIVE,
           RDB$INDICES.RDB$INDEX_TYPE, RDB$INDICES.RDB$STATISTICS
    FROM RDB$INDICES
    WHERE 
       (
          NOT (RDB$INDICES.RDB$INDEX_NAME STARTING WITH 'RDB$')
          and (RDB$INDICES.RDB$RELATION_NAME = 'SALES')
       )
    ORDER BY RDB$INDICES.RDB$RELATION_NAME;

Следующий запрос, кроме информации о самих индексах, выдает перечни
полей таблиц, на которых построены индексы, а также порядок полей в
индексе.

    SELECT RDB$INDICES.RDB$INDEX_NAME, RDB$INDICES.RDB$RELATION_NAME,
           RDB$INDICES.RDB$UNIQUE_FLAG, RDB$INDICES.RDB$DESCRIPTION,
           RDB$INDICES.RDB$SEGMENT_COUNT, RDB$INDICES.RDB$INDEX_INACTIVE,
           RDB$INDICES.RDB$INDEX_TYPE, RDB$INDICES.RDB$STATISTICS,
           RDB$INDEX_SEGMENTS.RDB$FIELD_NAME,
           RDB$INDEX_SEGMENTS.RDB$FIELD_POSITION
    FROM RDB$INDICES
       INNER JOIN RDB$INDEX_SEGMENTS ON
        (RDB$INDICES.RDB$INDEX_NAME = RDB$INDEX_SEGMENTS.RDB$INDEX_NAME)
    WHERE 
       (
          NOT (RDB$INDICES.RDB$INDEX_NAME STARTING WITH 'RDB$')
          and (RDB$INDICES.RDB$RELATION_NAME = 'SALES')
       )
    ORDER BY RDB$INDICES.RDB$INDEX_NAME, RDB$INDEX_SEGMENTS.RDB$FIELD_POSITION

Триггеры

Триггеры являются откомпилированным кодом, хранимым в базе данных,
который исполняется сервером при возникновении определенных событий
(вставка, удаление и пр.) для таблиц.

Приведенный ниже запрос позволяет выбрать триггеры, определенные
пользователем и не являющиеся базой для CHECK ограничений.

    SELECT RDB$TRIGGERS.RDB$TRIGGER_NAME, RDB$TRIGGERS.RDB$SYSTEM_FLAG
    FROM RDB$TRIGGERS
    WHERE 
       (
          (RDB$TRIGGERS.RDB$SYSTEM_FLAG <> 1)
          and (RDB$TRIGGERS.RDB$TRIGGER_NAME not in
           (SELECT RDB$TRIGGER_NAME FROM RDB$CHECK_CONSTRAINTS))
       );

Следующий запрос аналогичен предыдущему, но он выдает более полную
информацию о триггере: имя триггера, таблица, для которой этот триггер
определен, порядковый номер триггера при выполнении, тип триггера, его
исходный текст и описание, данное пользователем, а также признак
активности.

    SELECT RDB$TRIGGERS.RDB$TRIGGER_NAME, RDB$TRIGGERS.RDB$RELATION_NAME,
           RDB$TRIGGERS.RDB$TRIGGER_SEQUENCE,
           RDB$TRIGGERS.RDB$TRIGGER_TYPE,
           RDB$TRIGGERS.RDB$TRIGGER_SOURCE, RDB$TRIGGERS.RDB$DESCRIPTION,
           RDB$TRIGGERS.RDB$TRIGGER_INACTIVE
    FROM RDB$TRIGGERS
    WHERE 
       (
          (RDB$TRIGGERS.RDB$SYSTEM_FLAG <> 1)
          and (RDB$TRIGGERS.RDB$TRIGGER_NAME not in
           (SELECT RDB$TRIGGER_NAME FROM RDB$CHECK_CONSTRAINTS))
       );

Используя информацию о типах из таблицы RDB$TYPES, получаем расшифровку
типов триггеров.

    SELECT RDB$TRIGGERS.RDB$TRIGGER_NAME, RDB$TRIGGERS.RDB$RELATION_NAME,
           RDB$TRIGGERS.RDB$TRIGGER_SEQUENCE,
           RDB$TRIGGERS.RDB$TRIGGER_TYPE,
           RDB$TYPES.RDB$TYPE_NAME, RDB$TRIGGERS.RDB$TRIGGER_SOURCE,
           RDB$TRIGGERS.RDB$DESCRIPTION, RDB$TRIGGERS.RDB$TRIGGER_INACTIVE
    FROM RDB$TRIGGERS
       INNER JOIN RDB$TYPES ON 
        (RDB$TRIGGERS.RDB$TRIGGER_TYPE = RDB$TYPES.RDB$TYPE)
    WHERE 
       ((RDB$TRIGGERS.RDB$SYSTEM_FLAG <> 1)
          and (RDB$TRIGGERS.RDB$TRIGGER_NAME not in
           (SELECT RDB$TRIGGER_NAME FROM RDB$CHECK_CONSTRAINTS))
          and (RDB$TYPES.RDB$FIELD_NAME = 'RDB$TRIGGER_TYPE')
       )
    ORDER BY RDB$TRIGGERS.RDB$RELATION_NAME, RDB$TRIGGERS.RDB$TRIGGER_SEQUENCE;

Процедуры

Сохраненные процедуры - это готовые части кода, которые хранятся и
выполняются в базе данных на сервере. Приведу несколько примеров,
позволяющих получить информацию о них.

Следующий пример выбирает все процедуры, созданные пользователем.

    SELECT RDB$PROCEDURES.RDB$PROCEDURE_NAME, RDB$PROCEDURES.RDB$SYSTEM_FLAG
    FROM RDB$PROCEDURES
    WHERE 
       (
          (RDB$PROCEDURES.RDB$SYSTEM_FLAG = 0)
       );

Данный запрос позволяет узнать остальную наиболее интересную информацию
о процедурах, кроме наименования: количество входных и выходных
переменных, описание и исходный текст процедуры и хозяина, создавшего
процедуру

    SELECT RDB$PROCEDURES.RDB$PROCEDURE_NAME,
           RDB$PROCEDURES.RDB$PROCEDURE_INPUTS,
           RDB$PROCEDURES.RDB$PROCEDURE_OUTPUTS,
           RDB$PROCEDURES.RDB$DESCRIPTION,
           RDB$PROCEDURES.RDB$PROCEDURE_SOURCE,
           RDB$PROCEDURES.RDB$OWNER_NAME,
           RDB$PROCEDURES.RDB$SYSTEM_FLAG
    FROM RDB$PROCEDURES
    WHERE 
       (
          (RDB$PROCEDURES.RDB$SYSTEM_FLAG = 0)
       );

Следующий запрос, использую информацию из таблицы
RDB$PROCEDURE\_PARAMETERS, выдает сведения о параметрах процедуры.

    SELECT RDB$PROCEDURES.RDB$PROCEDURE_NAME,
           RDB$PROCEDURES.RDB$PROCEDURE_INPUTS,
           RDB$PROCEDURES.RDB$PROCEDURE_OUTPUTS,
           RDB$PROCEDURE_PARAMETERS.RDB$PARAMETER_NAME,
           RDB$PROCEDURE_PARAMETERS.RDB$PARAMETER_NUMBER,
           RDB$PROCEDURE_PARAMETERS.RDB$PARAMETER_TYPE,
           RDB$PROCEDURE_PARAMETERS.RDB$DESCRIPTION
    FROM RDB$PROCEDURES
       LEFT OUTER JOIN RDB$PROCEDURE_PARAMETERS ON
          (RDB$PROCEDURES.RDB$PROCEDURE_NAME =
           RDB$PROCEDURE_PARAMETERS.RDB$PROCEDURE_NAME)
    WHERE 
       ((RDB$PROCEDURES.RDB$SYSTEM_FLAG = 0)
       or 
          (RDB$PROCEDURES.RDB$SYSTEM_FLAG IS NULL))
    ORDER BY RDB$PROCEDURES.RDB$PROCEDURE_NAME,
             RDB$PROCEDURE_PARAMETERS.RDB$PARAMETER_TYPE,
             RDB$PROCEDURE_PARAMETERS.RDB$PARAMETER_NUMBER;

А, используя информацию из таблиц RDB$FIELDS и RDB$TYPES, можно узнать
типы параметров процедур и др. их характеристики.

    SELECT RDB$PROCEDURES.RDB$PROCEDURE_NAME,
           RDB$PROCEDURES.RDB$PROCEDURE_INPUTS,
           RDB$PROCEDURES.RDB$PROCEDURE_OUTPUTS,
           RDB$PROCEDURE_PARAMETERS.RDB$PARAMETER_NAME,
           RDB$PROCEDURE_PARAMETERS.RDB$PARAMETER_NUMBER,
           RDB$PROCEDURE_PARAMETERS.RDB$PARAMETER_TYPE,
           RDB$PROCEDURE_PARAMETERS.RDB$DESCRIPTION,
           RDB$FIELDS.RDB$FIELD_NAME, RDB$FIELDS.RDB$FIELD_LENGTH,
           RDB$FIELDS.RDB$FIELD_SCALE,
           RDB$FIELDS.RDB$FIELD_TYPE, RDB$FIELDS.RDB$NULL_FLAG,
           RDB$TYPES.RDB$TYPE_NAME
    FROM RDB$PROCEDURES
       LEFT OUTER JOIN RDB$PROCEDURE_PARAMETERS ON
             (RDB$PROCEDURES.RDB$PROCEDURE_NAME =
              RDB$PROCEDURE_PARAMETERS.RDB$PROCEDURE_NAME)
       INNER JOIN RDB$FIELDS ON
             (RDB$PROCEDURE_PARAMETERS.RDB$FIELD_SOURCE =
              RDB$FIELDS.RDB$FIELD_NAME)
       INNER JOIN RDB$TYPES ON
             (RDB$FIELDS.RDB$FIELD_TYPE = RDB$TYPES.RDB$TYPE)
    WHERE 
       (
          ((RDB$PROCEDURES.RDB$SYSTEM_FLAG = 0)
          or 
             (RDB$PROCEDURES.RDB$SYSTEM_FLAG IS NULL))
       and 
          (RDB$TYPES.RDB$FIELD_NAME = 'RDB$FIELD_TYPE')
       )
    ORDER BY RDB$PROCEDURES.RDB$PROCEDURE_NAME, RDB$PROCEDURE_PARAMETERS.RDB$PARAMETER_TYPE,
             RDB$PROCEDURE_PARAMETERS.RDB$PARAMETER_NUMBER;

Функции

Функции позволяют многократно наращивать функциональность InterBase
сервера за счет подключения внешних модулей, выполненных в виде модулей
dll.

Вот так можно получить список функций, зарегистрированных в базе данных.

    SELECT RDB$FUNCTIONS.RDB$FUNCTION_NAME, RDB$FUNCTIONS.RDB$SYSTEM_FLAG
    FROM RDB$FUNCTIONS
    WHERE 
       (
          (RDB$FUNCTIONS.RDB$SYSTEM_FLAG = 0)
       or 
          (RDB$FUNCTIONS.RDB$SYSTEM_FLAG IS NULL)
       );

Следующий запрос возвращает более полную информацию о функциях:
наименование, описание, наименование модуля и точки входа.

    SELECT RDB$FUNCTIONS.RDB$FUNCTION_NAME, RDB$FUNCTIONS.RDB$DESCRIPTION,
           RDB$FUNCTIONS.RDB$MODULE_NAME, RDB$FUNCTIONS.RDB$ENTRYPOINT,
           RDB$FUNCTIONS.RDB$RETURN_ARGUMENT
    FROM RDB$FUNCTIONS
    WHERE 
       (
          (RDB$FUNCTIONS.RDB$SYSTEM_FLAG = 0)
       or 
          (RDB$FUNCTIONS.RDB$SYSTEM_FLAG IS NULL)
       );

Воспользовавшись информацией из таблицы RDB$FUNCTION\_ARGUMENTS, можно
получить сведения об аргументах функций.

    SELECT RDB$FUNCTIONS.RDB$FUNCTION_NAME, RDB$FUNCTIONS.RDB$DESCRIPTION,
           RDB$FUNCTIONS.RDB$MODULE_NAME, RDB$FUNCTIONS.RDB$ENTRYPOINT,
           RDB$FUNCTIONS.RDB$RETURN_ARGUMENT,
           RDB$FUNCTION_ARGUMENTS.RDB$ARGUMENT_POSITION,
           RDB$FUNCTION_ARGUMENTS.RDB$MECHANISM,
           RDB$FUNCTION_ARGUMENTS.RDB$FIELD_TYPE,
           RDB$TYPES.RDB$TYPE_NAME,
           RDB$FUNCTION_ARGUMENTS.RDB$FIELD_LENGTH,
           RDB$FUNCTION_ARGUMENTS.RDB$FIELD_PRECISION
    FROM RDB$FUNCTIONS
       INNER JOIN RDB$FUNCTION_ARGUMENTS ON
        (RDB$FUNCTIONS.RDB$FUNCTION_NAME = RDB$FUNCTION_ARGUMENTS.RDB$FUNCTION_NAME)
       INNER JOIN RDB$TYPES ON
        (RDB$FUNCTION_ARGUMENTS.RDB$FIELD_TYPE = RDB$TYPES.RDB$TYPE)
    WHERE 
       (
          ((RDB$FUNCTIONS.RDB$SYSTEM_FLAG = 0)
          or 
             (RDB$FUNCTIONS.RDB$SYSTEM_FLAG IS NULL))
       and 
          (RDB$TYPES.RDB$FIELD_NAME = 'RDB$FIELD_TYPE')
       )
    ORDER BY RDB$FUNCTIONS.RDB$FUNCTION_NAME,
             RDB$FUNCTION_ARGUMENTS.RDB$ARGUMENT_POSITION;

Следующий пример запроса позволяет получить информацию только по
выходным аргументам функций.

    SELECT RDB$FUNCTIONS.RDB$FUNCTION_NAME, RDB$FUNCTIONS.RDB$DESCRIPTION,
           RDB$FUNCTIONS.RDB$MODULE_NAME, RDB$FUNCTIONS.RDB$ENTRYPOINT,
           RDB$FUNCTIONS.RDB$RETURN_ARGUMENT,
           RDB$FUNCTION_ARGUMENTS.RDB$ARGUMENT_POSITION,
           RDB$FUNCTION_ARGUMENTS.RDB$MECHANISM,
           RDB$FUNCTION_ARGUMENTS.RDB$FIELD_TYPE,
           RDB$TYPES.RDB$TYPE_NAME,
           RDB$FUNCTION_ARGUMENTS.RDB$FIELD_LENGTH,
           RDB$FUNCTION_ARGUMENTS.RDB$FIELD_PRECISION
    FROM RDB$FUNCTIONS
       INNER JOIN RDB$FUNCTION_ARGUMENTS ON
        (RDB$FUNCTIONS.RDB$FUNCTION_NAME = RDB$FUNCTION_ARGUMENTS.RDB$FUNCTION_NAME)
       INNER JOIN RDB$TYPES ON
        (RDB$FUNCTION_ARGUMENTS.RDB$FIELD_TYPE = RDB$TYPES.RDB$TYPE)
    WHERE 
       (
          ((RDB$FUNCTIONS.RDB$SYSTEM_FLAG = 0)
          or 
             (RDB$FUNCTIONS.RDB$SYSTEM_FLAG IS NULL))
       and 
          (RDB$TYPES.RDB$FIELD_NAME = 'RDB$FIELD_TYPE')
       and 
          (RDB$FUNCTIONS.RDB$RETURN_ARGUMENT = RDB$FUNCTION_ARGUMENTS.RDB$ARGUMENT_POSITION)
       )
    ORDER BY RDB$FUNCTIONS.RDB$FUNCTION_NAME,
             RDB$FUNCTION_ARGUMENTS.RDB$ARGUMENT_POSITION;

Здесь же, наоборот, получаем информацию только о входных аргументах
функций.

    SELECT RDB$FUNCTIONS.RDB$FUNCTION_NAME, RDB$FUNCTIONS.RDB$DESCRIPTION,
           RDB$FUNCTIONS.RDB$MODULE_NAME, RDB$FUNCTIONS.RDB$ENTRYPOINT,
           RDB$FUNCTIONS.RDB$RETURN_ARGUMENT,
           RDB$FUNCTION_ARGUMENTS.RDB$ARGUMENT_POSITION,
           RDB$FUNCTION_ARGUMENTS.RDB$MECHANISM,
           RDB$FUNCTION_ARGUMENTS.RDB$FIELD_TYPE,
           RDB$TYPES.RDB$TYPE_NAME,
           RDB$FUNCTION_ARGUMENTS.RDB$FIELD_LENGTH,
           RDB$FUNCTION_ARGUMENTS.RDB$FIELD_PRECISION
    FROM RDB$FUNCTIONS
       INNER JOIN RDB$FUNCTION_ARGUMENTS ON
        (RDB$FUNCTIONS.RDB$FUNCTION_NAME = RDB$FUNCTION_ARGUMENTS.RDB$FUNCTION_NAME)
       INNER JOIN RDB$TYPES ON
        (RDB$FUNCTION_ARGUMENTS.RDB$FIELD_TYPE = RDB$TYPES.RDB$TYPE)
    WHERE 
       (
          ((RDB$FUNCTIONS.RDB$SYSTEM_FLAG = 0)
          or 
             (RDB$FUNCTIONS.RDB$SYSTEM_FLAG IS NULL))
       and 
          (RDB$TYPES.RDB$FIELD_NAME = 'RDB$FIELD_TYPE')
       and 
          (RDB$FUNCTIONS.RDB$RETURN_ARGUMENT <>
           RDB$FUNCTION_ARGUMENTS.RDB$ARGUMENT_POSITION)
       )
    ORDER BY RDB$FUNCTIONS.RDB$FUNCTION_NAME,
             RDB$FUNCTION_ARGUMENTS.RDB$ARGUMENT_POSITION;

Генераторы

Генераторы позволяют гарантированно получать уникальные значения из
какой-либо последовательности. Обычно это используется для заполнения
ключевых полей.

Следующий запрос позволяет получить перечень генераторов, созданных
пользователями.

     
    SELECT RDB$GENERATORS.RDB$GENERATOR_NAME,
           RDB$GENERATORS.RDB$SYSTEM_FLAG
    FROM RDB$GENERATORS
    WHERE 
       ((RDB$GENERATORS.RDB$SYSTEM_FLAG = 0)
       or 
          (RDB$GENERATORS.RDB$SYSTEM_FLAG IS NULL ));

А так можно узнать текущее значение генератора (EMP\_NO\_GEN).

    SELECT DISTINCT GEN_ID(EMP_NO_GEN, 0) FROM RDB$GENERATORS;

Исключения

Исключения представляют собой созданные пользователем ошибки с
сопоставленным текстом. Их можно использовать в теле триггеров или
процедур при возникновении какой-либо ошибки.

Данный запрос позволяет получить перечень исключений с сообщениями,
которые за ними закреплены.

    SELECT RDB$EXCEPTIONS.RDB$EXCEPTION_NAME,
           RDB$EXCEPTIONS.RDB$EXCEPTION_NUMBER,
           RDB$EXCEPTIONS.RDB$MESSAGE, RDB$EXCEPTIONS.RDB$SYSTEM_FLAG
    FROM RDB$EXCEPTIONS
    WHERE 
       ((RDB$EXCEPTIONS.RDB$SYSTEM_FLAG = 0)
       or 
          (RDB$EXCEPTIONS.RDB$SYSTEM_FLAG IS NULL));

Зависимости

В базе данных одни объекты могут зависеть от других (на пример, хранимая
процедура от таблицы, на поля которой ссылается). Поэтому сервер всегда
отслеживает подобные зависимости и не допускает удаление объектов, от
которых зависят другие объекты базы данных. Основная информация о
зависимостях хранится в таблице RDB$DEPENDENCIES.

Приведенный ниже запрос отображает зависимость объектов
(RDB$DEPENDENT\_NAME) от других объектов (RDB$DEPENDED\_ON\_NAME), а
так же возвращает перечень полей, которые образуют эту зависимость
(RDB$FIELD\_NAME).

    SELECT RDB$DEPENDENCIES.RDB$DEPENDENT_NAME, RDB$TYPES.RDB$TYPE_NAME,
           RDB$DEPENDENCIES.RDB$DEPENDED_ON_NAME,
           RDB$TYPES1.RDB$TYPE_NAME,
           RDB$DEPENDENCIES.RDB$FIELD_NAME,
           RDB$DEPENDENCIES.RDB$DEPENDENT_TYPE,
           RDB$DEPENDENCIES.RDB$DEPENDED_ON_TYPE
    FROM RDB$DEPENDENCIES
       INNER JOIN RDB$TYPES ON
        (RDB$DEPENDENCIES.RDB$DEPENDENT_TYPE = RDB$TYPES.RDB$TYPE)
       INNER JOIN RDB$TYPES RDB$TYPES1 ON
        (RDB$DEPENDENCIES.RDB$DEPENDED_ON_TYPE = RDB$TYPES1.RDB$TYPE)
    WHERE 
       ((RDB$TYPES.RDB$FIELD_NAME = 'RDB$OBJECT_TYPE')
       and 
        (RDB$TYPES1.RDB$FIELD_NAME = 'RDB$OBJECT_TYPE'))
    ORDER BY RDB$DEPENDENCIES.RDB$DEPENDENT_NAME, RDB$DEPENDENCIES.RDB$DEPENDED_ON_NAME;

Пользователи

Получать информацию из базы данных могут далеко не все, а только
зарегистрированные пользователи, обладающие определенными правами на
объекты базы данных. В последних версиях InterBase список пользователей
храниться в базе данных admin.ib (в более ранних версиях в Isc4.gdb).

Вот так можно получить перечень пользователей базы данных.

SELECT USER\_NAME, FIRST\_NAME, MIDDLE\_NAME, LAST\_NAME

FROM USERS

ORDER BY USER\_NAME;

Из таблицы rdb$roles можно получить перечень ролей.

SELECT * from rdb$roles;

Привилегии могут выдаваться пользователям, ролям и другим объектам базы
данных. Приведенный ниже запрос возвращает информацию о том, кому
(RDB$USER\_PRIVILEGES.RDB$USER), кто
(RDB$USER\_PRIVILEGES.RDB$GRANTOR), какую привилегию
(RDB$USER\_PRIVILEGES.RDB$PRIVILEGE) и на какой объект
(RDB$USER\_PRIVILEGES.RDB$RELATION\_NAME) выдал. Также возвращается
информация о том, может ли получивший привилегию объект передать ее
другому (RDB$USER\_PRIVILEGES.RDB$GRANT\_OPTION), а также указывается,
на весь объект была дана привилегия или на его часть
(RDB$USER\_PRIVILEGES.RDB$FIELD\_NAME).

    SELECT RDB$USER_PRIVILEGES.RDB$USER, RDB$USER_PRIVILEGES.RDB$GRANTOR,
           RDB$USER_PRIVILEGES.RDB$PRIVILEGE,
           RDB$USER_PRIVILEGES.RDB$GRANT_OPTION,
           RDB$USER_PRIVILEGES.RDB$RELATION_NAME,
           RDB$USER_PRIVILEGES.RDB$FIELD_NAME,
           RDB$TYPES.RDB$TYPE_NAME, RDB$TYPES1.RDB$TYPE_NAME
    FROM RDB$USER_PRIVILEGES
       INNER JOIN RDB$TYPES ON
        (RDB$USER_PRIVILEGES.RDB$USER_TYPE = RDB$TYPES.RDB$TYPE)
       INNER JOIN RDB$TYPES RDB$TYPES1 ON
        (RDB$USER_PRIVILEGES.RDB$OBJECT_TYPE = RDB$TYPES1.RDB$TYPE)
    WHERE 
       ((RDB$TYPES.RDB$FIELD_NAME = 'RDB$OBJECT_TYPE')
       and 
          (RDB$TYPES1.RDB$FIELD_NAME = 'RDB$OBJECT_TYPE'))
    ORDER BY RDB$USER_PRIVILEGES.RDB$USER;

Аналогичный запрос, но возвращает информацию только для ролей (какие
привилегии выданы ролям).

    SELECT RDB$USER_PRIVILEGES.RDB$USER, RDB$USER_PRIVILEGES.RDB$GRANTOR,
           RDB$USER_PRIVILEGES.RDB$PRIVILEGE,
           RDB$USER_PRIVILEGES.RDB$GRANT_OPTION,
           RDB$USER_PRIVILEGES.RDB$RELATION_NAME,
           RDB$USER_PRIVILEGES.RDB$FIELD_NAME, RDB$TYPES.RDB$TYPE_NAME,
           RDB$TYPES1.RDB$TYPE_NAME
    FROM RDB$USER_PRIVILEGES
       INNER JOIN RDB$TYPES ON
        (RDB$USER_PRIVILEGES.RDB$USER_TYPE = RDB$TYPES.RDB$TYPE)
       INNER JOIN RDB$TYPES RDB$TYPES1 ON
        (RDB$USER_PRIVILEGES.RDB$OBJECT_TYPE = RDB$TYPES1.RDB$TYPE)
       INNER JOIN RDB$ROLES ON
        (RDB$USER_PRIVILEGES.RDB$USER = RDB$ROLES.RDB$ROLE_NAME)
    WHERE 
       (
          (RDB$TYPES.RDB$FIELD_NAME = 'RDB$OBJECT_TYPE')
       and 
          (RDB$TYPES1.RDB$FIELD_NAME = 'RDB$OBJECT_TYPE')
       and 
          (RDB$ROLES.RDB$ROLE_NAME = RDB$USER_PRIVILEGES.RDB$USER)
       )
    ORDER BY RDB$USER_PRIVILEGES.RDB$USER;

Вот так можно посмотреть, какие привилегии даны триггерам.

    SELECT RDB$USER_PRIVILEGES.RDB$USER, RDB$USER_PRIVILEGES.RDB$GRANTOR,
           RDB$USER_PRIVILEGES.RDB$PRIVILEGE,
           RDB$USER_PRIVILEGES.RDB$GRANT_OPTION,
           RDB$USER_PRIVILEGES.RDB$RELATION_NAME,
           RDB$USER_PRIVILEGES.RDB$FIELD_NAME,
           RDB$TYPES.RDB$TYPE_NAME, RDB$TYPES1.RDB$TYPE_NAME
    FROM RDB$USER_PRIVILEGES
       INNER JOIN RDB$TYPES ON
        (RDB$USER_PRIVILEGES.RDB$USER_TYPE = RDB$TYPES.RDB$TYPE)
       INNER JOIN RDB$TYPES RDB$TYPES1 ON
        (RDB$USER_PRIVILEGES.RDB$OBJECT_TYPE = RDB$TYPES1.RDB$TYPE)
    WHERE 
       ((RDB$TYPES.RDB$FIELD_NAME = 'RDB$OBJECT_TYPE')
       and 
          (RDB$TYPES1.RDB$FIELD_NAME = 'RDB$OBJECT_TYPE')
       and 
          (RDB$TYPES.RDB$TYPE_NAME = 'TRIGGER'))
    ORDER BY RDB$USER_PRIVILEGES.RDB$USER;

Следующий запрос показывает, привилегии каких ролей каким пользователям
выданы.

    SELECT RDB$USER_PRIVILEGES.RDB$USER, RDB$USER_PRIVILEGES.RDB$GRANTOR,
           RDB$USER_PRIVILEGES.RDB$PRIVILEGE,
           RDB$USER_PRIVILEGES.RDB$GRANT_OPTION,
           RDB$USER_PRIVILEGES.RDB$RELATION_NAME,
            RDB$USER_PRIVILEGES.RDB$FIELD_NAME,
           RDB$TYPES.RDB$TYPE_NAME, RDB$TYPES1.RDB$TYPE_NAME
    FROM RDB$USER_PRIVILEGES
       INNER JOIN RDB$TYPES ON
        (RDB$USER_PRIVILEGES.RDB$USER_TYPE = RDB$TYPES.RDB$TYPE)
       INNER JOIN RDB$TYPES RDB$TYPES1 ON
        (RDB$USER_PRIVILEGES.RDB$OBJECT_TYPE = RDB$TYPES1.RDB$TYPE)
       INNER JOIN RDB$ROLES ON
        (RDB$USER_PRIVILEGES.RDB$RELATION_NAME = RDB$ROLES.RDB$ROLE_NAME)
    WHERE 
       ((RDB$TYPES.RDB$FIELD_NAME = 'RDB$OBJECT_TYPE')
       and 
          (RDB$TYPES1.RDB$FIELD_NAME = 'RDB$OBJECT_TYPE'))
    ORDER BY RDB$USER_PRIVILEGES.RDB$USER;
