---
Title: Проверить, существует ли индекс
Author: Vit
Date: 01.01.2007
---


Проверить, существует ли индекс
===============================

::: {.date}
01.01.2007
:::

      if exists(
        SELECT *
        FROM sysobjects o 
        INNER JOIN sysindexes i 
          ON o.id = i.id
        WHERE o.xtype = 'U' AND 
              i.indid > 0 AND 
              i.indid < 255 AND 
              INDEXPROPERTY(i.id, @IndexName, 'isStatistics') = 0 AND 
              o.name = @TableName)
        Set @exists=1
      else
        Set @exists=0 

Автор: Vit
