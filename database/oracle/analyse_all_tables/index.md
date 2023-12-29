---
Title: Как заставить ORACLE анализировать все таблицы?
Date: 01.01.2007
---


Как заставить ORACLE анализировать все таблицы?
===============================================

::: {.date}
01.01.2007
:::

Конечно, можно использовать dbms\_sql, dbms\_job...

А можно и так:

 

    #!/bin/sh
    #
    # analyze all tables
    #
     
    sqlfile=/tmp/analyze.sql
    logfile=/tmp/analyze.log
     
    echo @connect dbo/passwd@ > $sqlfile
     
    $oracle_home/bin/svrmgrl <> $sqlfile
    connect dbo/passwd
    select 'table', table_name from all_tables where owner = 'dbo';
    eof
     
    echo exit >> $sqlfile
    cat $sqlfile > $logfile
     
    cat $sqlfile | $oracle_home/bin/svrmgrl >> $logfile
     
    cat $logfile | /usr/bin/mailx -s 'analyze tables' tlk@nbd.kis.ru
     
    rm $sqlfile
    rm $logfile



Источник: <https://www.codenet.ru>
