---
Title: Как вставить конец страницы?
Date: 01.01.2007
---


Как вставить конец страницы?
============================

::: {.date}
01.01.2007
:::

    { ... }
    Excel.ActiveWindow.View := xlPageBreakPreview;
    WS.HPageBreaks.Add(WS.Cells.Item[78, 1]);
    { ... }

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
