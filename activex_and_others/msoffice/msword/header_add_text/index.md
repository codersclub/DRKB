---
Title: Как добавить текст в header документа?
Date: 01.01.2007
---


Как добавить текст в header документа?
======================================

::: {.date}
01.01.2007
:::

    { ... }
    aDoc := WordApp.Documents.Add(EmptyParam, EmptyParam);
    aDoc.Sections.Item(1).Headers.Item(wdHeaderFooterPrimary).Range.Text :=
      'This is a header';
    { ... }

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
