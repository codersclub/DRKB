Как получить текущую дату?
==========================

::: {.date}
01.01.2007
:::

    // make the SQL dependent on type of DBMS
     
    if AppLibrary.Database.DriverName = 'ORACLE' then
      SQL.Add('and entry_date < SYSDATE')
    else
      SQL.Add('and entry_date < "TODAY"');
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
