---
Title: Как получить текущее время?
Date: 01.01.2007
---


Как получить текущее время?
===========================

::: {.date}
01.01.2007
:::

InterBase supports four DATE literals. They are: \'today\',
\'yesterday\', \'tomorrow\' and \'now\'

Use it with a cast as shown in the example below.

insert into mytable values(cast(\'now\' as DATE), \'Test\')

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
