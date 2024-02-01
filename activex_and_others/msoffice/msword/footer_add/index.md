---
Title: Как добавить текст в footer документа?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как добавить текст в footer документа?
======================================


Footer:

    { ... }
    aDoc := WordApp.Documents.Add(EmptyParam, EmptyParam);
    aDoc.Sections.Item(1).Footers.Item(wdHeaderFooterPrimary).Range.Text :=
      'This is a footer';
    { ... }

