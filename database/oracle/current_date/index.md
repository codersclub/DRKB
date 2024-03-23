---
Title: Как получить текущую дату?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как получить текущую дату?
==========================

    // make the SQL dependent on type of DBMS
     
    if AppLibrary.Database.DriverName = 'ORACLE' then
      SQL.Add('and entry_date < SYSDATE')
    else
      SQL.Add('and entry_date < "TODAY"');
    end;

