---
Title: Дата в SQL запросах в MS Access
Author: Vit
Date: 01.01.2007
---


Дата в SQL запросах в MS Access
===============================

Для указания дат используйте символ #:

    SELECT Students.Name,Students.BirthDate,Teachers.Name 
    FROM Teachers 
    INNER JOIN Students ON Students.TeacherID=Teachers.ID 
    WHERE Students.BirthDate BETWEEN #09/02/87# AND #01/01/00#
