---
Title: How to open a report
Date: 01.01.2007
---


How to open a report
====================

::: {.date}
01.01.2007
:::

Access.DoCmd.OpenReport(\'Titles by Author\', acViewPreview, EmptyParam,
EmptyParam);

{

const

   acViewNormal = $00000000;

   acViewDesign = $00000001;

   acViewPreview = $00000002;

}
