---
Title: Посчитать события по месяцам
Author: Vit
Date: 01.01.2007
---


Посчитать события по месяцам
============================

    SELECT
        YEAR([MyDateFiled]),
        MONTH([MyDateFiled]),
        COUNT(*)
    FROM [SomeTable]
    GROUP BY
        YEAR([MyDateFiled]),
        MONTH([MyDateFiled])

