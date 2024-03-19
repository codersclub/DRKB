---
Title: Как восстановить целостность автоинкрементного поля?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как восстановить целостность автоинкрементного поля?
====================================================

Problem/Question/Abstract:

Recently I got unique key violations during insert attempts on a piece
of code that used to work (what can go bad, will go bad). I found that
the offending field - was actually created by a generator. For some
reason the generator returned values that where already in the database.

- how can I display the current value of the generator?
- how can I adjust the value of the generator?

**Answer:**

See the example (table name is SD\_LOAD, generator name is
GEN\_SD\_LOAD).

**Note:**

You cannot modify the value of the generator inside of a trigger or
stored procedure. You only can call the gen\_id() function to increment
the value in a generator. The SET GENERATOR command will only work
outside of a stored procedure or trigger.

    SELECT DISTINCT(GEN_ID(gen_sd_load, 0)) FROM sd_load

    set GENERATOR gen_sd_load to 2021819

