---
Title: Динамические SQL-запросы Oracle для ускорения выборок данных
Author: Андрей Фионик\
Date: 01.01.2007
---


Динамические SQL-запросы Oracle для ускорения выборок данных
============================================================

::: {.date}
01.01.2007
:::

Типичная задача при работе с базами данных -- выбрать информацию из
разных таблиц, отфильтровать ее по определенным критериям, потом
обработать и/или выдать пользователю для просмотра и визуального
анализа. Если параметры отбора записей имеются в наличии и определены --
эта задача решается тривиально, с помощью обычного оператора sql
"select... from... where..." - где набор условий, располагаемых после
where, всегда определен. Однако, бывают случаи, когда набор параметров
отбора данных определяется только перед самим отбором - а изначально, во
время проектирования программы, не известен.\
Например, надо выбрать клиентов, "засветившихся" в базе данных торговой
фирмы за определенный срок; или сделавших покупки на сумму больше
некоторой заданной.\
Или приходится искать конкретного человека, используя частично известные
анкетные данные...\
Ситуация усложняется еще больше, если для определения, какие записи
нужно выбрать, а какие нет, надо вызывать какую-нибудь функцию,
реализующую сложные и ресурсоемкие вычисления. Разумеется, эту функцию
без необходимости лучше в обработку не включать...\
 \
Все перечисленные проблемы можно решить с помощью динамического sql.\
Динамический sql позволяет строить текст запроса непосредственно внутри
кода pl/sql - и затем выполнять его. Соответственно, разработчик может
построить текст запроса, включая в него только необходимые,
задействованные в текущий момент условия (случай, когда текст
sql-запроса может быть сформирован внутри клиентского приложения,
рассматривать не будем - всегда существуют ситуации, когда этого нельзя
сделать по каким-нибудь причинам).\
 \
За работу с динамическими sql -запросами отвечает пакет dbms\_sql. В
общем, работа с ним происходит по следующей схеме.\
1. Строится сам текст запроса с метками для параметров. Текст запроса
может быть представлен в виде строки или коллекции строк.\
2. Функцией dbms\_sql.open\_cursor выделяется идентификатор курсора,
который будет использоваться для работы с запросом. Идентификатор
ссылается на внутреннюю структуру oracle, определяющую курсор. Этот
идентификатор используется процедурами пакета dbms\_sql.\
3. Выполняется разбор текста запроса. dbms\_sql.parse.\
4. Устанавливаются значения параметров запроса.
dbms\_sql.bind\_variable.\
5. Если запрос возвращает данные, то определяются столбцы и буферные
переменные, в которых будут размещаться возвращаемые данные.
dbms\_sql.define\_column.\
6. Запрос выполняется. dbms\_sql.execute.\
7. Если запрос возвращает данные, то производится выборка данных из
курсора и необходимая их обработка. dbms\_sql.fetch\_rows,
dbms\_sql.column\_value.\
8. Курсор закрывается. dbms\_sql.close\_cursor.\
 \
Ниже мы рассмотрим пример использования динамического sql для поиска
человека по (неполным) анкетным данным.\
 \
Вначале определимся с используемыми структурами данных.\
 \
create table personparticulars\
(id number(9) constraint pk\_personparticulars primary key not null,\
family varchar2(32) constraint pp\_chk\_family not null,\
firstname varchar2(16) constraint pp\_chk\_firstname not null\
)\
tablespace x;\
 \
Поля таблицы personparticulars:\
 \
· id -- уникальный номер анкетных данных\
· family -- фамилия\
· firstname -- имя\
· middlename -- отчество\
 \
Процесс получения результатов разобьем на две части: построение текста
sql-запроса и, собственно, его выполнение. Можно оформить это как две
хранимые процедуры, можно как одну - пусть разработчик сам решает. Текст
sql-запроса можно формировать как в одну строку, так и в виде коллекции
- на случай, если текст окажется слишком длинным. В нашем случае будем
использовать коллекцию - несмотря на то, что длина текста запроса будет
небольшой. Зачем? А просто так, для примера.\
Условимся также, что в хранимую процедуру будут передаваться следующие
параметры, управляющие поиском:\
 \
· familyfilter -- шаблон для поиска по фамилии\
· firstnamefilter -- шаблон для поиска по имени\
· middlenamefilter -- шаблон для поиска по отчеству\
 \
Если в качестве какого-либо из параметров передано значение null -- этот
параметр при поиске игнорируем.\

Результаты поиска вернем в виде таблицы в памяти. Для простоты - это
будут просто номера найденных людей (значения их id).

    create or replace procedure searchperson(
      familyfilter in varchar2, 
      firstnamefilter in varchar2, 
      middlenamefilter in varchar2, 
      result in out dbms_sql.varchar2s) is
    sqltext dbms_sql.varchar2s; /* Текст запроса */
    whereclause dbms_sql.varchar2s; /* Часть … where… */
    i integer; /* Счетчик */
    c integer; /* Идентификатор курсора */
    b_id number; /* Буферная переменная для результатов */
    begin
    whereclause(1):=’true ‘;
    if familyfilter is not null then
    whereclause(whereclause.last+1):=’ and family like :xfamilyfilter’;
    end if;
    if firstnamefilter is not null then
    whereclause(whereclause.last+1):=’ and firstname like :xfirstnamefilter’;
    end if;
    if middlenamefilter is not null then
    whereclause(whereclause.last+1):=’ and middlename like :xmiddlenamefilter’;
    end if;
    /* На этом этапе у нас имеется часть запроса - where, в которой упомянуты только те условия, которые были заданы через непустые параметры хранимой процедуры */
    /* Теперь построим текст запроса полностью */
    sqltext(1):=’select id’;
    sqltext(2):=’from personparticulars’;
    for i in whereclause.first..whereclause.last loop
    sqltext(sqltext.last+1):=whereclause(i);
    end loop;
    /* Получаем идентификатор курсора */
    c:=dbms_sql.open_cursor;
    /* Разборка текста запроса */
    dbms_sql.parse(c, sqltext, sqltext.first, sqltext.last, false, dbms_sql.native);
    /* Установка параметров запроса */
    if familyfilter is not null then
    dbms_sql.bind_variable(c,’:xfamilyfilter’,familyfilter);
    end if;
    if firstnamefilter is not null then
    dbms_sql.bind_variable(c,’:xfirstnamefilter’,firstnamefilter);
    end if;
    if middlenamefilter is not null then
    dbms_sql.bind_variable(c,’:xmiddlenamefilter’,middlenamefilter);
    end if;
    /* Установка столбцов в запросе */
    dbms_sql.define_column(c,1,b_id);
    /* Выполнение запроса */
    dbms_sql.execute(c);
    /* Выборка результатов запроса */
    loop
    /* Выбираем следующую строку */
    if dbms_sql.fetch_rows(c)>0 then
    dbms_sql.column_value(c,1,b_id);
    /* В этот момент в переменной b_id имеем текущее значение id очередной строки. Что с ней делать, уже дело разработчика */
    else
    exit; /* Если нет больше строк, вываливаемся */
    end if;
    end loop;
    /* Закрываем курсор */
    dbms_sql.close_cursor(c);
    end; 

 \
 \
Надеюсь, основные идеи понятны?\
Дальше -- сами :)\
 \
Использованная литература: oracle8 application developer's guide ©
oracle corporation\
 \
Автор: Андрей Фионик\
Источник:\
<https://doc.woweb.ru>