---
Title: Получить список индексов таблицы
Author: Vit
Date: 01.01.2007
---


Получить список индексов таблицы
================================

    SELECT i.name AS index_name
    FROM sysobjects o 
    INNER JOIN sysindexes i ON o.id = i.id
    WHERE o.xtype = 'U' AND i.indid > 0 AND 
          i.indid < 255 AND INDEXPROPERTY(i.id, i.name, 'isStatistics') = 0  AND 
          o.name = @TableName
    ORDER BY i.indid
