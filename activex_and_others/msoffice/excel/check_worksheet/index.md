---
Title: Как узнать существует ли страница (worksheet)?
Date: 01.01.2007
---


Как узнать существует ли страница (worksheet)?
==============================================

::: {.date}
01.01.2007
:::

    { ... }
    WB := Excel.Workbooks[1];
    for Idx := 1 to WB.Worksheets.Count do
      if WB.Worksheets[Idx].Name = 'first' then
        Showmessage('Found the worksheet');
    { ... }

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
