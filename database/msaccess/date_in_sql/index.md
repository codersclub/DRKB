---
Title: Дата в SQL запросах в MS Access
Author: Vit
Date: 01.01.2007
---


Дата в SQL запросах в MS Access
===============================

::: {.date}
01.01.2007
:::

Для дат используйте #:

    SELECT Students.Name,Students.BirthDate,Teachers.Name 
    FROM Teachers 
    INNER JOIN Students ON Students.TeacherID=Teachers.ID 
    WHERE Students.BirthDate BETWEEN #09/02/87# AND #01/01/00#

Автор: Vit
