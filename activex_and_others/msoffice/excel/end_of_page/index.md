---
Title: Как вставить конец страницы?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как вставить конец страницы?
============================

    { ... }
    Excel.ActiveWindow.View := xlPageBreakPreview;
    WS.HPageBreaks.Add(WS.Cells.Item[78, 1]);
    { ... }

